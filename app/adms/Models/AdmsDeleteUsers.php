<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar o usuário do banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsDeleteUsers
{
    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var string $delDirectory Recebe o endereço para apagar o diretório */
    private string $delDirectory;

    /** @var string $delImg Recebe o endereço para apagar a imagem */
    private string $delImg;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Responsável por excluir um determinado usuário no banco de dados.
     * Se existir algum diretório ou imagem do usuário irá ser excluído quando instanciar o método 'deleteImg'
     * Retorna TRUE se conseguir excluir.
     * Retorna FALSE se não conseguir excluir.
     * 
     * @param integer $id
     * @return void
     */
    public function deleteUser(int $id): void
    {
        $this->id = (int) $id;

        if ($this->viewUser()){
            $deleteUser = new \App\adms\Models\helper\AdmsDelete();
            $deleteUser->exeDelete("adms_users", "WHERE id=:id", "id={$this->id}");

            if ($deleteUser->getResult()){
                $this->deleteImg();
                $_SESSION['msg'] = "<p class='alert-success'>Usuário apagado com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não apagado com sucesso!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /**
     * Retorna as informações do usuário como o id e a imagem.
     *
     * @return boolean
     */
    private function viewUser(): bool
    {
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT id, image FROM adms_users WHERE id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd){
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário não encontrado!</p>";
            return false;
        }   
    }

    /**
     * Responsável por excluir a imagem se existir e posteriormente o diretório
     *
     * @return void
     */
    private function deleteImg(): void
    {
        if ((!empty($this->resultBd[0]['image'])) or ($this->resultBd[0]['image'] != null)){
            $this->delDirectory = "app/adms/assets/image/users/" . $this->resultBd[0]['id'];
            $this->delImg = $this->delDirectory . "/" . $this->resultBd[0]['image'];

            if (file_exists($this->delImg)){
                unlink($this->delImg);
            }

            if (file_exists($this->delDirectory)){
                rmdir($this->delDirectory);
            }
        }
    }
}
