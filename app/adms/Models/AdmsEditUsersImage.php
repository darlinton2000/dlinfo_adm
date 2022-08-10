<?php

namespace App\adms\Models;

/**
 * Editar a imagem do usuário do banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsEditUsersImage
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $dataImage Recebe os dados da imagem */
    private array|null $dataImage;

    /** @var string $directory Recebe o endereço de upload da imagem */
    private string $directory;

    /** @var string $delImg Recebe o endereço da imagem que deve ser excluída */
    private string $delImg;

    /** @var string $nameImg Recebe o slug/nome da imagem */
    private string $nameImg;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return array|null Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    public function viewUser(int $id): bool
    {
        $this->id = $id;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT id, image FROM adms_users WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            $this->result = true;
            return true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
            $this->result = false;
            return false;
        }
    }

    /** 
     * Recebe os valores do formulário.
     * Instancia o helper "AdmsValEmptyField" para verificar se todos os campos estão preenchidos 
     * Verifica se todos os campos estão preenchidos e instancia o método "valInput" para validar os dados dos campos
     * Retorna FALSE quando algum campo está vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function update(array $data = null): void
    {
        $this->data = $data;

        $this->dataImage = $this->data['new_image'];
        unset($this->data['new_image']);

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            if (!empty($this->dataImage['name'])) {
                //$this->result = false;
                $this->valInput();
            } else {
                $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Necessário selecionar uma imagem!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /** 
     * Verificar se existe o usuário com o ID recebido
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function valInput(): void
    {   
        $valExtImg = new \App\adms\Models\helper\AdmsValExtImage();
        $valExtImg->validatExtImg($this->dataImage['type']);

        if (($this->viewUser($this->data['id'])) and ($valExtImg->getResult())){
            $this->result = false;
            $this->upload();
        } else {
            $this->result = false;
        }
        
    }

    /**
     * Instancia a classe 'AdmsSlug' responsável por converter/otimizar o nome da imagem
     * Instancia a classe 'AdmsUpload' responsável por fazer o upload da imagem
     * Instancia o método "edit"
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function upload(): void
    {
        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->nameImg = $slugImg->slug($this->dataImage['name']);

        $this->directory = "app/adms/assets/image/users/" . $this->data['id'] . "/";

        /* $uploadImg = new \App\adms\Models\helper\AdmsUpload();
        $uploadImg->upload($this->directory, $this->dataImage['tmp_name'], $this->nameImg); */

        $uploadImgRes = new \App\adms\Models\helper\AdmsUploadImgRes();
        $uploadImgRes->upload($this->dataImage, $this->directory, $this->nameImg, 300, 300);

        if ($uploadImgRes->getResult()){
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Salva o nome da imagem no banco de dados
     * Retorna TRUE quando salvar a imgem com sucesso
     * Retorna FALSE quando não salvar a imagem
     * 
     * @return void
     */    
    private function edit(): void
    {
        $this->data['image'] = $this->nameImg;
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upUser = new \App\adms\Models\helper\AdmsUpdate();
        $upUser->exeUpdate("adms_users", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upUser->getResult()) {
            $this->deleteImage();
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Usuário não editado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Se existir alguma imagem dentro do determinado diretório, ele irá excluí-la
     *
     * @return void
     */
    private function deleteImage(): void
    {
        if (((!empty($this->resultBd[0]['image'])) or ($this->resultBd[0]['image'] != null)) and ($this->resultBd[0]['image'] != $this->nameImg)) {
            $this->delImg = "app/adms/assets/image/users/" . $this->data['id'] . "/" . $this->resultBd[0]['image'];
            if (file_exists($this->delImg)) {
                unlink($this->delImg);
            }
        }

        $_SESSION['msg'] = "<p style='color: green;'>Imagem editada com sucesso!</p>";
        $this->result = true;
    }
}
