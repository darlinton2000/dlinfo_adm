<?php

namespace App\adms\Controllers;

/**
 * Controller da página novo usuário
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class NewUser
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data = [];

    /** @var array|null $dataForm Recebe os dados do formulário */
    private array|null $dataForm;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo usuário. Acessa o IF e instância a classe "AdmsNewUser" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página de login.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {   
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->dataForm['SendNewUser'])){
            //var_dump($this->dataForm);
            unset($this->dataForm['SendNewUser']);
            $createNewUser = new \App\adms\Models\AdmsNewUser;
            $createNewUser->create($this->dataForm);
            if ($createNewUser->getResult()){
                $urlRedirect = URLADM;
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewUserAdd();
            }
        } else {
            $this->viewUserAdd();
        }
    }

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewUserAdd(): void
    {
        $loadView = new \Core\ConfigView("adms/Views/login/newUser", $this->data);
        $loadView->loadViewLogin();
    }
}