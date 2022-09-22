<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar tipos de página
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ViewTypesPages
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Metodo visualizar tipos de página
     * Recebe como parametro o ID que será usado para pesquisar as informações no banco de dados e instancia a MODELS AdmsViewTypesPages
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão é redirecionado para o listar tipos de página
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;

            $viewTypesPages = new \App\adms\Models\AdmsViewTypesPages();
            $viewTypesPages->viewTypesPages($this->id);
            if ($viewTypesPages->getResult()) {
                $this->data['viewTypesPages'] = $viewTypesPages->getResultBd();
                $this->viewTypesPages();
            } else {
                $urlRedirect = URLADM . "list-types-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Tipos de página não encontrado!</p>";
            $urlRedirect = URLADM . "list-types-pages/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewTypesPages(): void
    {
        $this->data['sidebarActive'] = "list-types-pages";
        $loadView = new \Core\ConfigView("adms/Views/typesPages/viewTypesPages", $this->data);
        $loadView->loadView();
    }
}
