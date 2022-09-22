<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar detalhes da página
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ViewPages
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Metodo visualizar detalhe da página
     * Recebe como parametro o ID que será usado para pesquisar as informações no banco de dados e instancia a MODELS AdmsViewPages
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão é redirecionado para o listar páginas
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;

            $viewPages = new \App\adms\Models\AdmsViewPages();
            $viewPages->viewPages($this->id);
            if ($viewPages->getResult()) {
                $this->data['viewPages'] = $viewPages->getResultBd();
                $this->viewPages();
            } else {
                $urlRedirect = URLADM . "list-pages/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Página não encontrado!</p>";
            $urlRedirect = URLADM . "list-pages/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewPages(): void
    {
        $this->data['sidebarActive'] = "list-pages";
        $loadView = new \Core\ConfigView("adms/Views/pages/viewPages", $this->data);
        $loadView->loadView();
    }
}
