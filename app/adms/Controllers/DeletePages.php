<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller apagar página
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class DeletePages
{

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;
    
    /**
     * Método apagar página
     * Se existir o ID na URL instancia a MODELS para excluir o registro no banco de dados
     * Senão criar a mensagem de erro
     * Redireciona para a página listar página
     *
     * @param integer|string|null|null $id Receber o id do registro que deve ser excluido
     * @return void
     */
    public function index(int|string|null $id = null): void
    {

        if (!empty($id)) {
            $this->id = (int) $id;
            $deletePages = new \App\adms\Models\AdmsDeletePages();
            $deletePages->deletePages($this->id);            
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar uma página!</p>";
        }

        $urlRedirect = URLADM . "list-pages/index";
        header("Location: $urlRedirect");

    }
}
