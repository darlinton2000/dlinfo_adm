<?php

namespace App\adms\Controllers;

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