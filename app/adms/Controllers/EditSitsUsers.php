<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar situação
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditSitsUsers
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data = [];

    /** @var array|null $dataForm Recebe os dados do formulário */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "salvar" do formulário da página editar situaçãp Acessa o IF e instância a classe "AdmsEditSitsUsers" responsável em editar a situação no banco de dados.
     * Situação editada com sucesso, redireciona para a página listar situações.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {   
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id) and (empty($this->dataForm['SendEditSitUser'])))){
            $this->id = (int) $id;
            $viewSitUser = new \App\adms\Models\AdmsEditSitsUsers();
            $viewSitUser->viewSitUser($this->id);
            if ($viewSitUser->getResult()){
                $this->data['form'] = $viewSitUser->getResultBd();
                $this->viewEditSitUser();
            } else {
                $urlRedirect = URLADM . "list-sits-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editSitser();
        }
    }       

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditSitUser(): void
    {   
        $listSelect = new \App\adms\Models\AdmsEditSitsUsers();
        $this->data['select'] = $listSelect->listSelect();

        $this->data['sidebarActive'] = "list-sits-users";
        
        $loadView = new \Core\ConfigView("adms/Views/sitsUser/editSitUser", $this->data);
        $loadView->loadView();
    }

    private function editSitser(): void
    {
        if (!empty($this->dataForm['SendEditSitUser'])){
             unset($this->dataForm['SendEditSitUser']);
             $editSitUser = new \App\adms\Models\AdmsEditSitsUsers();
             $editSitUser->update($this->dataForm);
             if ($editSitUser->getResult()){
                $urlRedirect = URLADM . "view-sits-users/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
             } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditSitUser();
             }
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Situação não encontrada!</p>";
            $urlRedirect = URLADM . "list-sits-users/index";
            header("Location: $urlRedirect");
        }
    }
}