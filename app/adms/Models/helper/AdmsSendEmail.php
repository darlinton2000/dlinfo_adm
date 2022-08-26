<?php

namespace App\adms\Models\helper;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Classe genérica para enviar e-mail
 * 
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsSendEmail
{
    /** @var array $data Receber as informações do conteúdo do e-mail */
    private array $data;

    /** @var array $dataInfoEmail Receber as credênciais do e-mail */
    private array $dataInfoEmail;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var boolean $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var string $fromEmail Receber o e-mail do remetente */
    private string $fromEmail = EMAILADM;

    /** @var int $optionConfEmail Recebe o id do e-mail que será utlizado para enviar e-mail */
    private int $optionConfEmail;

    /**
     * @return boolean Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return string Retorna o e-mail do remetente
     */
    function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    public function sendEmail(array $data, int $optionConfEmail): void
    {   
        $this->optionConfEmail = $optionConfEmail;
        $this->data = $data;

        $this->infoPhpMailer();
    }

    private function infoPhpMailer(): void
    {
        $confEmail = new \App\adms\Models\helper\AdmsRead();
        $confEmail->fullRead("SELECT name, email, host, username, password, smtpsecure, port FROM adms_confs_emails WHERE id =:id LIMIT :limit", "id={$this->optionConfEmail}&limit=1");
        $this->resultBd = $confEmail->getResult();

        if ($this->resultBd){
            $this->dataInfoEmail['host'] = $this->resultBd[0]['host'];
            $this->dataInfoEmail['fromEmail'] = $this->resultBd[0]['email'];
            $this->fromEmail = $this->dataInfoEmail['fromEmail'];
            $this->dataInfoEmail['fromName'] = $this->resultBd[0]['name'];
            $this->dataInfoEmail['username'] = $this->resultBd[0]['username'];
            $this->dataInfoEmail['password'] = $this->resultBd[0]['password'];
            $this->dataInfoEmail['smtpsecure'] = $this->resultBd[0]['smtpsecure'];
            $this->dataInfoEmail['port'] = $this->resultBd[0]['port'];

            $this->sendEmailPhpMailer();
        } else {
            $this->result = false;
        }
    }

    private function sendEmailPhpMailer(): void
    {
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            //$mail->SMTPDebug  = SMTP::DEBUG_SERVER;                   //Enable verbose debug output
            $mail->CharSet    = 'UTF-8';    
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = $this->dataInfoEmail['host'];           //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $this->dataInfoEmail['username'];       //SMTP username
            $mail->Password   = $this->dataInfoEmail['password'];       //SMTP password
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;          //Enable implicit TLS encryption
            $mail->SMTPSecure = $this->dataInfoEmail['smtpsecure'];     //habilitado para funcionar o MailTrap
            $mail->Port       = $this->dataInfoEmail['port'];           //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom($this->dataInfoEmail['fromEmail'], $this->dataInfoEmail['fromName']);
            $mail->addAddress($this->data['toEmail'], $this->data['toName']);

            //Content
            $mail->isHTML(true);                                        //Set email format to HTML
            $mail->Subject = $this->data['subject'];
            $mail->Body    = $this->data['contentHtml'];
            $mail->AltBody = $this->data['contentText'];

            $mail->send();

            $this->result = true;
        } catch (Exception $e){
            //echo $e;                                                   //Enable to view errors
            $this->result = false;
        }
    }
}