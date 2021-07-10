<?php

requirePHPLib('form');

$options_form = new UOJForm('options');
$options = array();

function addOption($name, $title, bool $default)
{
	global $options_form, $options;
	$options_form->addCheckBox("opt_" . $name, $title, getUserOption(Auth::id(), $name, $default));
	$options[] = $name;
}

addOption('sys_msg_mail', '收到系统通知时通过邮件提醒', false);
addOption('user_msg_mail', '收到私信时通过邮件提醒', false);
addOption('new_contest_mail', '有新比赛时通过邮件提醒', false);

$options_form->handle = function () {
	global $options;
	foreach ($options as $opt) {
		if ($_POST['opt_' . $opt] === 'on')
			setUserOption(Auth::id(), $opt, true);
		else setUserOption(Auth::id(), $opt, false);
	}
};

$options_form->runAtServer();

echoUOJPageHeader('修改设置');

echo '<h2 class="pb-2">更改设置</h2>';

$options_form->printHTML();

echoUOJPageFooter();
