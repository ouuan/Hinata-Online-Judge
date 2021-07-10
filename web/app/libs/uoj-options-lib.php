<?php

function ensureUserOptionExists($optionName)
{
	if (!DB::selectFirst("select opt_{$optionName} from user_info")) {
		DB::update("alter table user_info add opt_{$optionName} tinyint default -1");
	}
}

function getUserOption($username, $optionName, $default)
{
	ensureUserOptionExists($optionName);
	$result = DB::selectFirst("select opt_{$optionName} from user_info where username = '{$username}'")['opt_' . $optionName];
	if ($result == -1) return $default;
	return $result;
}

function setUserOption($username, $optionName, bool $val)
{
	ensureUserOptionExists($optionName);
	$val_str = $val ? 'true' : 'false';
	return DB::update("update user_info set opt_{$optionName} = {$val_str} where username= '{$username}'");
}
