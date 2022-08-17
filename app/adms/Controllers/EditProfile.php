<?php

namespace App\adms\Controllers;

/**
 * Controller da página editar perfil
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditProfile
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data = [];

    /** @var array|null $dataForm Recebe os dados do formulário */
    private array|null $dataForm;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo usuário. Acessa o IF e instância a classe "AdmsAddUsers" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {   
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendEditProfile'])){
            $this->editProfile();
        } else {
            $viewProfile = new \App\adms\Models\AdmsEditProfile();
            $viewProfile->viewProfile();
            if ($viewProfile->getResult()){
                $this->data['form'] = $viewProfile->getResultBd();
                $this->viewEditProfile();
            } else {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            }
        }
    }       

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditProfile(): void
    {   
        $loadView = new \Core\ConfigView("adms/Views/users/editProfile", $this->data);
        $loadView->loadView();
    }

    private function editProfile(): void
    {
        if (!empty($this->dataForm['SendEditProfile'])){
             unset($this->dataForm['SendEditProfile']);
             $editProfile = new \App\adms\Models\AdmsEditProfile();
             $editProfile->update($this->dataForm);
             if ($editProfile->getResult()){
                $urlRedirect = URLADM . "view-profile/index";
                header("Location: $urlRedirect");
             } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditProfile();
             }
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Perfil não encontrado!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}