<?php

require $_SERVER['DOCUMENT_ROOT'] . '/app/vendor/phpmailer/PHPMailerAutoload.php';

class UOJMail
{
	public static function noreply()
	{
		$mailer = new PHPMailer();
		$mailer->isSMTP();
		$mailer->Host = UOJConfig::$data['mail']['noreply']['host'];
		$mailer->Port = UOJConfig::$data['mail']['noreply']['port'];
		$mailer->SMTPAuth = true;
		$mailer->SMTPSecure = UOJConfig::$data['mail']['noreply']['secure'];
		$mailer->Username = UOJConfig::$data['mail']['noreply']['username'];
		$mailer->Password = UOJConfig::$data['mail']['noreply']['password'];
		$mailer->setFrom(UOJConfig::$data['mail']['noreply']['username'], UOJConfig::$data['profile']['oj-name-short']);
		$mailer->CharSet = "utf-8";
		$mailer->Encoding = "base64";
		return $mailer;
	}

	public static function send($username, $email, $subject, $content, bool $showUnsubscribe = false)
	{
		$oj_name = UOJConfig::$data['profile']['oj-name'];
		$oj_name_short = UOJConfig::$data['profile']['oj-name-short'];
		$url = HTML::url('/');

		$mailer = UOJMail::noreply();
		$mailer->addAddress($email, $username);
		$mailer->Subject = $oj_name_short . ' ' . $subject;

		$unsubText = $showUnsubscribe ? UOJMail::unsubscribeText() : '';

		$html = <<<EOD
<p>{$oj_name_short} 用户 {$username}:</p>
<p>您好！</p>
{$content}
{$unsubText}
<p><a href="{$url}">{$oj_name}</a></p>
EOD;

		$mailer->msgHTML($html);

		return $mailer->send();
	}

	public static function trySend($username, $email, $subject, $content, bool $showUnsubscribe = false)
	{
		for ($i = 0; $i < 5; ++$i) {
			if (UOJMail::send($username, $email, $subject, $content, $showUnsubscribe)) return true;
		}
		return false;
	}

	public static function unsubscribeText()
	{
		$options_url = HTML::url('/user/options');
		return <<<EOD
<p>如果您以后不想收到此类邮件，可以 <a href="{$options_url}">修改邮件设置</a>。</p>
EOD;
	}
}
