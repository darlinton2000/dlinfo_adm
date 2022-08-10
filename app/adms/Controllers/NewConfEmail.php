<?php

namespace App\adms\Controllers;

/**
 * Controller da página para receber novo link para confirmar o e-mail
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 * http://localhost/Adm/new-conf-email/index
 */
class NewConfEmail
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data = [];

    /** @var array|null $dataForm Recebe os dados do formulário */
    private array|null $dataForm;

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Verificando se o usuário clicou no botão no formulário
        if (!empty($this->dataForm['SendNewConfEmail'])){
            //Destruindo a posição 'SendNewConfEmail' do array
            unset($this->dataForm['SendNewConfEmail']);
            //Instanciando a classe
            $newConfEmail = new \App\adms\Models\AdmsNewConfEmail();
            //Passando os dados do formulário
            $newConfEmail->newConfEmail($this->dataForm);
            if ($newConfEmail->getResult()){
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewNewConfEmail();
            }
        } else {
            $this->viewNewConfEmail();
        }
    }

    private function viewNewConfEmail(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/login/newConfEmail", $this->data);
        $loadView->loadViewLogin();
    }
}