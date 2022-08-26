<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}


/**
 * Controller da pagina Dashboard
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class Dashboard
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data;

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     *
     * @return void
     */
    public function index(): void
    {
        $this->data = "Bem vindo";

        $loadView = new \Core\ConfigView("adms/Views/dashboard/dashboard", $this->data);
        $loadView->loadView();
    }
}