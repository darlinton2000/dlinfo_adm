<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar tipos de página no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsDeleteTypesPages
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Metodo recebe como parametro o ID do registro que será excluido
     * Chama as funções viewTypesPages e checkStatusUsed para fazer a confirmação do registro antes de excluir
     * @param integer $id
     * @return void
     */
    public function deleteTypesPages(int $id): void
    {
        $this->id = (int) $id;

        if(($this->viewTypesPages()) and ($this->checkStatusUsed())){
            $deleteTypesPages = new \App\adms\Models\helper\AdmsDelete();
            $deleteTypesPages->exeDelete("adms_types_pgs", "WHERE id =:id", "id={$this->id}");
    
            if ($deleteTypesPages->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Tipo de página apagado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Tipo de página não apagado com sucesso!</p>";
                $this->result = false;
            }
        }else{
            $this->result = false;
        }
        
    }

    /**
     * Metodo verifica se o tipo de página esta cadastrado na tabela e envia o resultado para a função deleteTypesPages
     * @return boolean
     */
    private function viewTypesPages(): bool
    {

        $viewTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewTypesPages->fullRead("SELECT id
                            FROM adms_types_pgs                           
                            WHERE id=:id
                            LIMIT :limit","id={$this->id}&limit=1");

        $this->resultBd = $viewTypesPages->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Tipo de página não encontrado!</p>";
            return false;
        }
    }

    /**
     * Metodo verifica se tem páginas cadastradas usando o tipo de página a ser excluido, caso tenha a exclusão não é permitida
     * O resultado da pesquisa é enviada para a função deleteTypesPages
     * @return boolean
     */
    private function checkStatusUsed(): bool
    {
        $viewPagesAdd = new \App\adms\Models\helper\AdmsRead();
        $viewPagesAdd->fullRead("SELECT id FROM adms_pages WHERE adms_types_pgs_id =:adms_types_pgs_id LIMIT :limit", "adms_types_pgs_id={$this->id}&limit=1");
        if($viewPagesAdd->getResult()){
            $_SESSION['msg'] = "<p class='alert-warning'>Erro: Tipo de página não pode ser apagado, há páginas cadastradas com esse tipo!</p>";
            return false;
        }else{
            return true;
        }
    }
}
