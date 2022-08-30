<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página apagar situação
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class DeleteSitsUsers
{   
    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    public function index(int|string|null $id = null): void
    {   
        if (!empty($id)){
            $this->id = (int) $id;
            $deleteSitUser = new \App\adms\Models\AdmsDeleteSitsUsers();
            $deleteSitUser->deleteSitUser($this->id);
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Necessário selecionar uma situação!</p>";
        }

        $urlRedirect = URLADM . "list-sits-users/index";
        header("Location: $urlRedirect");
    }
}