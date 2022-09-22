<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar tipos de página no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsViewTypesPages
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * Metodo para visualizar os detalhes do tipos de página
     * Recebe o ID do tipo de página que será usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro
     * @param integer $id
     * @return void
     */
    public function viewTypesPages(int $id): void
    {
        $this->id = $id;

        $viewTypesPages = new \App\adms\Models\helper\AdmsRead();
        $viewTypesPages->fullRead("SELECT id, type, name, order_type_pg, obs, created, modified
                            FROM adms_types_pgs
                            WHERE id=:id
                            LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewTypesPages->getResult();        
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Tipo de página não encontrado!</p>";
            $this->result = false;
        }
    }
}
