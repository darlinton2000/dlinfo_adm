<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar situação páginas
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ListSitsPages
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /**
     * Método listar situação páginas.
     * 
     * Instancia a MODELS responsável em buscar os registros no banco de dados.
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão enviar o array de dados vazio.
     *
     * @return void
     */
    public function index(string|int|null $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $listSitsPages = new \App\adms\Models\AdmsListSitsPages();
        $listSitsPages->listSitsPages($this->page);
        if ($listSitsPages->getResult()) {
            $this->data['listSitsPages'] = $listSitsPages->getResultBd();
            $this->data['pagination'] = $listSitsPages->getResultPg();
        } else {
            $this->data['listSitsPages'] = [];
        }

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "list-sits-pages"; 
        
        $loadView = new \Core\ConfigView("adms/Views/sitsPages/listSitPages", $this->data);
        $loadView->loadView();
    }
}
