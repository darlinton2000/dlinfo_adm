<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Solicitar novo link para confirmar o e-mail
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsNewConfEmail
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var string $firstName Receber o primeiro nome do usuário */
    private string $firstName;

    /** @var array $emailData Recebe dados do conteúdo do e-email */
    private array $emailData;

    private array $dataSave;

    private string $url;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * @return void
     */
    public function newConfEmail(array $data = null): void
    {
        $this->data = $data;
        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        
        if ($valEmptyField->getResult()){
            $this->valUser();
        } else {
            $this->result = false;
        }
    }

    private function valUser(): void
    {
        $newConfEmail = new \App\adms\Models\helper\AdmsRead();
        $newConfEmail->fullRead("SELECT id, name, email, conf_email FROM adms_users WHERE email =:email LIMIT :limit", "email={$this->data['email']}&limit=1");
        $this->resultBd = $newConfEmail->getResult();

        if ($this->resultBd){
            $this->valConfEmail();    
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: E-mail não cadastrado!</p>";
            $this->result = false;
        }
    }

    private function valConfEmail(): void
    {
        if ((empty($this->resultBd[0]['conf_email'])) or ($this->resultBd[0]['conf_email'] == NULL)){
            $this->dataSave['conf_email'] = password_hash(date("Y-m-d H:i:s") . $this->resultBd[0]['id'], PASSWORD_DEFAULT);
            $this->dataSave['modified'] = date("Y-m-d H:i:s");
            
            $upNewConfEmail = new \App\adms\Models\helper\AdmsUpdate();
            $upNewConfEmail->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

            if ($upNewConfEmail->getResult()){
                $this->resultBd[0]['conf_email'] = $this->dataSave['conf_email'];
                $this->sendEmail();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Link não enviado, tente novamente!</p>";
                $this->result = false;
            }        
        } else {
            $this->sendEmail();
        }
    }

    private function sendEmail(): void
    {
        $sendEmail = new \App\adms\Models\helper\AdmsSendEmail();
        $this->emailHTML();
        $this->emailText();
        $sendEmail->sendEmail($this->emailData, 2);

        if ($sendEmail->getResult()){
            $_SESSION['msg'] = "<p class='alert-success'>Novo link enviado com sucesso. Acesse sua caixa de e-mail para confirmar o e-mail!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'> Erro: link não enviado, tente novamente ou entre em contato como o e-mail {$sendEmail->getFromEmail()}!</p>";
            $this->result = false;
        }
    }

    private function emailHTML(): void
    {
        $name = explode(" ", $this->resultBd[0]['name']);
        $this->firstName = $name[0];

        $this->emailData['toEmail'] = $this->data['email'];
        $this->emailData['toName'] = $this->resultBd[0]['name'];
        $this->emailData['subject'] = "Confirma sua conta";
        $this->url = URLADM . "conf-email/index?key=" . $this->resultBd[0]['conf_email'];

        $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
        $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastro em nosso site!<br><br>";
        $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicando no link abaixo: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='{$this->url}' target='_blank'>{$this->url}</a><br><br>";
        $this->emailData['contentHtml'] .= "Esta mensagem foi enviada a você pela empresa DL Gestor.<br>Você está recebendo porque está cadastrado no banco de dados da empresa DL Gestor. Nenhum e-mail enviado pela empresa DL Gestor tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>";
    }

    private function emailText(): void
    {
        $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
        $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastro em nosso site!\n\n";
        $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicando no link abaixo: \n\n";
        $this->emailData['contentText'] .= $this->url . "\n\n";
        $this->emailData['contentText'] .= "Esta mensagem foi enviada a você pela empresa DL Gestor.\nVocê está recebendo porque está cadastrado no banco de dados da empresa DL Gestor. Nenhum e-mail enviado pela empresa DL Gestor tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";
    }
}
