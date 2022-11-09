<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página cadastrar nova cor
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AddColors
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data = [];

    /** @var array|null $dataForm Recebe os dados do formulário */
    private array|null $dataForm;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página cadastrar cor. Acessa o IF e instância a classe "AdmsAddColors" responsável em cadastrar a cor no banco de dados.
     * Cor cadastrada com sucesso, redireciona para a página listar cores.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {   
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->dataForm['SendAddColor'])){
            unset($this->dataForm['SendAddColor']);
            $createColor = new \App\adms\Models\AdmsAddColors();
            $createColor->create($this->dataForm);
            if ($createColor->getResult()){
                $urlRedirect = URLADM . "list-colors/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddColor();
            }
        } else {
            $this->viewAddColor();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddColor(): void
    {
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        
        $this->data['sidebarActive'] = "list-colors";
        
        $loadView = new \Core\ConfigView("adms/Views/colors/addColors", $this->data);
        $loadView->loadView();
    }
}