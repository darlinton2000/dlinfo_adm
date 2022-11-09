<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller cadastrar nivel de acesso
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AddAccessLevels
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**     
     * Metodo cadastrar nivel de acesso
     * Receber os dados do formulario.
     * Quando o usuario clicar no botao "cadastrar" do formulario da pagina novo nivel de acesso. Acessa o IF e instância a classe "AdmsAddAccessLevels" responsavel em cadastrar o nivel de acesso no banco de dados.
     * Nivel de acesso cadastrado com sucesso, redireciona para a pagina listar registros.
     * Senao, instância a classe responsavel em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendAddAccessLevels'])) {
            unset($this->dataForm['SendAddAccessLevels']);
            $createAccessLevels = new \App\adms\Models\AdmsAddAccessLevels();
            $createAccessLevels->create($this->dataForm);
            if ($createAccessLevels->getResult()) {
                $urlRedirect = URLADM . "list-access-levels/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddAccessLevels();
            }
        } else {
            $this->viewAddAccessLevels();
        }
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddAccessLevels(): void
    {
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        
        $this->data['sidebarActive'] = "list-access-levels"; 
        
        $loadView = new \Core\ConfigView("adms/Views/accessLevels/addAccessLevels", $this->data);
        $loadView->loadView();
    }
}
