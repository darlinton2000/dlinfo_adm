<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar configuração de e-mail
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditConfEmails
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data = [];

    /** @var array|null $dataForm Recebe os dados do formulário */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "salvar" do formulário da página editar configuração de e-mail Acessa o IF e instância a classe "AdmsEditConfEmails" responsável em editar a configuração de e-mail no banco de dados.
     * Configuração de e-mail editada com sucesso, redireciona para a página listar e-mail.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {   
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id) and (empty($this->dataForm['SendEditConfEmail'])))){
            $this->id = (int) $id;
            $viewConfEmail = new \App\adms\Models\AdmsEditConfEmails();
            $viewConfEmail->viewConfEmail($this->id);
            if ($viewConfEmail->getResult()){
                $this->data['form'] = $viewConfEmail->getResultBd();
                $this->viewEditConfEmail();
            } else {
                $urlRedirect = URLADM . "list-conf-emails/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editConfEmail();
        }
    }       

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditConfEmail(): void
    {   
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();
        
        $this->data['sidebarActive'] = "list-conf-emails";
        
        $loadView = new \Core\ConfigView("adms/Views/confEmails/editConfEmails", $this->data);
        $loadView->loadView();
    }

    private function editConfEmail(): void
    {
        if (!empty($this->dataForm['SendEditConfEmail'])){
             unset($this->dataForm['SendEditConfEmail']);
             $editConfEmail = new \App\adms\Models\AdmsEditConfEmails();
             $editConfEmail->update($this->dataForm);
             if ($editConfEmail->getResult()){
                $urlRedirect = URLADM . "view-conf-emails/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
             } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditConfEmail();
             }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Configuração de e-mail não encontrada!</p>";
            $urlRedirect = URLADM . "list-conf-emails/index";
            header("Location: $urlRedirect");
        }
    }
}