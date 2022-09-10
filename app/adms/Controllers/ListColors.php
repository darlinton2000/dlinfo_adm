<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página listar cores
 * 
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ListColors
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data;

    /** @var string|int|null $page Recebe o número da página*/
    private string|int|null $page;

    public function index(string|int|null $page = null)
    {   
        $this->page = (int) $page ? $page : 1;
        $listColors = new \App\adms\Models\AdmsListColors();
        $listColors->listColors($this->page);
        if ($listColors->getResult()){
            $this->data['listColors'] = $listColors->getResultBd();
            $this->data['pagination'] = $listColors->getResultPg();
        } else {
            $this->data['listColors'] = [];
        }

        $this->data['sidebarActive'] = "list-colors";

        $loadView = new \Core\ConfigView("adms/Views/colors/listColors", $this->data);
        $loadView->loadView();
    }
}