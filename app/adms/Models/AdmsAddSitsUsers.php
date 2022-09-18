<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar a situação no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsAddSitsUsers
{
    /** @var array|null $data Recebe as informações do formulário */
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
            //$this->add();
            $this->valSitUnique();
        } else {
            $this->result = false;
        }
    }

    /**
     * Verificar se já existe a determinada situção cadastrarda no banco de dados.
     * Se exister algum registro irá apresentar uma mensagem de erro, se não irá instanciar o método 'add' responsável por cadastrar a situação no banco de dados.
     *
     * @return void
     */
    private function valSitUnique(): void
    {
        $name_sit = $this->data['name'];
        $listSitUnique = new \App\adms\Models\helper\AdmsRead();
        $listSitUnique->fullRead("SELECT name, id FROM adms_sits_users WHERE name = '" . $name_sit . "'");
        $this->resultBd = $listSitUnique->getResult();

        if ($this->resultBd) {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Situação já cadastrada!</p>";
            $this->result = false;
        } else {
            $this->add();
        }
    }

    /** 
     * Cadastrar situação no banco de dados
     * Retorna TRUE quando cadastrar a situação com sucesso
     * Retorna FALSE quando não cadastrar a situação
     * 
     * @return void
     */
    private function add(): void
    {
        $this->data['created'] = date("Y-m-d H:i:s");

        $createSitUser = new \App\adms\Models\helper\AdmsCreate();
        $createSitUser->exeCreate("adms_sits_users ", $this->data);

        if ($createSitUser->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Situação cadastrada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Situação não cadastrada com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Retorna os registros do banco de dados da tabela 'adms_colors'
     *
     * @return array
     */
    public function listSelect(): array
    {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id AS id_color, name AS name_color FROM adms_colors ORDER BY name ASC");
        $registry['color'] = $list->getResult();

        $this->listRegistryAdd = ['color' => $registry['color']];

        return $this->listRegistryAdd;
    }
}
