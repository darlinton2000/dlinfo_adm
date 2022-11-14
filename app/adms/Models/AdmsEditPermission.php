<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar permissao de acesso a pagina
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsEditPermission
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

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

    /**
     * Metodo recebe como parametro o ID que sera usado para verificar se tem o registro cadastrado no banco de dados
     * @param integer $id
     * @return void
     */
    public function editPermission(int $id): void
    {
        $this->id = $id;

        $viewPermission = new \App\adms\Models\helper\AdmsRead();
        $viewPermission->fullRead("SELECT lev_pag.id, lev_pag.permission FROM adms_levels_pages AS lev_pag 
                                    INNER JOIN adms_access_levels AS lev ON lev.id=lev_pag.adms_access_level_id
                                    LEFT JOIN adms_pages AS pag ON pag.id=lev_pag.adms_page_id 
                                    WHERE lev_pag.id=:id 
                                    AND lev.order_levels >:order_levels
                                    AND (((SELECT permission 
                                    FROM adms_levels_pages 
                                    WHERE adms_page_id = lev_pag.adms_page_id 
                                    AND adms_access_level_id = {$_SESSION['adms_access_level_id']}) = 1) 
                                    OR (publish = 1))
                                    LIMIT :limit", "id={$this->id}&order_levels=".$_SESSION['order_levels']."&limit=1");

        $this->resultBd = $viewPermission->getResult();
        if ($this->resultBd){
            $this->edit();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar uma página válida!</p>";
            $this->result = false;
        }   
    }

    /**
     * Metodo para alterar a permissao no banco de dados.
     * Retorna TRUE quando editar no banco de dados.
     * Retorna FALSE se houver algum erro.
     * @return void
     */
    private function edit(): void
    {
        if ($this->resultBd[0]['permission'] == 1){
            $this->data['permission'] = 2;
        } else {
            $this->data['permission'] = 1;
        }
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upPermission = new \App\adms\Models\helper\AdmsUpdate();
        $upPermission->exeUpdate("adms_levels_pages", $this->data, "WHERE id=:id", "id={$this->id}");

        if ($upPermission->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Permissão editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Permissão não editada com sucesso!</p>";
            $this->result = false;
        }
    }
}
