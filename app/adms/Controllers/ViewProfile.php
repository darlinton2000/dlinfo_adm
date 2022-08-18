<?php

namespace App\adms\Controllers;

/**
 * Controller da página visualizar perfil
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ViewProfile
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW */
    private array|string|null $data;

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     *
     * @return void
     */
    public function index(): void
    {   
            $viewProfile = new \App\adms\Models\AdmsViewProfile();
            $viewProfile->viewProfile();
            if ($viewProfile->getResult()){
                $this->data['viewProfile'] = $viewProfile->getResultBd();
                $this->loadViewProfile();
            } else {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            }
    }

    private function loadViewProfile(): void
    {   
        $loadView = new \Core\ConfigView("adms/Views/users/viewProfile", $this->data);
        $loadView->loadView();
    }
}