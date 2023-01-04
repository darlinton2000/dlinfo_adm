<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar o nivel de acesso para o formulario novo usuario na pagina de login
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ViewLevelsForms
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW */
    private array|string|null $data;

    /**
     * Metodo visualizar o nivel de acesso para o formulario novo usuario na pagina de login
     * Instancia a MODELS
     * Se encontrar o registro no banco de dados envia para a VIEW
     * Se não é redirecionado para o dashboard
     * @return void
     */
    public function index(): void
    {   
        $viewLevelsForm = new \App\adms\Models\AdmsLevelsForms();
        $viewLevelsForm->viewLevelsForms();
        if ($viewLevelsForm->getResult()){
            $this->data['viewLevelsForm'] = $viewLevelsForm->getResultBd();
            $this->viewLevelsForm();
        } else {
            /* $_SESSION['msg'] = "<p class='alert-danger'>Erro: Página de configuração não encontrada!</p>"; */
            $urlRedirect = URLADM . "dashboard/index";
            header("Location: $urlRedirect");
        }
        
    }

    /**
     * Instancia a classe responsavel em carregar a VIEW e enviar os dados para a VIEW
     *
     * @return void
     */
    private function viewLevelsForm(): void
    {   
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        
        $this->data['sidebarActive'] = "view-levels-forms";
        
        $loadView = new \Core\ConfigView("adms/Views/levelsForms/viewlevelsForms", $this->data);
        $loadView->loadView();
    }
}