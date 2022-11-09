<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página cadastrar nova configuração de e-mail
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AddConfEmails
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data = [];

    /** @var array|null $dataForm Recebe os dados do formulário */
    private array|null $dataForm;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página nova configuração de e-mail. Acessa o IF e instância a classe "AdmsAddConfEmails" responsável em cadastrar a nova configuração de e-mail no banco de dados.
     * Configuração de e-mail cadastrada com sucesso, redireciona para a página listar e-mail.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {   
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->dataForm['SendAddConfEmail'])){
            unset($this->dataForm['SendAddConfEmail']);
            $createConfEmail = new \App\adms\Models\AdmsAddConfEmails();
            $createConfEmail->create($this->dataForm);
            if ($createConfEmail->getResult()){
                $urlRedirect = URLADM . "list-conf-emails/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddConfEmail();
            }
        } else {
            $this->viewAddConfEmail();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddConfEmail(): void
    {
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        
        $this->data['sidebarActive'] = "list-conf-emails";
        
        $loadView = new \Core\ConfigView("adms/Views/confEmails/addConfEmails", $this->data);
        $loadView->loadView();
    }
}