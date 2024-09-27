<?php

Class DocufyHelper {

    private $errorCollector;

    public function __construct(DocufyErrorCtrl $errorCollector) {
        $this->errorCollector = $errorCollector;
    }
    
    public function sendEmail($to, $subject, $message, $from = array(), $altMessage = "", $cc = array(), $bcc = array(), $attachments = array(), $mode = "PHPMAIL", $smtp = array(), $isHTML = true) {
        require_once(dirname(__FILE__) . "/library/PHPMailer-master/PHPMailerAutoload.php");
        $mail = new PHPMailer;
        $mail->Subject = $subject;
        $mail->msgHTML($message);
        $mail->AltBody = $message;
        $mailError = array();
        if (strtoupper($mode) === "SMTP") {
            $mail->isSMTP();
            $mail->Host = isset($smtp["host"]) ? $smtp["host"] : "";
            $mail->Port = isset($smtp["port"]) ? $smtp["port"] : 25;
            $mail->SMTPAuth = isset($smtp["SMTPAuth"]) ? $smtp["SMTPAuth"] : true;
            $mail->Username = isset($smtp["username"]) ? $smtp["username"] : "";
            $mail->Password = isset($smtp["password"]) ? $smtp["password"] : "";
            $mail->SMTPSecure = isset($smtp["SMTPSecure"]) ? $smtp["SMTPSecure"] : "";
            $mail->SMTPKeepAlive = isset($smtp["SMTPKeepAlive"]) ? $smtp["SMTPKeepAlive"] : true;
        }

        if (isset($from)) {
            foreach ($from as $key => $value) {
                if (is_numeric($key))
                    $mail->setFrom($value, $value);
                else
                    $mail->setFrom($key, $value);
            }
        }

        if (isset($cc)) {
            foreach ($cc as $key => $value) {
                if (is_numeric($key))
                    $mail->addCC($value, $value);
                else
                    $mail->addCC($key, $value);
            }
        }

        if (isset($bcc)) {
            foreach ($bcc as $key => $value) {
                if (is_numeric($key))
                    $mail->addBCC($value, $value);
                else
                    $mail->addBCC($key, $value);
            }
        }

        if (isset($attachments)) {
            foreach ($attachments as $attachment) {
                $mail->addAttachment($attachment);
            }
        }

        foreach ($to as $key => $value) {
            if (is_numeric($key))
                $mail->addAddress($value, $value);
            else
                $mail->addAddress($key, $value);

            if (!$mail->send()) {
                $mailError[] = $mail->ErrorInfo;
            }

            $mail->clearAddresses();
        }

        if (count($mailError)) {
            foreach ($mailError as $err) {
                echo $err;
            }
        }

        return true;
    }

}
