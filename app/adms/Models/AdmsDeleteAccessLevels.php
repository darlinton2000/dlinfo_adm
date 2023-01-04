<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar nivel de acesso no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsDeleteAccessLevels
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
     * Metodo recebe como parametro o ID do registro que sera excluido
     * Chama as funcoes viewSit e checkAccessLevelUsed para fazer a confirmacao do registro antes de excluir
     * @param integer $id
     * @return void
     */
    public function deleteAccessLevel(int $id): void
    {
        $this->id = (int) $id;

        if ($this->viewAccessLevel()) {
            /* $deleteLevelPages = new \App\adms\Models\helper\AdmsDelete();
            $deleteLevelPages->exeDelete("adms_levels_pages", "WHERE adms_access_level_id =:adms_access_level_id", "adms_access_level_id={$this->id}"); */

            $deleteAccessLevel = new \App\adms\Models\helper\AdmsDelete();
            $deleteAccessLevel->exeDelete("adms_access_levels", "WHERE id =:id", "id={$this->id}");

            if ($deleteAccessLevel->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Nível de acesso apagado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nível de acesso não apagado com sucesso!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /**
     * Metodo verifica se o nivel de acesso esta cadastrada na tabela e envia o resultado para a funcao deleteAccessLevel
     * @return boolean
     */
    private function viewAccessLevel(): bool
    {

        $viewAccessLevel = new \App\adms\Models\helper\AdmsRead();
        $viewAccessLevel->fullRead(
            "SELECT id
                FROM adms_access_levels                           
                WHERE id=:id AND order_levels > :order_levels
                LIMIT :limit", "id={$this->id}&order_levels=" . $_SESSION['order_levels'] . "&limit=1"
        );

        $this->resultBd = $viewAccessLevel->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nível de acesso não encontrado!</p>";
            return false;
        }
    }
}
