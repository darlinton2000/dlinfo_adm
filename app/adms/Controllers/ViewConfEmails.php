<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar as configurações de e-mail
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ViewConfEmails
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

            $viewConfEmail = new \App\adms\Models\AdmsViewConfEmails();
            $viewConfEmail->viewConfEmail($this->id);
            if ($viewConfEmail->getResult()){
                $this->data['viewConfEmail'] = $viewConfEmail->getResultBd();
                $this->viewConfEmail();
            } else {
                $urlRedirect = URLADM . "list-conf-emails/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Configuração de E-mail não encontrada!</p>";
            $urlRedirect = URLADM . "list-conf-emails/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewConfEmail(): void
    {   
        $loadView = new \Core\ConfigView("adms/Views/confEmails/viewConfEmails", $this->data);
        $loadView->loadView();
    }
}