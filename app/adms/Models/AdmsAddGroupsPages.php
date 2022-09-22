<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar grupo de página no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsAddGroupsPages
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
            $this->add();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Cadastrar grupo de página no banco de dados
     * Retorna TRUE quando cadastrar o grupo de página com sucesso
     * Retorna FALSE quando não cadastrar o grupo de página
     * 
     * @return void
     */
    private function add(): void
    {
        if ($this->viewLastGroupsPages()) {
            $this->data['created'] = date("Y-m-d H:i:s");

            $createGroupsPages = new \App\adms\Models\helper\AdmsCreate();
            $createGroupsPages->exeCreate("adms_groups_pgs", $this->data);

            if ($createGroupsPages->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Grupo de página cadastrado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Grupo de página não cadastrado com sucesso!</p>";
                $this->result = false;
            }
        }
    }

    /** 
     * Metodo para verificar qual he a ultima ordem que esta cadastrada no banco de dados
     */
    private function viewLastGroupsPages()
    {
        $viewLastGroupsPages = new \App\adms\Models\helper\AdmsRead();
        $viewLastGroupsPages->fullRead("SELECT order_group_pg FROM adms_groups_pgs ORDER BY order_group_pg DESC LIMIT 1");
        $this->resultadoBd = $viewLastGroupsPages->getResult();
        if ($this->resultadoBd) {
            $this->data['order_group_pg'] = $this->resultadoBd[0]['order_group_pg'] + 1;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Grupo de página não cadastrado com sucesso. Tente mais tarde!</div>";
            return false;
        }
    }
}
