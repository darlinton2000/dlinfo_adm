<?php

namespace Core;

/**
 * Verifica se existe a classe
 * Carrega a CONTROLLER
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class CarregarPgAdm
{
    /** @var string $urlController Recebe da URL o nome da controller */
    private string $urlController;
    /** @var string $urlMetodo Recebe da URL o nome do método */
    private string $urlMetodo;
    /** @var string $urlParameter Recebe da URL o parâmetro */
    private string $urlParameter;
    /** @var string $classLoad Controller que deve ser carregada */
    private string $classLoad;
    /** @var array $pgPublic Recebe o nome das páginas que são públicas */
    private array $listPgPublic;
    /** @var array $listPgPrivate Recebe o nome das páginas que são privadas */
    private array $listPgPrivate;

    /**
     * Verificar se existe a classe
     * @param string $urlController Recebe da URL o nome da controller
     * @param string $urlMetodo Recebe da URL o método
     * @param string $urlParamentro Recebe da URL o parâmetro
     */
    public function loadPage(string|null $urlController, string|null $urlMetodo, string|null $urlParameter): void
    {
        $this->urlController = $urlController;
        $this->urlMetodo = $urlMetodo;
        $this->urlParameter = $urlParameter;

        $this->pgPublic();

        if (class_exists($this->classLoad)){
            $this->loadMetodo();
        } else {
            die("Erro - 003: Por favor tente novamente. Caso o problema persista, entre em contato com o administrador " . EMAILADM);
        }
    }

    /**
     * Verificar se existe o método e carregar a página
     *
     * @return void
     */
    private function loadMetodo(): void
    {
        $classLoad = new $this->classLoad();
        if (method_exists($classLoad, $this->urlMetodo)){
            $classLoad->{$this->urlMetodo}($this->urlParameter);
        } else {
           die("Erro - 004: Por favor tente novamente. Caso o problema persista, entre em contato com o administrador " . EMAILADM);

        }
    }

    /**
     * Verificar se a página é pública e carregar a mesma
     *
     * @return void
     */
    private function pgPublic(): void
    {
        $this->listPgPublic = ["Login", "Erro", "Logout", "NewUser", "ConfEmail", "NewConfEmail", "RecoverPassword", "UpdatePassword"];

        if (in_array($this->urlController, $this->listPgPublic)){
            $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
        } else {
            $this->pgPrivate();
        }
    }

    /**
     * Verificar se a página é privada e chamar o método para verificar se o usuário está logado
     *
     * @return void
     */
    private function pgPrivate(): void
    {
        $this->listPgPrivate = ["Dashboard", "ListUsers", "ViewUsers", "AddUsers", "EditUsers", "EditUsersPassword", "EditUsersImage", "DeleteUsers"];

        if (in_array($this->urlController, $this->listPgPrivate)){
            $this->verifyLogin();
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Página não encontrada!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Verificar se o usuário está logado e carregar a página
     *
     * @return void
     */
    private function verifyLogin(): void
    {
        if ((isset($_SESSION['user_id'])) and (isset($_SESSION['user_name'])) and (isset($_SESSION['user_email']))){
            $this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Para acessar a página realize o login!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Connverter o valor obtido da URL Ex: "view-users" e converter no formato da classe Ex: "ViewUsers".
     * Utilizado as funções para converter tudo para minúsculo, converter o traço pelo espaço, converter cada letra da primeira palavra para maiúsculo, retirar os espaços em branco
     *
     * @param string $slugController Nome da classe
     * @return string Retorna a controller Ex: "view-users" convertido para o nome da classe Ex: "ViewUsers"
     */
    public function slugController(string $slugController): string
    {
        $this->urlSlugController = $slugController;
        //Converter para minusculo
        $this->urlSlugController = strtolower($this->urlSlugController);
        //Converter o traco para espaco em branco
        $this->urlSlugController = str_replace("-", " ", $this->urlSlugController);
        //Converter a primeira letra de cada palavra para maiusculo
        $this->urlSlugController = ucwords($this->urlSlugController);
        //Retirar espaço em branco
        $this->urlSlugController = str_replace(" ", "", $this->urlSlugController);

        return $this->urlSlugController;
    }

    /**
     * Tratar o método
     * Instanciar o método que trata a controller
     * Converter a primeira letra para minúsculo
     *
     * @param string $urlSlugMetodo
     * @return string
     */
    public function slugMetodo(string $urlSlugMetodo): string
    {
        $this->urlSlugMetodo = $this->slugController($urlSlugMetodo);
        //Converter para minusculo a primeira letra
        $this->urlSlugMetodo = lcfirst($this->urlSlugMetodo);
        return $this->urlSlugMetodo;
    }
}