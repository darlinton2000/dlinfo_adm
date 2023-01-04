<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página configuraçao do formulário da página de login
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditLevelsForms
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data = [];

    /** @var array|null $dataForm Recebe os dados do formulário */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "salvar" do formulário da página editar acessa o IF e instância a classe "AdmsEditLevelsForms" responsável em editar no banco de dados.
     * Se editar com sucesso, redireciona para a página configuração do formulário página de login.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {   
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id) and (empty($this->dataForm['SendEditLevelForm'])))){
            $this->id = (int) $id;
            $viewLevelForm = new \App\adms\Models\AdmsEditLevelsForms();
            $viewLevelForm->viewLevelForm($this->id);
            if ($viewLevelForm->getResult()){
                $this->data['form'] = $viewLevelForm->getResultBd();
                $this->viewEditLevelForm();
            } else {
                $urlRedirect = URLADM . "view-levels-forms/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editLevelForm();
        }
    }       

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditLevelForm(): void
    {   
        $listSelect = new \App\adms\Models\AdmsEditLevelsForms();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        
        $this->data['sidebarActive'] = "view-levels-forms";
        
        $loadView = new \Core\ConfigView("adms/Views/levelsForms/editLevelsForms", $this->data);
        $loadView->loadView();
    }

    private function editLevelForm(): void
    {
        if (!empty($this->dataForm['SendEditLevelForm'])){
             unset($this->dataForm['SendEditLevelForm']);
             $editLevelForm = new \App\adms\Models\AdmsEditLevelsForms();
             $editLevelForm->update($this->dataForm);
             if ($editLevelForm->getResult()){
                $urlRedirect = URLADM . "view-levels-forms/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
             } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditLevelForm();
             }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Página de editar configuração não encontrada!</p>";
            $urlRedirect = URLADM . "view-levels-forms/index";
            header("Location: $urlRedirect");
        }
    }
}