<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página apagar cor
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class DeleteColors
{   
    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    public function index(int|string|null $id = null): void
    {   
        if (!empty($id)){
            $this->id = (int) $id;
            $deleteColor = new \App\adms\Models\AdmsDeleteColors();
            $deleteColor->deleteColor($this->id);
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar uma cor!</p>";
        }

        $urlRedirect = URLADM . "list-colors/index";
        header("Location: $urlRedirect");
    }
}