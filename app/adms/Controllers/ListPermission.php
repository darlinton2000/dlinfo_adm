<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da pagina listar permissoes
 * 
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ListPermission
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data;
    
    /** @var string|int|null $page Recebe o numero da pagina*/
    private string|int|null $page;

    /** @var string|int|null $level Recebe o id do nivel de acesso*/
    private string|int|null $level;

    /**
     * Metodo listar permissoes.
     * 
     * Instancia a MODELS responsavel em buscar os registros no banco de dados.
     * Se encontrar registro no banco de dados envia para a VIEW.
     * Se não envia o array de dados vazio.
     *
     * @param string|integer|null|null $page
     * @return void
     */
    public function index(string|int|null $page = null)
    {   
        $this->level = filter_input(INPUT_GET, 'level', FILTER_SANITIZE_NUMBER_INT);

        $this->page = (int) $page ? $page : 1;
        $listPermission = new \App\adms\Models\AdmsListPermission();
        $listPermission->listPermission($this->page, $this->level);
        if ($listPermission->getResult()){
            $this->data['listPermission'] = $listPermission->getResultBd();
            $this->data['viewAccessLevel'] = $listPermission->getResultBdLevel();
            $this->data['pagination'] = $listPermission->getResultPg();
            $this->viewPermission();
        } else {
            //$this->data['listPermission'] = [];
            //$this->data['pagination'] = null;
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Instancia a classe responsavel em carregar a VIEW e evniar os dados para a VIEW.
     *
     */
    private function viewPermission(): void
    {   
        $this->data['sidebarActive'] = "list-access-levels";
        
        $loadView = new \Core\ConfigView("adms/Views/permission/listPermission", $this->data);
        $loadView->loadView();
    }
}