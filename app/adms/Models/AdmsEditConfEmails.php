<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar a configuração de e-mail no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsEditConfEmails
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

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

    /**
     * Retorna os registros da tabela 'adms_confs_emails'
     *
     * @param integer $id
     * @return void
     */
    public function viewConfEmail(int $id): void
    {
        $this->id = $id;

        $viewConfEmail = new \App\adms\Models\helper\AdmsRead();
        $viewConfEmail->fullRead("SELECT id, title, name, email, host, username, smtpsecure, port FROM adms_confs_emails WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewConfEmail->getResult();
        if ($this->resultBd){
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Configuração de e-mail não encontrada!</p>";
            $this->result = false;
        }   
    }

    /** 
     * Recebe os valores do formulário.
     * Instancia o helper "AdmsValEmptyField" para verificar se todos os campos estão preenchidos 
     * Verifica se todos os campos estão preenchidos e instancia o método "edit" para editar as informações no banco de dados
     * Retorna FALSE quando algum campo está vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function update(array $data = null): void
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Edita a configuração de e-mail no banco de dados
     * Retorna TRUE quando editar a configuração de e-mail com sucesso
     * Retorna FALSE quando não editar a configuração de e-mail
     * 
     * @return void
     */
    private function edit(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upConfEmail = new \App\adms\Models\helper\AdmsUpdate();
        $upConfEmail->exeUpdate("adms_confs_emails ", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upConfEmail->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Configuração de e-mail editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Configuração de e-mail não editada com sucesso!</p>";
            $this->result = false;
        }
    }
}
