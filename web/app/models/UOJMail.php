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
		$mailer->setFrom(UOJConfig::$data['mail']['noreply']['username'], UOJConfig::$data['profile']['oj-name-short'] . " noreply");
		$mailer->CharSet = "utf-8";
		$mailer->Encoding = "base64";
		return $mailer;
	}

	public static function send($username, $email, $subject, $content)
	{
		$oj_name = UOJConfig::$data['profile']['oj-name'];
		$oj_name_short = UOJConfig::$data['profile']['oj-name-short'];
		$url = HTML::url('/');

		$mailer = UOJMail::noreply();
		$mailer->addAddress($email, $username);
		$mailer->Subject = $oj_name_short . ' ' . $subject;

		$html = <<<EOD
<p>{$oj_name_short} 用户 {$username}:</p>
<p>您好！</p>
{$content}
<p><a href="{$url}">{$oj_name}</a></p>
EOD;

		$mailer->msgHTML($html);

		return $mailer->send();
	}
}
