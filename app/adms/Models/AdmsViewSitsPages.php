<?php

namespace App\adms\Models;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar situação páginas no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsViewSitsPages
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
     * Metodo para visualizar os detalhes da situação de página
     * Recebe o ID da situação de página que será usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro
     * @param integer $id
     * @return void
     */
    public function viewSitPages(int $id): void
    {
        $this->id = $id;

        $viewSitPages = new \App\adms\Models\helper\AdmsRead();
        $viewSitPages->fullRead("SELECT sit_pgs.id, sit_pgs.name, sit_pgs.created, sit_pgs.modified,
                            col.color
                            FROM adms_sits_pgs AS sit_pgs
                            INNER JOIN adms_colors AS col ON col.id=sit_pgs.adms_color_id
                            WHERE sit_pgs.id=:id
                            LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewSitPages->getResult();        
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Situação de página não encontrada!</p>";
            $this->result = false;
        }
    }
}
