<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página alterar ordem do nível de acesso
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class OrderAccessLevels
{
    /** @var array|string|null $pag Recebe o número da página */
    private array|string|null $pag;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Metodo alterar ordem do nível de acesso
     * Recebe como parâmetro o ID que será usado para pesquisar as informações no banco de dados e instancia a models "AdmsOrderAccessLevels"
     * Após editar ou der erro redireciona para o listar nível de acesso
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

        if ((!empty($id)) and (!empty($this->pag))) {
            //Convertendo para int
            $this->id = (int) $id;

            $viewAccessLevel = new \App\adms\Models\AdmsOrderAccessLevels();
            $viewAccessLevel->orderAccessLevels($this->id);
            if ($viewAccessLevel->getResult()) {
                $urlRedirect = URLADM . "list-access-levels/index/{$this->pag}";
                header("Location: $urlRedirect");
            } else {
                $urlRedirect = URLADM . "list-access-levels/index/{$this->pag}";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nível de acesso não encontrado!</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
        }
    }
}
