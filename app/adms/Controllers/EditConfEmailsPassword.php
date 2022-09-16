<?php

namespace App\adms\Controllers;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página editar a senha configuração de e-mail
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditConfEmailsPassword
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data = [];

    /** @var array|null $dataForm Recebe os dados do formulário */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "salvar" do formulário da página editar senha configuração de e-mail, acessa o IF e instância a classe "AdmsEditConfEmailsPassword" responsável em editar a senha configuração de e-mail no banco de dados.
     * Senha configuração de e-mail editada com sucesso, redireciona para a página listar e-mail.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {   
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id) and (empty($this->dataForm['SendEditPassConfEmail'])))){
            $this->id = (int) $id;
            $viewPassConfEmail = new \App\adms\Models\AdmsEditConfEmailsPassword();
            $viewPassConfEmail->viewPassConfEmail($this->id);
            if ($viewPassConfEmail->getResult()){
                $this->data['form'] = $viewPassConfEmail->getResultBd();
                $this->viewEditPassConfEmail();
            } else {
                $urlRedirect = URLADM . "list-conf-emails/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editPassConfEmail();
        }
    }       

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditPassConfEmail(): void
    {   
        $loadView = new \Core\ConfigView("adms/Views/confEmails/editConfEmailsPassword", $this->data);
        $loadView->loadView();
    }

    private function editPassConfEmail(): void
    {
        if (!empty($this->dataForm['SendEditPassConfEmail'])){
             unset($this->dataForm['SendEditPassConfEmail']);
             $editPassConfEmail = new \App\adms\Models\AdmsEditConfEmailsPassword();
             $editPassConfEmail->update($this->dataForm);
             if ($editPassConfEmail->getResult()){
                $urlRedirect = URLADM . "view-conf-emails/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
             } else {
                $this->data['form'] = $this->dataForm;
                $this->editPassConfEmail();
             }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Configuração de e-mail não encontrada!</p>";
            $urlRedirect = URLADM . "list-conf-emails/index";
            header("Location: $urlRedirect");
        }
    }
}