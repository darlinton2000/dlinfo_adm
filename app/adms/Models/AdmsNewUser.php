<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar o usuário no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsNewUser
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var string $fromEmail Receber o e-mail do remetente */
    private string $fromEmail;

    /** @var string $firstName Receber o primeiro nome do usuário */
    private string $firstName;

    /** @var string $url Recebe a URL com o endereço para o usuário confirmar o e-mail */
    private string $url;

    /** @var array $emailData Recebe dados do conteúdo do e-email */
    private array $emailData;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * Recebe os valores do formulário.
     * Instancia o helper "AdmsValEmptyField" para verificar se todos os campos estão preenchidos 
     * Verifica se todos os campos estão preenchidos e instancia o método "valInput" para validar os dados dos campos
     * Retorna FALSE quando algum campo está vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function create(array $data = null)
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->valInput();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Instanciar o helper "AdmsValEmail" para verificar se o e-mail válido
     * Instanciar o helper "AdmsValEmailSingle" para verificar se o e-mail não está cadastrado no banco de dados, não permitido cadastro com e-mail duplicado
     * Instanciar o helper "validatePassword" para validar a senha
     * Instanciar o helper "validateUserSingleLogin" para verificar se o usuário não está cadastrado no banco de dados, não permitido cadastro com usuário duplicado
     * Instanciar o método "add" quando não houver nenhum erro de preenchimento 
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function valInput(): void
    {
        $valEmail = new \App\adms\Models\helper\AdmsValEmail();
        $valEmail->validateEmail($this->data['email']);

        $valEmailSingle = new \App\adms\Models\helper\AdmsValEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email']);

        $valPassword = new \App\adms\Models\helper\AdmsValPassword();
        $valPassword->validatePassword($this->data['password']);

        $valUserSingleLogin = new \App\adms\Models\helper\AdmsValUserSingleLogin();
        $valUserSingleLogin->validateUserSingleLogin($this->data['email']);

        if (($valEmail->getResult()) and ($valEmailSingle->getResult()) and ($valPassword->getResult()) and ($valUserSingleLogin->getResult())) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     * 
     * @return void
     */
    private function add(): void
    {
        if ($this->accessLevel()){
            $this->data['password'] = password_hash($this->data['password'], PASSWORD_DEFAULT);
            $this->data['user'] = $this->data['email'];
            $this->data['conf_email'] = password_hash($this->data['password'] . date("Y-m-d H:i:s"), PASSWORD_DEFAULT);
            $this->data['created'] = date("Y-m-d H:i:s");

            $createUser = new \App\adms\Models\helper\AdmsCreate();
            $createUser->exeCreate("adms_users", $this->data);

            if ($createUser->getResult()) {
                $this->sendEmail();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não cadastrado com sucesso!</p>";
                $this->result = false;
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não cadastrado com sucesso!</p>";
            $this->result = false;
        }
        
    }

    /** 
     * Pesquisar no banco de dados o nivel de acesso e a situacao que deve ser utilizada no formulario cadastrar usuario na pagina de login
     * Retorna TRUE quando encontrar o registro
     * Retorna FALSE quando nao encontrar o registro
     * 
     * @return bool
     */ 
    private function accessLevel(): bool
    {
        $viewAccessLevel = new \App\adms\Models\helper\AdmsRead();
        $viewAccessLevel->fullRead("SELECT adms_access_level_id, adms_sits_user_id FROM adms_levels_forms ORDER BY id ASC LIMIT :limit", "limit=1");
        $this->resultBd = $viewAccessLevel->getResult();

        if ($this->resultBd){
            $this->data['adms_access_level_id'] = $this->resultBd[0]['adms_access_level_id'];
            $this->data['adms_sits_user_id'] = $this->resultBd[0]['adms_sits_user_id'];
            return true;
        } else {
            return false;
        }

    }

    private function sendEmail(): void
    {
        $this->contentEmailHtml();
        $this->contentEmailText();

        $sendEmail = new \App\adms\Models\helper\AdmsSendEmail();
        $sendEmail->sendEmail($this->emailData, 1);

        if ($sendEmail->getResult()){
            $_SESSION['msg'] = "<p class='alert-success'>Usuário cadastrado com sucesso. Acesse a sua caixa de e-mail para confirmar o e-mail!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Usuário cadastrado com sucesso. Houve um erro ao enviar o e-mail de confirmação, entre em contato com {$sendEmail->getFromEmail()} para mais informações!</p>";
            $this->result = true;
        }
    }

    private function contentEmailHtml(): void
    {
        $name = explode(" ", $this->data['name']);
        $this->firstName = $name[0];

        $this->emailData['toEmail'] = $this->data['email'];
        $this->emailData['toName'] = $this->data['name'];
        $this->emailData['subject'] = "Confirma sua conta";
        $this->url = URLADM . "conf-email/index?key=" . $this->data['conf_email'];

        $this->emailData['contentHtml'] = "Prezado(a) {$this->firstName}<br><br>";
        $this->emailData['contentHtml'] .= "Agradecemos a sua solicitação de cadastro em nosso site!<br><br>";
        $this->emailData['contentHtml'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicando no link abaixo: <br><br>";
        $this->emailData['contentHtml'] .= "<a href='{$this->url}' target='_blank'>{$this->url}</a><br><br>";
        $this->emailData['contentHtml'] .= "Esta mensagem foi enviada a você pela empresa DL Gestor.<br>Você está recebendo porque está cadastrado no banco de dados da empresa DL Gestor. Nenhum e-mail enviado pela empresa DL Gestor tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.<br><br>";
    }

    private function contentEmailText(): void
    {
        $this->emailData['contentText'] = "Prezado(a) {$this->firstName}\n\n";
        $this->emailData['contentText'] .= "Agradecemos a sua solicitação de cadastro em nosso site!\n\n";
        $this->emailData['contentText'] .= "Para que possamos liberar o seu cadastro em nosso sistema, solicitamos a confirmação do e-mail clicando no link abaixo: \n\n";
        $this->emailData['contentText'] .= $this->url . "\n\n";
        $this->emailData['contentText'] .= "Esta mensagem foi enviada a você pela empresa DL Gestor.\nVocê está recebendo porque está cadastrado no banco de dados da empresa DL Gestor. Nenhum e-mail enviado pela empresa DL Gestor tem arquivos anexados ou solicita o preenchimento de senhas e informações cadastrais.\n\n";
    }
}
