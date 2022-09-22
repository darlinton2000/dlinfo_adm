<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar tipos de página no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsAddTypesPages
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array $dataExitVal Recebe as informações que serão retiradas da validação*/
    private array $dataExitVal;

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

        $this->dataExitVal['obs'] = $this->data['obs'];
        unset($this->data['obs']);

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Cadastrar tipo de página no banco de dados
     * Retorna TRUE quando cadastrar o tipo de página com sucesso
     * Retorna FALSE quando não cadastrar o tipo de página
     * 
     * @return void
     */
    private function add(): void
    {
        if ($this->viewLastTypesPages()) {
            
            $this->data['obs'] = $this->dataExitVal['obs'];
            $this->data['created'] = date("Y-m-d H:i:s");

            $createTypesPages = new \App\adms\Models\helper\AdmsCreate();
            $createTypesPages->exeCreate("adms_types_pgs", $this->data);

            if ($createTypesPages->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Tipo de página cadastrado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Tipo de página não cadastrado com sucesso!</p>";
                $this->result = false;
            }
        }
    }

    /** 
     * Metodo para verificar qual he a ultima ordem que esta cadastrada no banco de dados
     */
    private function viewLastTypesPages()
    {
        $viewLastTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewLastTypesPages->fullRead("SELECT order_type_pg FROM adms_types_pgs ORDER BY order_type_pg DESC LIMIT 1");
        $this->resultadoBd = $viewLastTypesPages->getResult();
        if ($this->resultadoBd) {
            $this->data['order_type_pg'] = $this->resultadoBd[0]['order_type_pg'] + 1;
            return true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Tipo de página não cadastrado com sucesso. Tente mais tarde!</div>";
            return false;
        }
    }
}
