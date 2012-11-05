<?php

class Application_Model_Email
{
    public function __construct()
    {
        $this->db = Application_Model_ServiceLocator::getDb('db');
    }

    public function sendEmail($talentnum, $bodyText = null, $bodyHtml = null, $fromEmail, $fromName = null, $to, $toName = null, $cc = null, $subject, $priority = 3, $transport = 4775)
    {
        //$to = 'cristi.catea@gmail.com'; // remove when in production

        $mail = new Zend_Mail('UTF-8');
        if($bodyText != null){
            $mail->setBodyText($this->html2text($bodyText));
        }
        if($bodyHtml != null){
            $mail->setBodyHtml($bodyHtml);
        }
        $mail->setFrom($fromEmail, $fromName);

        $mail->addTo($to, $toName);

        if($cc != null){
            $mail->addCc($cc);
        }
        $mail->setSubject($subject);

        $mailingId = time();

        $mail->addHeader("X-xsMailingId", $mailingId);
        $mail->addHeader("X-Job", $mailingId);
        $mail->addHeader("X-xsMessageId", $talentnum);
        $mail->addHeader("X-xsUserId", $talentnum);
        $mail->addHeader("X-Priority", $priority);

	    if($to == '' || $to == null){
		    return true;
	    }

        $sending = $mail->send(Application_Model_ServiceLocator::getMailTransport($transport));

        $sent = false;
        if($sending){
            $sent = true;
        }
        return $sent;
    }

	public function sendSms($phoneNumber, $message, $name)
	{
		$service = new Zend_Service_DeveloperGarden_SendSms(Application_Model_ServiceLocator::getSmsTransport('sms'));
		$sms = $service->createSms($phoneNumber, $message, $name);

		return $service->send($sms);
	}

    public function html2text($html)
    {
        $tags = array(
            0 => '~<h[123][^>]+>~si',
            1 => '~<h[456][^>]+>~si',
            2 => '~<table[^>]+>~si',
            3 => '~<tr[^>]+>~si',
            4 => '~<li[^>]+>~si',
            5 => '~<br[^>]+>~si',
            6 => '~<p[^>]+>~si',
            7 => '~<div[^>]+>~si'
        );
        $html = preg_replace($tags, "\n", $html);
        $html = preg_replace('~</t(d|h)>\s*<t(d|h)[^>]+>~si', ' - ', $html);
        $html = preg_replace('~<[^>]+>~s', '', $html);
        // reducing spaces
        $html = preg_replace('~ +~s', ' ', $html);
        $html = preg_replace('~^\s+~m', '', $html);
        $html = preg_replace('~\s+$~m', '', $html);
        // reducing newlines
        $html = preg_replace('~\n+~s', "\n", $html);

        return $html;
    }

/*
	public function smtpEmailValidation($email, $sender = null)
	{
		// the email to validate
		$email = 'user@example.com';
		//multiple emails
		//$email = array('user@example.com', 'user2@example.com');

		// an optional sender
		$sender = 'user@mydomain.com';
		// instantiate the class
		$SMTP_Validator = new SmtpValidateEmail();
		// turn on debugging if you want to view the SMTP transaction
		$SMTP_Validator->debug = true;
		// do the validation
		$results = $SMTP_Validator->validate(array($email), $sender);
		// view results
		echo $email.' is '.($results[$email] ? 'valid' : 'invalid')."\n";

		// send email?
		if ($results[$email]) {
			// send email
		} else {
			echo 'The email addresses you entered is not valid';
		}
	}
*/
}