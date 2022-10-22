<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar permissao
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditPermission
{   
    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var int|string|null $level Recebe o nivel de acesso */
    private int|string|null $level;

    /** @var int|string|null $pag Recebe o numero da pagina */
    private int|string|null $pag;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "salvar" do formulário da página editar cor Acessa o IF e instância a classe "AdmsEditColors" responsável em editar a cor no banco de dados.
     * Cor editada com sucesso, redireciona para a página listar cores.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {   
       $this->id = $id;
       $this->level = filter_input(INPUT_GET, "level", FILTER_SANITIZE_NUMBER_INT);
       $this->pag = filter_input(INPUT_GET, "pag", FILTER_SANITIZE_NUMBER_INT);

       if ((!empty($this->id)) and (!empty($this->level)) and (!empty($this->pag))){
            $editPermission = new \App\adms\Models\AdmsEditPermission();
            $editPermission->editPermission($this->id);

            $urlRedirect = URLADM . "list-permission/index/{$this->pag}?level={$this->level}";
            header("Location: $urlRedirect");
       } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar a página para liberar a permissão!</p>";
            $urlRedirect = URLADM . "list-access-levels/index";
            header("Location: $urlRedirect");
       }
    }       
}