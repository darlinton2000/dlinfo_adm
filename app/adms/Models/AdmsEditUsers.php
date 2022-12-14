<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar o usuário do banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsEditUsers
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

    public function viewUser(int $id): void
    {
        $this->id = $id;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT usr.id, usr.name, usr.nickname, usr.email, usr.user, usr.adms_sits_user_id, usr.adms_access_level_id 
                                FROM adms_users AS usr
                                INNER JOIN adms_access_levels AS lev ON lev.id = usr.adms_access_level_id
                                WHERE usr.id=:id AND lev.order_levels > :order_levels 
                                LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd){
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não encontrado!</p>";
            $this->result = false;
        }   
    }

    /** 
     * Método recebe as informações do usuário que serão validadas.
     * Instancia o helper "AdmsValEmptyField" para validar os campos do formulário
     * Retira o campo opcional "nickname" da validação
     * Chama o método valinput para validar os campos específicos do formulário
     * 
     * @param array $data Recebe as informações do formulário
     * @return void
     */
    public function update(array $data = null): void
    {
        $this->data = $data;

        //Destruíndo o input 'nickname' para que não seja validado, pois não é obrigatório no formulário
        $this->dataExitVal['nickname'] = $this->data['nickname'];
        unset($this->data['nickname']);

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->valInput();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Instanciar o helper "AdmsValEmail" para verificar se o e-mail válido
     * Instanciar o helper "AdmsValEmailSingle" para verificar se o e-mail não está cadastrado no banco de dados, não permitido cadastro com e-mail duplicado
     * Instanciar o helper "AdmsValUserSingle" para verificar se o usuário não está cadastrado no banco de dados, não permitido cadastro com usuário duplicado
     * Instanciar o método "edit" quando não houver nenhum erro de preenchimento 
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function valInput(): void
    {
        $valEmail = new \App\adms\Models\helper\AdmsValEmail();
        $valEmail->validateEmail($this->data['email']);

        $valEmailSingle = new \App\adms\Models\helper\AdmsValEmailSingle();
        $valEmailSingle->validateEmailSingle($this->data['email'], true, $this->data['id']);

        $valUserSingle = new \App\adms\Models\helper\AdmsValUserSingle();
        $valUserSingle->validateUserSingle($this->data['user'], true, $this->data['id']);

        if (($valEmail->getResult()) and ($valEmailSingle->getResult()) and ($valUserSingle->getResult())) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Edita o usuário no banco de dados
     * Retorna TRUE quando editar o usuário com sucesso
     * Retorna FALSE quando não editar o usuário
     * 
     * @return void
     */
    private function edit(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['nickname'] = $this->dataExitVal['nickname'];

        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upUser->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Usuário editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não editado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Retorna os registros do banco de dados da tabela 'adms_sits_users'
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
