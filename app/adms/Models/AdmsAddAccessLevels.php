<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar nivel de acesso no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsAddAccessLevels
{
    /** @var array|null $data Recebe as informacoes do formulario */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    private array $listRegistryAdd;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * Recebe os valores do formulario.
     * Instancia o helper "AdmsValEmptyField" para verificar se todos os campos estao preenchidos      
     * Verifica se todos os campos estao preenchidos e instancia o metodo "add" para cadastrar no banco de dados
     * Instancia o metodo "viewLastAccessLevels" para verificar qual he a ultima ordem que esta cadastrada no banco de dados
     * Retorna FALSE quando algum campo esta vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function create(array $data = null): void
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
     * Cadastrar nivel de acesso no banco de dados
     * Retorna TRUE quando cadastrar o nivel de acesso com sucesso
     * Retorna FALSE quando nao cadastrar o nivel de acesso
     * 
     * @return void
     */
    private function add(): void
    {
        if ($this->viewLastAccessLevels()) {
            $this->data['created'] = date("Y-m-d H:i:s");

            $createAccessLevels = new \App\adms\Models\helper\AdmsCreate();
            $createAccessLevels->exeCreate("adms_access_levels", $this->data);

            if ($createAccessLevels->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Nível de acesso cadastrado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nível de acesso não cadastrado com sucesso!</p>";
                $this->result = false;
            }
        }
    }

    /** 
     * Metodo para verificar qual he a ultima ordem que esta cadastrada no banco de dados
     */
    private function viewLastAccessLevels()
    {
        $viewLastAccessLevels = new \App\adms\Models\helper\AdmsRead();
        $viewLastAccessLevels->fullRead("SELECT order_levels FROM adms_access_levels ORDER BY order_levels DESC LIMIT 1");
        $this->resultadoBd = $viewLastAccessLevels->getResult();
        if ($this->resultadoBd) {
            $this->data['order_levels'] = $this->resultadoBd[0]['order_levels'] + 1;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Nível de acesso não cadastrado com sucesso. Tente mais tarde!</div>";
            return false;
        }
    }
}
