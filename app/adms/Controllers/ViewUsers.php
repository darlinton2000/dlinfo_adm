<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar usuarios
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ViewUsers
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

            $viewUser = new \App\adms\Models\AdmsViewUsers();
            $viewUser->viewUser($this->id);
            if ($viewUser->getResult()){
                $this->data['viewUser'] = $viewUser->getResultBd();
                $this->viewUser();
            } else {
                $urlRedirect = URLADM . "list-users/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não encontrado!</p>";
            $urlRedirect = URLADM . "list-users/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewUser(): void
    {   
        $this->data['sidebarActive'] = "list-users";
        
        $loadView = new \Core\ConfigView("adms/Views/users/viewUser", $this->data);
        $loadView->loadView();
    }
}