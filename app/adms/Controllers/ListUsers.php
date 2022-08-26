<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página listar usuários
 * 
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ListUsers
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data;

    public function index()
    {
        $listUsers = new \App\adms\Models\AdmsListUsers();
        $listUsers->listUsers();
        if ($listUsers->getResult()){
            $this->data['listUsers'] = $listUsers->getResultBd();
        } else {
            $this->data['listUsers'] = [];
        }

        $loadView = new \Core\ConfigView("adms/Views/users/listUsers", $this->data);
        $loadView->loadView();
    }
}