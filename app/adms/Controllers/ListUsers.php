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
    
    /** @var string|int|null $page Recebe o número da página*/
    private string|int|null $page;

    /**
     * Método listar usuários.
     * 
     * Instancia a MODELS responsável em buscar os registros no banco de dados.
     * Se encontrar registro no banco de dados envia para a VIEW.
     * Se não envia o array de dados vazio.
     *
     * @param string|integer|null|null $page
     * @return void
     */
    public function index(string|int|null $page = null)
    {   
        $this->page = (int) $page ? $page : 1;
        $listUsers = new \App\adms\Models\AdmsListUsers();
        $listUsers->listUsers($this->page);
        if ($listUsers->getResult()){
            $this->data['listUsers'] = $listUsers->getResultBd();
            $this->data['pagination'] = $listUsers->getResultPg();
        } else {
            $this->data['listUsers'] = [];
        }

        $loadView = new \Core\ConfigView("adms/Views/users/listUsers", $this->data);
        $loadView->loadView();
    }
}