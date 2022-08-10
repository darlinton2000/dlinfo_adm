<?php

namespace App\adms\Controllers;

/**
 * Controller da página login
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class Login
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
        
        if (!empty($this->dataForm['SendLogin'])){
            $valLogin = new \App\adms\Models\AdmsLogin;
            $valLogin->login($this->dataForm);
            if ($valLogin->getResult()){
                $urlRedirect = URLADM . "dashboard/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
            }
        }

        //$this->data = null;

        $loadView = new \Core\ConfigView("adms/Views/login/login", $this->data);
        $loadView->loadViewLogin();
    }
}