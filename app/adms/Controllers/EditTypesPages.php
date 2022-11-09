<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller editar tipos de página
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditTypesPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Método editar tipos de página.
     * Receber os dados do formulário.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações do tipo no banco de dados, se encontrar instancia o método "viewEditTypesPages". Se não existir redireciona para o listar tipo de página.
     * 
     * Se não existir o usuário clicar no botão acessa o ELSE e instancia o método "editTypesPages".
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditTypesPages']))) {
            $this->id = (int) $id;
            $viewTypesPages = new \App\adms\Models\AdmsEditTypesPages();
            $viewTypesPages->viewTypesPages($this->id);
            if ($viewTypesPages->getResult()) {
                $this->data['form'] = $viewTypesPages->getResultBd();
                $this->viewEditTypesPages();
            } else {
                $urlRedirect = URLADM . "list-types-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editTypesPages();
        }
    }

    /**     
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditTypesPages(): void
    {   
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "list-types-pages";
        
        $loadView = new \Core\ConfigView("adms/Views/typesPages/editTypesPages", $this->data);
        $loadView->loadView();
    }

    /**
     * Editar tipo de página.
     * Se o usuário clicou no botão, instancia a MODELS responsável em receber os dados e editar no banco de dados.
     * Verifica se editou corretamente o tipo no banco de dados.
     * Se o usuário não clicou no botão redireciona para página listar tipo.
     *
     * @return void
     */
    private function editTypesPages(): void
    {
        if (!empty($this->dataForm['SendEditTypesPages'])) {
            unset($this->dataForm['SendEditTypesPages']);
            $editTypesPages = new \App\adms\Models\AdmsEditTypesPages();
            $editTypesPages->update($this->dataForm);
            if ($editTypesPages->getResult()) {
                $urlRedirect = URLADM . "view-types-pages/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditTypesPages();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Tipo de página não encontrado!</p>";
            $urlRedirect = URLADM . "list-types-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
