<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar a nova configuração de e-mail no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsAddConfEmails
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

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
     * Verifica se todos os campos estão preenchidos e instancia o método "add" para cadastrar os dados no banco de dados
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
            $this->add();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Cadastrar a configuração de e-mail no banco de dados
     * Retorna TRUE quando cadastrar a configuração de e-mail com sucesso
     * Retorna FALSE quando não cadastrar a configuração de e-mail
     * 
     * @return void
     */
    private function add(): void
    {
        $this->data['created'] = date("Y-m-d H:i:s");

        $createSitUser = new \App\adms\Models\helper\AdmsCreate();
        $createSitUser->exeCreate("adms_confs_emails", $this->data);

        if ($createSitUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Configuração de e-mail cadastrada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Configuração de e-mail não cadastrada com sucesso!</p>";
            $this->result = false;
        }
    }
}
