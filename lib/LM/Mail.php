<?php

namespace LM;

require __DIR__ . '/../class.phpmailer.php';
require __DIR__ . '/../class.smtp.php';
require __DIR__ . '/../class.pop3.php';

class Mail extends \PHPMailer {
    protected static $_mailAccountList = array(
        array(
            'user' => 'noreply',
            'email' => 'noreply@luomor.com',
            'password' => 'luomor',
            'smtp' => 'smtp.luomor.com',
        ),
    );

    public function __construct($exceptions = false) {
        parent::__construct($exceptions); 

        $this->isSMTP();
        $this->isHTML(true);
        $this->CharSet = 'utf-8';
        $this->SMTPAuth = true;

        $this->selectAccount();
    }

    public function selectAccount($id = 0) {
        $account = self::$_mailAccountList[$id];

        $this->Host = $account['smtp'];
        $this->Username = $account['email'];
        $this->Password = $account['password'];
        $this->setFrom($account['email'], $account['user']);
    }

    public function sendMail($to, $type, $params) {
        $method = "_get_{$type}_content";
        $args = array($params);
        list($subject, $content) = call_user_func_array(array($this, $method), $args);

        $this->addAddress($to);
        $this->Subject = $subject;
        $this->Body = $content;
        if(!$this->send()) {
            error_log("send mail to $to failed:" . $this->ErrorInfo);
            $this->selectAccount(1);

            if(!$this->send()) {
                error_log("resend mail to $to failed:" . $this->ErrorInfo); 
                return false;
            }
        }
        return true;
    }
}
