<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar cor
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditColors
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data = [];

    /** @var array|null $dataForm Recebe os dados do formulário */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "salvar" do formulário da página editar cor Acessa o IF e instância a classe "AdmsEditColors" responsável em editar a cor no banco de dados.
     * Cor editada com sucesso, redireciona para a página listar cores.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {   
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id) and (empty($this->dataForm['SendEditColor'])))){
            $this->id = (int) $id;
            $viewColor = new \App\adms\Models\AdmsEditColors();
            $viewColor->viewColor($this->id);
            if ($viewColor->getResult()){
                $this->data['form'] = $viewColor->getResultBd();
                $this->viewEditColor();
            } else {
                $urlRedirect = URLADM . "list-colors/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editColor();
        }
    }       

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditColor(): void
    {   
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        
        $this->data['sidebarActive'] = "list-colors";
        
        $loadView = new \Core\ConfigView("adms/Views/colors/editColors", $this->data);
        $loadView->loadView();
    }

    private function editColor(): void
    {
        if (!empty($this->dataForm['SendEditColor'])){
             unset($this->dataForm['SendEditColor']);
             $editColor = new \App\adms\Models\AdmsEditColors();
             $editColor->update($this->dataForm);
             if ($editColor->getResult()){
                $urlRedirect = URLADM . "view-colors/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
             } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditColor();
             }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Cor não encontrada!</p>";
            $urlRedirect = URLADM . "list-colors/index";
            header("Location: $urlRedirect");
        }
    }
}