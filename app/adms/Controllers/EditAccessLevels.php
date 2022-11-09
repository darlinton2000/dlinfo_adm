<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller editar nivel de acesso
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditAccessLevels
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Metodo editar nivel de acesso.
     * Receber os dados do formulario.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuario nao clicou no botao editar, instancia a MODELS para recuperar as informacoes do nivel de acesso no banco de dados, se encontrar instancia o metodo "viewEditAccessLevels". Se não existir redireciona para o listar nivel de acesso.
     * 
     * Se nao existir o usuario clicar no botao acessa o ELSE e instancia o metodo "editAccessLeves".
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditAccessLevels']))) {
            $this->id = (int) $id;
            $viewAccessLevels = new \App\adms\Models\AdmsEditAccessLevels();
            $viewAccessLevels->viewAccessLevels($this->id);
            if ($viewAccessLevels->getResult()) {
                $this->data['form'] = $viewAccessLevels->getResultBd();
                $this->viewEditAccessLevels();
            } else {
                $urlRedirect = URLADM . "list-access-levels/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editAccessLevels();
        }
    }

    /**
     * Instanciar a classe responsavel em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditAccessLevels(): void
    {
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "list-access-levels"; 
        
        $loadView = new \Core\ConfigView("adms/Views/accessLevels/editAccessLevels", $this->data);
        $loadView->loadView();
    }

    /**
     * Editar nivel de acesso.
     * Se o usuario clicou no botao, instancia a MODELS responsavel em receber os dados e editar no banco de dados.
     * Verifica se editou corretamente o nivel de acesso no banco de dados.
     * Se o usuario nao clicou no botao redireciona para pagina listar nivel de acesso.
     *
     * @return void
     */
    private function editAccessLevels(): void
    {
        if (!empty($this->dataForm['SendEditAccessLevels'])) {
            unset($this->dataForm['SendEditAccessLevels']);
            $editAccessLevel = new \App\adms\Models\AdmsEditAccessLevels();
            $editAccessLevel->update($this->dataForm);
            if ($editAccessLevel->getResult()) {
                $urlRedirect = URLADM . "view-access-levels/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditAccessLevels();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nível de acesso não encontrado!</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }
}
