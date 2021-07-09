<?php
function handleRegisterPost()
{
	if (!crsf_check()) {
		return '页面已过期';
	}
	if (!isset($_POST['username'])) {
		return "无效表单";
	}
	if (!isset($_POST['email'])) {
		return "无效表单";
	}

	$username = $_POST['username'];
	$email = $_POST['email'];

	if (!validateUsername($username)) {
		return "失败：无效用户名。";
	}
	if (queryUser($username)) {
		return "失败：用户名已存在。";
	}
	if (!validateEmail($email)) {
		return "失败：无效电子邮箱。";
	}

	$original_password = uojRandString(12);

	$oj_name = UOJConfig::$data['profile']['oj-name'];
	$oj_name_short = UOJConfig::$data['profile']['oj-name-short'];
	$login_url = HTML::url("/login");
	$modify_url = HTML::url("/user/modify-profile");
	$admin_mail = UOJConfig::$data['profile']['admin-email'];
	$mail_content = <<<EOD
<p>{$username} 您好，</p>
<p>欢迎来到 {$oj_name}！</p>
<p>您的初始密码是: {$original_password}</p>
<p>本 OJ 的注册需要经过管理员同意，请在机房联系管理员或者教练，或者通过邮件联系 <a href="mailto:{$admin_mail}">{$admin_mail}</a>。<p>
<p>成功 <a href="{$login_url}">登录</a> 后请立即 <a href="${modify_url}">修改密码</a>。</p>
<p>{$oj_name}</p>
EOD;

	$mailer = UOJMail::noreply();
	$mailer->addAddress($email, $username);
	$mailer->Subject = $oj_name_short . " 新用户注册";
	$mailer->msgHTML($mail_content);
	if (!$mailer->send()) {
		error_log($mailer->ErrorInfo);
		return '邮件发送失败，请重试或联系管理员';
	}

	$password_hash = hash_hmac('md5', $original_password, UOJConfig::$data['security']['user']['client_salt']);
	$password = getPasswordToStore($password_hash, $username);

	$esc_email = DB::escape($email);

	$svn_pw = uojRandString(10);
	if (!DB::selectCount("SELECT COUNT(*) FROM user_info"))
		DB::query("insert into user_info (username, email, password, svn_password, register_time, usergroup) values ('$username', '$esc_email', '$password', '$svn_pw', now(), 'S')");
	else
		DB::query("insert into user_info (username, email, password, svn_password, register_time, usergroup) values ('$username', '$esc_email', '$password', '$svn_pw', now(), 'B')");

	return "欢迎你，" . $username . "！请在邮箱中查看密码并联系管理员通过注册申请。";
}

if (isset($_POST['register'])) {
	echo handleRegisterPost();
	die();
} elseif (isset($_POST['check_username'])) {
	$username = $_POST['username'];
	if (validateUsername($username) && !queryUser($username)) {
		echo '{"ok" : true}';
	} else {
		echo '{"ok" : false}';
	}
	die();
}
?>
<?php
$REQUIRE_LIB['md5'] = '';
$REQUIRE_LIB['dialog'] = '';
?>
<?php echoUOJPageHeader(UOJLocale::get('register')) ?>
<h2 class="page-header"><?= UOJLocale::get('register') ?></h2>
<form id="form-register" class="form-horizontal">
	<div id="div-email" class="form-group">
		<label for="input-email" class="col-sm-6 control-label"><?= UOJLocale::get('email') ?> (<?= UOJLocale::get('wrong email') ?>)</label>
		<div class="col-sm-3">
			<input type="email" class="form-control" id="input-email" name="email" placeholder="<?= UOJLocale::get('enter your email') ?>" maxlength="50" />
			<span class="help-block" id="help-email"></span>
		</div>
	</div>
	<div id="div-username" class="form-group">
		<label for="input-username" class="col-sm-2 control-label"><?= UOJLocale::get('username') ?></label>
		<div class="col-sm-3">
			<input type="text" class="form-control" id="input-username" name="username" placeholder="<?= UOJLocale::get('enter your username') ?>" maxlength="20" />
			<span class="help-block" id="help-username"></span>
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-3">
			<button type="submit" id="button-submit" class="btn btn-secondary"><?= UOJLocale::get('submit') ?></button>
		</div>
	</div>
</form>

<script type="text/javascript">
	function checkUsernameNotInUse() {
		var ok = false;
		$.ajax({
			url: '/register',
			type: 'POST',
			dataType: 'json',
			async: false,

			data: {
				check_username: '',
				username: $('#input-username').val()
			},
			success: function(data) {
				ok = data.ok;
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest.responseText);
				ok = false;
			}
		});
		return ok;
	}

	function validateRegisterPost() {
		var ok = true;
		ok &= getFormErrorAndShowHelp('email', validateEmail);
		ok &= getFormErrorAndShowHelp('username', function(str) {
			var err = validateUsername(str);
			if (err)
				return err;
			if (!checkUsernameNotInUse())
				return '该用户名已被人使用了。';
			return '';
		})
		return ok;
	}

	function submitRegisterPost() {
		if (!validateRegisterPost()) {
			return;
		}

		$.post('/register', {
			_token: "<?= crsf_token() ?>",
			register: '',
			username: $('#input-username').val(),
			email: $('#input-email').val(),
		}, function(msg) {
			if (/^欢迎你/.test(msg)) {
				BootstrapDialog.show({
					title: '注册成功',
					message: msg,
					type: BootstrapDialog.TYPE_SUCCESS,
					buttons: [{
						label: '好的',
						action: function(dialog) {
							dialog.close();
						}
					}],
					onhidden: function(dialog) {
						var prevUrl = document.referrer;
						if (!prevUrl) {
							prevUrl = '/';
						};
						window.location.href = prevUrl;
					}
				});
			} else {
				BootstrapDialog.show({
					title: '注册失败',
					message: msg,
					type: BootstrapDialog.TYPE_DANGER,
					buttons: [{
						label: '好的',
						action: function(dialog) {
							dialog.close();
						}
					}],
				});
			}
		});
	}
	$(document).ready(function() {
		$('#form-register').submit(function(e) {
			submitRegisterPost();
			return false;
		});
	});
</script>
<?php echoUOJPageFooter() ?>
