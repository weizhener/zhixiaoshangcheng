<?php
/**
 * Email Sender
 */

if (!defined('IN_ECM'))
{
    trigger_error('Hacking attempt', E_USER_ERROR);
}

/*
 * Send Mail Class
 *
 * This class depends on other two classes: class.phpmailer.php and class.smtp.php
 * --------------------------------------------
 * Usage:
 *
 * $mailer = new Mailer('Bill', 'name@domain.com', MAIL_PROTOCOL_SMTP, 'smtp.domain.com', '25', 'username', 'password');
 * $mailer->debug = true|false;
 * $res = $mailer->send('who@domain.com,you@domain.com', 'Email Subject', 'Message Body', 'CHARSET', 1);
*/
class Mailer
{
    var $timeout    = 30;
    var $errors     = array();
    var $priority   = 3; // 1 = High, 3 = Normal, 5 = low
    var $debug      = false;

    var $PluginDir  = "";
    var $mailer;

    function __construct($from, $email, $protocol, $host = '', $port = '', $user = '', $pass = '')
    {
        $this->Mailer($from, $email, $protocol, $host, $port, $user, $pass);
    }

    function Mailer($from, $email, $protocol, $host = '', $port = '', $user = '', $pass = '')
    {
        include_once($this->PluginDir . "class.phpmailer.php");
        $this->mailer = new phpmailer();

        $this->mailer->From     = $email;
        $this->mailer->FromName = $this->_base64_encode($from);

        if ($protocol == MAIL_PROTOCOL_LOCAL)
        {
            /* mail */
            $this->mailer->IsMail();
        }
        else
        {
            /* smtp */
            $this->mailer->IsSMTP();
            $this->mailer->Host     = $host;
            $this->mailer->Port     = $port;
            $this->mailer->SMTPAuth = !empty($pass);
            $this->mailer->Username = $user;
            $this->mailer->Password = $pass;
        }
    }

    function send($mailto, $subject, $content, $charset, $is_html, $receipt = false)
    {
        $this->mailer->Priority     = $this->priority;
        $this->mailer->CharSet      = $charset;
        $this->mailer->IsHTML($is_html);
        $this->mailer->Subject      = $this->_base64_encode($subject);
        $this->mailer->Body         = $content;
        $this->mailer->Timeout      = $this->timeout;
        $this->mailer->SMTPDebug    = $this->debug;
        $this->mailer->ClearAddresses();
        $this->mailer->AddAddress($mailto);

        $res = $this->mailer->Send();
        if (!$res)
        {
            $this->errors[] = $this->mailer->ErrorInfo;
        }
        return $res;
    }

    function _base64_encode($str = '')
    {
        return '=?' . CHARSET . '?B?' . base64_encode($str) . '?=';
    }
};

?>