<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar as cores
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsLevelsForms
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
     * @return array|null Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function viewLevelsForms(): void
    {
        $viewLevelForm = new \App\adms\Models\helper\AdmsRead();
        $viewLevelForm->fullRead("SELECT forms.id, lev.name AS lev_name, sit.name AS sit_name, col.color, forms.created, forms.modified 
                                    FROM adms_levels_forms AS forms
                                    INNER JOIN adms_access_levels AS lev ON forms.adms_access_level_id = lev.id
                                    INNER JOIN adms_sits_users AS sit ON forms.adms_sits_user_id = sit.id
                                    INNER JOIN adms_colors AS col ON sit.adms_color_id = col.id
                                    LIMIT :limit", "limit=1");

        $this->resultBd = $viewLevelForm->getResult();
        if ($this->resultBd){
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Pagina de configuração não encontrada!</p>";
            $this->result = false;
        }   
    }
}
