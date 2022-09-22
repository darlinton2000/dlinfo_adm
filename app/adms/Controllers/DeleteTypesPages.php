<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller apagar tipos de página
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class DeleteTypesPages
{

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;
    
    /**
     * Método apagar tipo de página
     * Se existir o ID na URL instancia a MODELS para excluir o registro no banco de dados
     * Senão criar a mensagem de erro
     * Redireciona para a página listar tipo de página
     *
     * @param integer|string|null|null $id Receber o id do registro que deve ser excluido
     * @return void
     */
    public function index(int|string|null $id = null): void
    {

        if (!empty($id)) {
            $this->id = (int) $id;
            $deleteTypesPages = new \App\adms\Models\AdmsDeleteTypesPages();
            $deleteTypesPages->deleteTypesPages($this->id);            
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar um tipo de página!</p>";
        }

        $urlRedirect = URLADM . "list-types-pages/index";
        header("Location: $urlRedirect");

    }
}
