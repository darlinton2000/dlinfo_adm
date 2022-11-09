<?php

namespace App\adms\Controllers;

if(!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller cadastrar situação páginas
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AddSitsPages
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**     
     * Método cadastrar situação página 
     * Receber os dados do formulário.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página nova situação página. Acessa o IF e instância a classe "AdmsAddSitsPages" responsável em cadastrar a situação página no banco de dados.
     * Situação cadastrada com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);        

        if(!empty($this->dataForm['SendAddSitPages'])){
            unset($this->dataForm['SendAddSitPages']);
            $createSitPages = new \App\adms\Models\AdmsAddSitsPages();
            $createSitPages->create($this->dataForm);
            if($createSitPages->getResult()){
                $urlRedirect = URLADM . "list-sits-pages/index";
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewAddSitPages();
            }   
        }else{
            $this->viewAddSitPages();
        }  
    }

    /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddSitPages(): void
    {
        $listSelect = new \App\adms\Models\AdmsAddSitsPages();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "list-sits-pages";
        $loadView = new \Core\ConfigView("adms/Views/sitsPages/addSitPages", $this->data);
        $loadView->loadView();
    }
}
