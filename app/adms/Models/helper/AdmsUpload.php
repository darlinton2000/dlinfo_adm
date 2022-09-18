<?php

namespace App\adms\Models\helper;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Classe genérica para upload
 * 
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsUpload
{   
    /** @var string $directory Recebe o diretório do arquivo */
    private string $directory;

    /** @var string $tmpName Recebe o nome temporário do arquivo */
    private string $tmpName;

    /** @var string $name Recebe o nome do arquivo */
    private string $name;

    /** @var boolean $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /**
     * @return boolean Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Recebe as informações do arquivo.
     * Instancia o método 'valDirectory' responsável por validar o diretório.
     * Instancia o método 'uploadFile' responsável por fazer o upload do arquivo no servidor.
     *
     * @param string $directory
     * @param string $tmpName
     * @param string $name
     * @return void
     */
    public function upload(string $directory, string $tmpName, string $name): void
    {
        $this->directory = $directory;
        $this->tmpName = $tmpName;
        $this->name = $name;

        if ($this->valDirectory()){
            $this->uploadFile();
        } else {
            $this->result = false;
        }
    }

    /**
     * Irá validar o diretório do arquivo
     *
     * @return boolean
     */
    private function valDirectory(): bool
    {
        if ((!file_exists($this->directory)) and (!is_dir($this->directory))) {
            mkdir($this->directory, 0755);
            if ((!file_exists($this->directory)) and (!is_dir($this->directory))) {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Upload não realizado com sucesso. Tente novamente!</p>";
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     * Responsável por fazer o upload do arquivo no servidor
     *
     * @return void
     */
    private function uploadFile(): void
    {
        if (move_uploaded_file($this->tmpName, $this->directory .  $this->name)) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Upload não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        }
    }
}