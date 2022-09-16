<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página erro
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class Erro
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
        echo "Pagina de erro<br>";

        $this->data = "<p class='alert-danger'>Página não encontrada!</p>";

        $loadView = new \Core\ConfigView("adms/Views/erro/erro", $this->data);
        $loadView->loadViewLogin();
    }
}