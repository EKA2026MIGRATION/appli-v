<?php
require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * MailerService Class
 * Used to send email
 * 
 * 
 * @author Sandy Razafitrimo <sandy@etsik.com>
 */
class MailerService
{

    private $add;
    private $reply;
    private $title;
    private $message;
    private $encoding;
    private $from_name; 
    private $from_email; 
    private $templateEmail = null;
    
    public function __construct()
    {
        $this->setEncoding("utf-8");
        $this->setReply("contact@energykidsacademy.net");
        $this->setFromEmail('contact@energykidsacademy.net');
        $this->setFromName('ENERGY KIDS ACADEMY');
    }
    
    /**
     * Get the value of add
     */ 
    public function getAdd()
    {
        return $this->add;
    }

    /**
     * Set the value of add
     * @var string add  e.g. "cyruss@phpteam.net, trash@phpteam.net"
     *
     * @return  self
     */ 
    public function setAdd($add)
    {
        $this->add = $add;

        return $this;
    }


    /**
     * Get the value of reply
     */ 
    public function getReply()
    {
        return $this->reply;
    }

    /**
     * Set the value of reply
     *
     * @return  self
     */ 
    public function setReply($reply)
    {
        $this->reply = $reply;

        return $this;
    }
    
    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of message
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the value of message
     * @var string $message e.g. "<html><body>Hello world</body></html>" 
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get the value of encoding
     */ 
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Set the value of encoding
     *
     * @return  self
     */ 
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;

        return $this;
    }

  /**
     * Get the value of from
     */ 
    public function getFromName()
    {
        return $this->from_name;
    }

    /**
     * Set the value of from
     * @var array
     *
     * @return  self
     */ 
    public function setFromName($from_name)
    {
        $this->from_name = $from_name;

        return $this;
    }

    /**
     * Get the value of from
     */ 
    public function getFromEmail()
    {
        return $this->from_email;
    }

    /**
     * Set the value of from
     * @var array
     *
     * @return  self
     */ 
    public function setFromEmail($from_email)
    {
        $this->from_email = $from_email;

        return $this;
    }

    public function setTemplateEmail($template) {
        $this->templateEmail = $template;
    }
    

    public function getTemplateEmail() {
        return $this->templateEmail;
    }
    

    public function sendMail() {

        $destEmails = $this->getAdd();
        $subject = $this->getTitle();
        $content = $this->getMessage();

        foreach(explode(',', $destEmails) as $destEmail) {


            if($destEmail == "") continue;

            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = SMTP_HOST;
                $mail->SMTPAuth   = true;

                $mail->Username   = SMTP_USERNAME;
                $mail->Password   = SMTP_PASSWORD;


                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = SMTP_PORT;

                $mail->setFrom('contact@energykidsacademy.net', 'EnergyKidsAcademy');
                $mail->addAddress($destEmail);


                if(!$this->getTemplateEmail()) {
                    $contentEmail = $this->getDefaultTemplateEmail($subject, $content);
                } else {
                    // create system to replace value in template
                    $contentEmail = $content;
                }

                // Content
                $mail->isHTML(true);
                $mail->Subject = utf8_decode($subject);
                $mail->Body = utf8_decode($contentEmail);
                $mail->IsHTML(true);
                $mail->send();
            } catch (Exception $e) {

                dd($e);
                echo json_encode(["success" => false]);
            }
        }
    }


    public function getDefaultTemplateEmail($subject, $content) {
        ob_start();
        include ROOT.'view/render/sendMail/defaultTemplate.php';
        return ob_get_clean();
    }

}
