<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller apagar nivel de acesso
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class DeleteAccessLevels
{

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;
    
    /**
     * Metodo apagar nivel de acesso
     * Se existir o ID na URL instancia a MODELS para excluir o registro no banco de dados
     * Senao criar a mensagem de erro
     * Redireciona para a pagina listar nivel de acesso
     *
     * @param integer|string|null|null $id Receber o id do registro que deve ser excluido
     * @return void
     */
    public function index(int|string|null $id = null): void
    {

        if (!empty($id)) {
            $this->id = (int) $id;
            $deleteAccessLevel = new \App\adms\Models\AdmsDeleteAccessLevels();
            $deleteAccessLevel->deleteAccessLevel($this->id);            
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar um nível de acesso!</p>";
        }

        $urlRedirect = URLADM . "list-access-levels/index";
        header("Location: $urlRedirect");

    }
}
