<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar o perfil do usuário
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsEditProfile
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var array|null $dataExitVal Recebe os campos que devem ser retirados da validação */
    private array|null $dataExitVal;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return array|null Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function viewProfile(): void
    {
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT id, name, nickname, email, user FROM adms_users WHERE id=:id LIMIT :limit", "id=".$_SESSION['user_id']."&limit=1");

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd){
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Perfil não encontrado!</p>";
            $this->result = false;
        }   
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
    public function update(array $data = null): void
    {
        $this->data = $data;

        //Destruíndo o input 'nickname' para que não seja validado, pois não é obrigatório no formulário
        $this->dataExitVal['nickname'] = $this->data['nickname'];
        unset($this->data['nickname']);
        
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
     * Instanciar o helper "AdmsValUserSingle" para verificar se o usuário não está cadastrado no banco de dados, não permitido cadastro com usuário duplicado
     * Instanciar o método "edit" quando não houver nenhum erro de preenchimento 
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function valInput(): void
    {
        $valEmail = new \App\adms\Models\helper\AdmsValEmail();
        $valEmail->validateEmail($this->data['email']);

        $valEmailSingle = new \App\adms\Models\helper\AdmsValEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email'], true, $_SESSION['user_id']);

        $valUserSingle = new \App\adms\Models\helper\AdmsValUserSingle();
        $valUserSingle->validateUserSingle($this->data['user'], true, $_SESSION['user_id']);

        if (($valEmail->getResult()) and ($valEmailSingle->getResult()) and ($valUserSingle->getResult())) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Edita o perfil do usuário no banco de dados
     * Retorna TRUE quando editar o perfil do usuário com sucesso
     * Retorna FALSE quando não editar o perfil do usuário
     * 
     * @return void
     */
    private function edit(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['nickname'] = $this->dataExitVal['nickname'];

        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id=". $_SESSION['user_id']);

        if ($upUser->getResult()) {
            $_SESSION['user_name'] = $this->data['name'];
            $_SESSION['user_nickname'] = $this->data['nickname'];
            $_SESSION['user_email'] = $this->data['email'];
            $_SESSION['msg'] = "<p style='color: green;'>Perfil editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Perfil não editado com sucesso!</p>";
            $this->result = false;
        }
    }
}
