<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar cores
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ViewColors
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW */
    private array|string|null $data;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Metodo visualizar cor
     * Recebe como parametro o ID que sera usado para pesquisar as informações no banco de dados e instacia a MODELS admsViewColors
     * Se encontrar o registro no banco de dados envia para a VIEW
     * Se não é redirecionado para o listar cores
     *
     * @return void
     */
    public function index(int|string|null $id = null): void
    {   
        if (!empty($id)){
            //Convertendo para int
            $this->id = (int) $id;

            $viewColor = new \App\adms\Models\AdmsViewColors();
            $viewColor->viewColor($this->id);
            if ($viewColor->getResult()){
                $this->data['viewColor'] = $viewColor->getResultBd();
                $this->viewColor();
            } else {
                $urlRedirect = URLADM . "list-colors/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Cor não encontrada!</p>";
            $urlRedirect = URLADM . "list-colors/index";
            header("Location: $urlRedirect");
        }
    }

    private function viewColor(): void
    {   
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        
        $this->data['sidebarActive'] = "list-colors";
        
        $loadView = new \Core\ConfigView("adms/Views/colors/viewColors", $this->data);
        $loadView->loadView();
    }
}