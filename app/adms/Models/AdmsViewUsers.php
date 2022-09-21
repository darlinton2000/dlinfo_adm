<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar os usuários do banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsViewUsers
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

    public function viewUser(int $id): void
    {
        $this->id = $id;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT usr.id, usr.name AS name_usr, usr.nickname, usr.email, usr.user, usr.image, usr.created, usr.modified, 
                                            sit.name AS name_sit,
                                            col.color,
                                            lev.id AS id_lev, lev.name AS name_lev
                                            FROM adms_users AS usr 
                                            INNER JOIN adms_sits_users AS sit ON sit.id = usr.adms_sits_user_id
                                            INNER JOIN adms_colors AS col ON col.id = sit.adms_color_id
                                            INNER JOIN adms_access_levels AS lev ON lev.id = usr.adms_access_level_id 
                                            WHERE usr.id=:id AND lev.order_levels > :order_levels
                                            LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1");

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd){
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não encontrado!</p>";
            $this->result = false;
        }   
    }
}
