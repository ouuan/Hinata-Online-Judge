<?php
requirePHPLib('form');

if (!isSuperUser($myUser)) {
	become403Page();
}
$time_form = new UOJForm('time');
$time_form->addInput(
	'name',
	'text',
	'比赛标题',
	'New Contest',
	function () {
		return '';
	},
	null
);
$time_form->addInput(
	'start_time',
	'text',
	'开始时间',
	date("Y-m-d H:i:s"),
	function ($str, &$vdata) {
		try {
			$vdata['start_time'] = new DateTime($str);
		} catch (Exception $e) {
			return '无效时间格式';
		}
		return '';
	},
	null
);
$time_form->addInput(
	'last_min',
	'text',
	'时长（单位：分钟）',
	180,
	function ($str) {
		return !validateUInt($str) ? '必须为一个整数' : '';
	},
	null
);
$time_form->handle = function (&$vdata) {
	$start_time_str = $vdata['start_time']->format('Y-m-d H:i:s');

	$purifier = HTML::pruifier();

	$esc_name = $_POST['name'];
	$esc_name = $purifier->purify($esc_name);
	$esc_name = DB::escape($esc_name);

	DB::query("insert into contests (name, start_time, last_min, status) values ('$esc_name', '$start_time_str', ${_POST['last_min']}, 'unfinished')");

	$notification_users = DB::selectAll("select username,email from user_info where opt_new_contest_mail = true");

	if (count($notification_users)) {
		$oj_name = UOJConfig::$data['profile']['oj-name'];
		$oj_name_short = UOJConfig::$data['profile']['oj-name-short'];
		$url = HTML::url('/');
		$contests_url = HTML::url('/contests');

		$mailer = UOJMail::noreply();
		$mailer->addAddress(UOJConfig::$data['mail']['noreply']['username'], UOJConfig::$data['profile']['oj-name-short'] . " new contest subscribers");
		foreach ($notification_users as $user) {
			$mailer->addBCC($user['email'], $user['username']);
		}
		$mailer->Subject = $oj_name_short . ' 新比赛通知: ' . $_POST['name'];
		$unsubText = UOJMail::unsubscribeText();

		$mailer->msgHTML(
			<<<EOD
			<p>{$oj_name_short} 用户:</p>
			<p>您好！</p>
			<p>{$_POST['name']} 将在 {$start_time_str} 举办。您可以查看 <a href="{$contests_url}">比赛列表</a> 并注册。</p>
			{$unsubText}
			<p><a href="{$url}">{$oj_name}</a></p>
EOD
		);

		for ($i = 0; $i < 3; ++$i) {
			if ($mailer->send()) return;
		}

		becomeMsgPage("发送新比赛通知失败: " . $mailer->ErrorInfo);
	}
};
$time_form->succ_href = "/contests";
$time_form->runAtServer();
?>
<?php echoUOJPageHeader('添加比赛') ?>
<h1 class="page-header">添加比赛</h1>
<div class="tab-pane active" id="tab-time">
	<?php
	$time_form->printHTML();
	?>
</div>
<?php echoUOJPageFooter() ?>
