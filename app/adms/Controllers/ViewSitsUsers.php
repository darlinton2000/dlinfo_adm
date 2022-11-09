<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar situações
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ViewSitsUsers
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW */
    private array|string|null $data;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     *
     * @return void
     */
    public function index(int|string|null $id = null): void
    {   
        if (!empty($id)){
            //Convertendo para int
            $this->id = (int) $id;

            $viewSitUser = new \App\adms\Models\AdmsViewSitsUsers();
            $viewSitUser->viewSitUser($this->id);
            if ($viewSitUser->getResult()){
                $this->data['viewSitUser'] = $viewSitUser->getResultBd();
                $this->viewSitUser();
            } else {
                $urlRedirect = URLADM . "list-sits-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Situação não encontrada!</p>";
            $urlRedirect = URLADM . "list-sits-users/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewSitUser(): void
    {   
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        
        $this->data['sidebarActive'] = "list-sits-users";
        
        $loadView = new \Core\ConfigView("adms/Views/sitsUser/viewSitUser", $this->data);
        $loadView->loadView();
    }
}