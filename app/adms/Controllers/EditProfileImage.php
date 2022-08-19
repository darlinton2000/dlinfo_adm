<?php

namespace App\adms\Controllers;

/**
 * Controller da página editar imagem do perfil
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class EditProfileImage
{   
    /** @var array|string|null $data Recebe os dados que devem ser enviados para a VIEW*/
    private array|string|null $data = [];

    /** @var array|null $dataForm Recebe os dados do formulário */
    private array|null $dataForm;

    /**
     * Instantiar a classe responsável em carregar a View e enviar os dados para View.
     * Quando o usuário clicar no botão "salvar" do formulário da página editar imagem, acessa o IF e instância a classe "AdmsEditProfileImage" responsável em editar a imagem de perfil.
     * Imagem editada com sucesso, redireciona para a página visualizar perfil.
     * 
     * @return void
     */
    public function index(): void
    {   
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendEditProfImage'])){
            $this->editProfileImage();
        } else {
            $viewProfImage = new \App\adms\Models\AdmsEditProfileImage();
            $viewProfImage->viewProfile();
            if ($viewProfImage->getResult()){
                $this->data['form'] = $viewProfImage->getResultBd();
                $this->viewEditProfImage();
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
    private function viewEditProfImage(): void
    {   
        $loadView = new \Core\ConfigView("adms/Views/users/editProfileImage", $this->data);
        $loadView->loadView();
    }

    private function editProfileImage(): void
    {
        if (!empty($this->dataForm['SendEditProfImage'])){
             unset($this->dataForm['SendEditProfImage']);
             $this->dataForm['new_image'] = $_FILES['new_image'] ? $_FILES['new_image'] : null;
             $editProfImg = new \App\adms\Models\AdmsEditProfileImage();
             $editProfImg->update($this->dataForm);
             if ($editProfImg->getResult()){
                $urlRedirect = URLADM . "view-profile/index";
                header("Location: $urlRedirect");
             } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditProfImage();
             }
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Perfil não encontrado!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}