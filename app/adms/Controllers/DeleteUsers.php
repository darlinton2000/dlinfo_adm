<?php

namespace App\adms\Controllers;

/**
 * Controller da página apagar usuário
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class DeleteUsers
{   
    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    public function index(int|string|null $id = null): void
    {   
        if (!empty($id)){
            $this->id = (int) $id;
            $deleteUser = new \App\adms\Models\AdmsDeleteUsers();
            $deleteUser->deleteUser($this->id);
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Necessário selecionar um usuário!</p>";
        }

        $urlRedirect = URLADM . "list-users/index";
        header("Location: $urlRedirect");
    }
}