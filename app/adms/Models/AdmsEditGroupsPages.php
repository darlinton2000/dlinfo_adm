<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar grupo de página no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsEditGroupsPages
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @return bool Retorna true quando executar o processo com sucesso e false quando houver erro */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * Metodo recebe como parametro o ID que será usado para verificar se tem o registro cadastrado no banco de dados
     * @param integer $id
     * @return void
     */
    public function viewGroupsPages(int $id): void
    {
        $this->id = $id;

        $viewGroupsPages = new \App\adms\Models\helper\AdmsRead();
        $viewGroupsPages->fullRead("SELECT id, name, order_group_pg
                            FROM adms_groups_pgs
                            WHERE id=:id
                            LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewGroupsPages->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Grupo de página não encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo recebe como parametro a informação que será editada
     * Instancia o helper AdmsValEmptyField para validar os campos do formulário
     * Chama a função edit para enviar as informações para o banco de dados
     * @param array|null $data
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
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function edit(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upGroupsPages = new \App\adms\Models\helper\AdmsUpdate();
        $upGroupsPages->exeUpdate("adms_groups_pgs", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upGroupsPages->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Grupo de página editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Grupo de página não editado com sucesso!</p>";
            $this->result = false;
        }
    }
}
