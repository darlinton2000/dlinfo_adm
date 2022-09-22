<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller editar página
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Método editar página.
     * Receber os dados do formulário.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações da página no banco de dados, se encontrar instancia o método "viewEditPages". Se não existir redireciona para o listar páginas.
     * 
     * Se não existir o usuário clicar no botão acessa o ELSE e instancia o método "editPages".
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditPages']))) {
            $this->id = (int) $id;
            $viewPages = new \App\adms\Models\AdmsEditPages();
            $viewPages->viewPages($this->id);
            if ($viewPages->getResult()) {
                $this->data['form'] = $viewPages->getResultBd();
                $this->viewEditPages();
            } else {
                $urlRedirect = URLADM . "list-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editPages();
        }
    }

    /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditPages(): void
    {
        $listSelect = new \App\adms\Models\AdmsEditPages();
        $this->data['select'] = $listSelect->listSelect();

        $this->data['sidebarActive'] = "list-pages";
        $loadView = new \Core\ConfigView("adms/Views/pages/editPages", $this->data);
        $loadView->loadView();
    }

    /**
     * Editar página.
     * Se o usuário clicou no botão, instancia a MODELS responsável em receber os dados e editar no banco de dados.
     * Verifica se editou corretamente a página no banco de dados.
     * Se o usuário não clicou no botão redireciona para página listar página.
     *
     * @return void
     */
    private function editPages(): void
    {
        if (!empty($this->dataForm['SendEditPages'])) {
            unset($this->dataForm['SendEditPages']);
            $editPages = new \App\adms\Models\AdmsEditPages();
            $editPages->update($this->dataForm);
            if ($editPages->getResult()) {
                $urlRedirect = URLADM . "view-pages/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditPages();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Página não encontrada!</p>";
            $urlRedirect = URLADM . "list-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
