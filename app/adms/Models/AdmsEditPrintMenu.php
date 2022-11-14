<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Models editar imprimir o item de menu
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsEditPrintMenu
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informacoes que devem ser salvas no banco de dados */
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
     * Metodo que recebe como parametro o ID que sera usado para verificar se tem o registro cadastrado no banco de dados
     *
     * @param integer $id
     * @return void
     */
    public function editPrintMenu(int $id): void
    {
        $this->id = $id;

        $viewPrintMenu = new \App\adms\Models\helper\AdmsRead();
        $viewPrintMenu->fullRead("SELECT lev_pag.id, lev_pag.print_menu 
                                    FROM adms_levels_pages AS lev_pag
                                    INNER JOIN adms_access_levels AS lev ON lev.id=lev_pag.adms_access_level_id 
                                    WHERE lev_pag.id=:id 
                                    AND lev.order_levels >= :order_levels
                                    LIMIT :limit", "id={$this->id}&order_levels=".$_SESSION['order_levels']."&limit=1");

        $this->resultBd = $viewPrintMenu->getResult();
        if ($this->resultBd){
            $this->edit();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar um item de menu!</p>";
            $this->result = false;
        }   
    }

    /**
     * Metodo para alterar o item do mundo no banco de dados.
     * Retorna TRUE quando editar no banco de dados.
     * Retorna FALSE se houver algum erro.
     * @return void
     */
    private function edit(): void
    {
        if ($this->resultBd[0]['print_menu'] == 1){
            $this->data['print_menu'] = 2;
        } else {
            $this->data['print_menu'] = 1;
        }
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upPrintMenu = new \App\adms\Models\helper\AdmsUpdate();
        $upPrintMenu->exeUpdate("adms_levels_pages", $this->data, "WHERE id=:id", "id={$this->id}");

        if ($upPrintMenu->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Item de menu editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Item de menu não editado com sucesso!</p>";
            $this->result = false;
        }
    }
}
