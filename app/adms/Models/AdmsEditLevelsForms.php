<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar a página configuraçao do formulário da página de login
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsEditLevelsForms
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    private array $listRegistryAdd;

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
     * Retorna os registros da tabela 'adms_levels_forms'
     *
     * @param integer $id
     * @return void
     */
    public function viewLevelForm(int $id): void
    {
        $this->id = $id;

        $viewLevelForm = new \App\adms\Models\helper\AdmsRead();
        $viewLevelForm->fullRead("SELECT id, adms_access_level_id, adms_sits_user_id, created, modified 
                                    FROM adms_levels_forms
                                    WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewLevelForm->getResult();
        if ($this->resultBd){
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Configuração de página não encontrada!</p>";
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
     * Edita a configuração no banco de dados
     * Retorna TRUE quando editar a cor com sucesso
     * Retorna FALSE quando não editar a cor
     * 
     * @return void
     */
    private function edit(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upSitUser = new \App\adms\Models\helper\AdmsUpdate();
        $upSitUser->exeUpdate("adms_levels_forms", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upSitUser->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Configuração editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Configuração não editada com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Retorna os registros do banco de dados da tabela 'adms_sits_users' e 'adms_access_levels'
     *
     * @return array
     */
    public function listSelect(): array
    {
        $list = new \App\adms\Models\helper\AdmsRead();
        $list->fullRead("SELECT id AS id_sit, name AS name_sit FROM adms_sits_users ORDER BY name ASC");
        $registry['sit'] = $list->getResult();

        $list->fullRead("SELECT id AS id_lev, name AS name_lev 
                            FROM adms_access_levels
                            WHERE order_levels >:order_levels 
                            ORDER BY name ASC", "order_levels=" . $_SESSION['order_levels']);
        $registry['lev'] = $list->getResult();

        $this->listRegistryAdd = ['sit' => $registry['sit'], 'lev' => $registry['lev']];

        return $this->listRegistryAdd;
    }
}
