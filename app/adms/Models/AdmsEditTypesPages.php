<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar tipos de página no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsEditTypesPages
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $dataExitVal Recebe os campos que devem ser retirados da validação */
    private array|null $dataExitVal;

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
    public function viewTypesPages(int $id): void
    {
        $this->id = $id;

        $viewTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewTypesPages->fullRead("SELECT id, type, name, obs
                            FROM adms_types_pgs
                            WHERE id=:id
                            LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewTypesPages->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Tipo de página não encontrado!</p>";
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

        $this->dataExitVal['obs'] = $this->data['obs'];
        unset($this->data['obs']);

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
        $this->data['obs'] = $this->dataExitVal['obs'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upTypesPages = new \App\adms\Models\helper\AdmsUpdate();
        $upTypesPages->exeUpdate("adms_types_pgs", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upTypesPages->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Tipo de página editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Tipo de página não editado com sucesso!</p>";
            $this->result = false;
        }
    }
}
