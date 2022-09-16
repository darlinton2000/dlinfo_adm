<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página apagar configuração de e-mail
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class DeleteConfEmails
{   
    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    public function index(int|string|null $id = null): void
    {   
        if (!empty($id)){
            $this->id = (int) $id;
            $deleteConfEmail = new \App\adms\Models\AdmsDeleteConfEmails();
            $deleteConfEmail->deleteConfEmail($this->id);
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar uma configuração de e-mail!</p>";
        }

        $urlRedirect = URLADM . "list-conf-emails/index";
        header("Location: $urlRedirect");
    }
}