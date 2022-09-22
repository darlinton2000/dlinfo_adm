<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller editar situação páginas
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditSitsPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Método editar situação páginas.
     * Receber os dados do formulário.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações da situação no banco de dados, se encontrar instancia o método "viewEditSitPages". Se não existir redireciona para o listar situações de páginas.
     * 
     * Se não existir o usuário clicar no botão acessa o ELSE e instancia o método "editSitPages".
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditSitPages']))) {
            $this->id = (int) $id;
            $viewSitPages = new \App\adms\Models\AdmsEditSitsPages();
            $viewSitPages->viewSitPages($this->id);
            if ($viewSitPages->getResult()) {
                $this->data['form'] = $viewSitPages->getResultBd();
                $this->viewEditSitPages();
            } else {
                $urlRedirect = URLADM . "list-sits-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editSitPages();
        }
    }

    /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditSitPages(): void
    {        
        $listSelect = new \App\adms\Models\AdmsEditSitsPages();
        $this->data['select'] = $listSelect->listSelect();

        $this->data['sidebarActive'] = "list-sits-pages";
        $loadView = new \Core\ConfigView("adms/Views/sitsPages/editSitPages", $this->data);
        $loadView->loadView();
    }

    /**
     * Editar situação páginas.
     * Se o usuário clicou no botão, instancia a MODELS responsável em receber os dados e editar no banco de dados.
     * Verifica se editou corretamente a situação no banco de dados.
     * Se o usuário não clicou no botão redireciona para página listar situação.
     *
     * @return void
     */
    private function editSitPages(): void
    {
        if (!empty($this->dataForm['SendEditSitPages'])) {
            unset($this->dataForm['SendEditSitPages']);
            $editSitPages = new \App\adms\Models\AdmsEditSitsPages();
            $editSitPages->update($this->dataForm);
            if($editSitPages->getResult()){
                $urlRedirect = URLADM . "view-sits-pages/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditSitPages();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Situação de página não encontrada!</p>";
            $urlRedirect = URLADM . "list-sits-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
