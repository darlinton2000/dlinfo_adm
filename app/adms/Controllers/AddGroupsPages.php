<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller cadastrar grupos de página
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AddGroupsPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**     
     * Método cadastrar grupo de página
     * Receber os dados do formulário.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo grupo de página. Acessa o IF e instância a classe "AdmsAddGroupsPages" responsável em cadastrar o grupo de página no banco de dados.
     * Grupo cadastrado com sucesso, redireciona para a página listar grupos de página.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);        

        if(!empty($this->dataForm['SendAddGroupsPages'])){
            unset($this->dataForm['SendAddGroupsPages']);
            $createGroupsPages = new \App\adms\Models\AdmsAddGroupsPages();
            $createGroupsPages->create($this->dataForm);
            if($createGroupsPages->getResult()){
                $urlRedirect = URLADM . "list-groups-pages/index";
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewAddGroupsPages();
            }   
        }else{
            $this->viewAddGroupsPages();
        }  
    }

    /**
     * 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddGroupsPages(): void
    { 
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "list-groups-pages";
        
        $loadView = new \Core\ConfigView("adms/Views/groupsPages/addGroupsPages", $this->data);
        $loadView->loadView();
    }
}
