<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar a situação no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsEditSitsUsers
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
     * Retorna os registros da tabela 'adms_sits_users'
     *
     * @param integer $id
     * @return void
     */
    public function viewSitUser(int $id): void
    {
        $this->id = $id;

        $viewSitUser = new \App\adms\Models\helper\AdmsRead();
        $viewSitUser->fullRead("SELECT id, name, adms_color_id FROM adms_sits_users WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewSitUser->getResult();
        if ($this->resultBd){
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Situação não encontrada!</p>";
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
     * Edita a situação no banco de dados
     * Retorna TRUE quando editar a situção com sucesso
     * Retorna FALSE quando não editar a situção
     * 
     * @return void
     */
    private function edit(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upSitUser = new \App\adms\Models\helper\AdmsUpdate();
        $upSitUser->exeUpdate("adms_sits_users ", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upSitUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Situação editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Situação não editada com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Retorna os registros do banco de dados da tabela 'adms_colors '
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
