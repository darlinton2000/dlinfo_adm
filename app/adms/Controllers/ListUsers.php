<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar usuários
 * 
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ListUsers
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /**
     * Método listar usuários.
     * 
     * Instancia a MODELS responsável em buscar os registros no banco de dados.
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão enviar o array de dados vazio.
     *
     * @return void
     */
    public function index(string|int|null $page = null)
    {
        $this->page = (int) $page ? $page : 1;

        $listUsers = new \App\adms\Models\AdmsListUsers();
        $listUsers->listUsers($this->page);
        if($listUsers->getResult()){
            $this->data['listUsers'] = $listUsers->getResultBd(); 
            $this->data['pagination'] = $listUsers->getResultPg();
        }else{
            $this->data['listUsers'] = [];
        }

        $button = ['add_users' => ['menu_controller' => 'add-users', 'menu_metodo' => 'index'], 
                    'view_users' => ['menu_controller' => 'view-users', 'menu_metodo' => 'index'], 
                    'edit_users' => ['menu_controller' => 'edit-users', 'menu_metodo' => 'index'],
                    'delete_users' => ['menu_controller' => 'delete-users', 'menu_metodo' => 'index']];

        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        
        $this->data['sidebarActive'] = "list-users"; 

        $loadView = new \Core\ConfigView("adms/Views/users/listUsers", $this->data);
        $loadView->loadView();
    }
}
