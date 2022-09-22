<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar situação páginas no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsAddSitsPages
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array $listRegistryAdd Recebe as informações que serão usadas no dropdown do formulário*/
    private array $listRegistryAdd;

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
     * Cadastrar situação de página no banco de dados
     * Retorna TRUE quando cadastrar a situação com sucesso
     * Retorna FALSE quando não cadastrar a situação
     * 
     * @return void
     */
    private function add(): void
    {
        $this->data['created'] = date("Y-m-d H:i:s");

        $createSitPages = new \App\adms\Models\helper\AdmsCreate();
        $createSitPages->exeCreate("adms_sits_pgs", $this->data);

        if ($createSitPages->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Situação de página cadastrada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Situação de página não cadastrada com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para pesquisar as informações que serão usadas no dropdown do formulário
     *
     * @return array
     */
    public function listSelect(): array
    {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id id_col, name name_col FROM adms_colors ORDER BY name ASC");
        $registry['col'] = $list->getResult();

        $this->listRegistryAdd = ['col' => $registry['col']];

        return $this->listRegistryAdd;
    }
}
