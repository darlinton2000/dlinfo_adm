<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller editar grupos de página
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditGroupsPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Método editar grupos de página.
     * Receber os dados do formulário.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações do grupo no banco de dados, se encontrar instancia o método "viewEditGroupsPages". Se não existir redireciona para o listar grupo de página.
     * 
     * Se não existir o usuário clicar no botão acessa o ELSE e instancia o método "editGroupsPages".
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditGroupsPages']))) {
            $this->id = (int) $id;
            $viewGroupsPages = new \App\adms\Models\AdmsEditGroupsPages();
            $viewGroupsPages->viewGroupsPages($this->id);
            if ($viewGroupsPages->getResult()) {
                $this->data['form'] = $viewGroupsPages->getResultBd();
                $this->viewEditGroupsPages();
            } else {
                $urlRedirect = URLADM . "list-groups-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editGroupsPages();
        }
    }

    /**     
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditGroupsPages(): void
    { 
        $this->data['sidebarActive'] = "list-groups-pages";
        $loadView = new \Core\ConfigView("adms/Views/groupsPages/editGroupsPages", $this->data);
        $loadView->loadView();
    }

    /**
     * Editar grupo de página.
     * Se o usuário clicou no botão, instancia a MODELS responsável em receber os dados e editar no banco de dados.
     * Verifica se editou corretamente o grupo no banco de dados.
     * Se o usuário não clicou no botão redireciona para página listar grupo.
     *
     * @return void
     */
    private function editGroupsPages(): void
    {
        if (!empty($this->dataForm['SendEditGroupsPages'])) {
            unset($this->dataForm['SendEditGroupsPages']);
            $editGroupsPages = new \App\adms\Models\AdmsEditGroupsPages();
            $editGroupsPages->update($this->dataForm);
            if($editGroupsPages->getResult()){
                $urlRedirect = URLADM . "view-groups-pages/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewEditGroupsPages();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Grupo de página não encontrado!</p>";
            $urlRedirect = URLADM . "list-groups-pages/index";
            header("Location: $urlRedirect");
        }
    }
}
