<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar nivel de acesso
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ListAccessLevels
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /**
     * Método listar cores.
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

        $listAccessLevels = new \App\adms\Models\AdmsListAccessLevels();
        $listAccessLevels->listAccessLevels($this->page);
        if ($listAccessLevels->getResult()) {
            $this->data['listAccessLevels'] = $listAccessLevels->getResultBd();
            $this->data['pagination'] = $listAccessLevels->getResultPg();
        } else {
            $this->data['listAccessLevels'] = [];
        }

        $this->data['pag'] = $this->page;
        $this->data['sidebarActive'] = "list-access-levels";         
        $loadView = new \Core\ConfigView("adms/Views/accessLevels/listAccessLevels", $this->data);
        $loadView->loadView();
    }
}
