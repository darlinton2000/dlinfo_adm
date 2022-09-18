<?php

namespace App\adms\Models\helper;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Classe genérica para redimensionar a imagem
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsUploadImgRes
{   
   /** @var array $imageData */
   private array $imageData;

   /** @var string $directory Recebe o diretório da imagem */
   private string $directory;

   /** @var string $name Recebe o nome da imagem */
   private string $name;

   /** @var int $width Recebe a largura da imagem */
   private $width;

   /** @var int $height Recebe a altura da imagem */
   private $height;

   /** @var [type] $newImage */
   private $newImage;

   /** @var boolean $result Recebe true quando executar o processo com sucesso e false quando houver erro */
   private bool $result;

   /** @var [type] Recebe o tamanho da imagem */
   private $imgResize;

    /**
    * @return boolean Retorna true quando executar o processo com sucesso e false quando houver erro
    */
    function getResult(): bool
    {
            return $this->result;
    }

    public function upload(array $imageData, string $directory, string $name, int $width, int $height): void
    {
        $this->imageData = $imageData;
        $this->directory = $directory;
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;

        var_dump($this->imageData);

        $this->valDirectory();
    }

    /**
    * Irá validar o diretório da imagem, se não existir ele irá instanciar o método 'createDir'
    * @return void 
    */
    private function valDirectory(): void
    {
        if ((file_exists($this->directory)) and (!is_dir($this->directory))) {
            $this->createDir();
        } elseif (!file_exists($this->directory)) {
            $this->createDir();
        } else {
            $this->uploadFile();
        }
    }

    /**
    * Cria o diretório da imagem.
    * Retorna FALSE se não conseguir criar o diretório e exibe uma mensagem de erro.
    * @return void 
    */
    private function createDir(): void
    {
        mkdir($this->directory, 0755);
        if (!file_exists($this->directory)) {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Upload da imagem não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        } else {
            $this->uploadFile();
        }
    }

    private function uploadFile(): void
    {
        switch ($this->imageData['type']) {
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->uploadFileJpeg();
                break;
            case 'image/png':
            case 'image/x-png':
                $this->uploadFilePng();
                break;
            default:
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar imagem JPEG ou PNG!</p>";
                $this->result = false;
        }
    }

    private function uploadFileJpeg(): void
    {
        $this->newImage = imagecreatefromjpeg($this->imageData['tmp_name']);

        $this->redImg();

        // Enviar a imagem para servidor
        if (imagejpeg($this->imgResize, $this->directory . $this->name, 100)) {
            $_SESSION['msg'] = "<p class='alert-success'>Upload da imagem realizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Upload da imagem não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        }
    }

    private function uploadFilePng(): void
    {
        $this->newImage = imagecreatefrompng($this->imageData['tmp_name']);

        $this->redImg();

        // Enviar a imagem para servidor
        if (imagepng($this->imgResize, $this->directory . $this->name, 1)) {
            $_SESSION['msg'] = "<p class='alert-success'>Upload da imagem realizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Upload da imagem não realizado com sucesso. Tente novamente!</p>";
            $this->result = false;
        }
    }

    private function redImg(): void
    {
        // Obter a largura da image
        $width_original = imagesx($this->newImage);

        // Obter a altura da image
        $height_original = imagesy($this->newImage);

        // Criar uma imagem modelo com as dimensões definidas para nova imagem
        $this->imgResize = imagecreatetruecolor($this->width, $this->height);

        // Copiar e redimensionar parte da imagem enviada pelo usuário e interpola com a imagem tamanho modelo
        imagecopyresampled($this->imgResize, $this->newImage, 0, 0, 0, 0, $this->width, $this->height, $width_original, $height_original);
    }
}