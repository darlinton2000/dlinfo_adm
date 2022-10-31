<?php

namespace Core;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Verifica se existe a classe
 * Carrega a CONTROLLER
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class CarregarPgAdmLevel
{
    /** @var string $urlController Recebe da URL o nome da controller */
    private string $urlController;

    /** @var string $urlMetodo Recebe da URL o nome do método */
    private string $urlMetodo;

    /** @var string $urlParameter Recebe da URL o parâmetro */
    private string $urlParameter;

    /** @var string $classLoad Controller que deve ser carregada */
    private string $classLoad;

    /** @var array|null $resultPage Recebe os dados da pagina do banco de dados */
    private array|null $resultPage;

    /** @var array|null $resultLevelPage Recebe os dados da permissao do banco de dados */
    private array|null $resultLevelPage;


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

        $this->searchPage();
    }

    /**
     * Verificando se existe a pagina no BD
     * @return void
     */
    private function searchPage(): void
    {
        $searchPage = new \App\adms\Models\helper\AdmsRead();
        $searchPage->fullRead("SELECT pag.id, pag.publish, 
                                typ.type
                                FROM adms_pages AS pag
                                INNER JOIN adms_types_pgs AS typ ON typ.id = pag.adms_types_pgs_id
                                WHERE pag.controller =:controller 
                                AND pag.metodo =:metodo
                                LIMIT :limit", "controller={$this->urlController}&metodo={$this->urlMetodo}&limit=1");
        $this->resultPage = $searchPage->getResult(); 

        if ($this->resultPage){
            if ($this->resultPage[0]['publish'] == 1){
                $this->classLoad = "\\App\\" . $this->resultPage[0]['type'] . "\\Controllers\\" . $this->urlController;
                $this->loadMetodo();
            } else {
                $this->verifyLogin();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Página não encontrada!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
            /* die("Erro - 006: Por favor tente novamente. Caso o problema persista, entre em contato com o administrador " . EMAILADM); */
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
           die("Erro - 007: Por favor tente novamente. Caso o problema persista, entre em contato com o administrador " . EMAILADM);

        }
    }

    /**
     * Verificar se o usuário está logado e carregar a página
     *
     * @return void
     */
    private function verifyLogin(): void
    {
        if ((isset($_SESSION['user_id'])) and (isset($_SESSION['user_name'])) and (isset($_SESSION['user_email'])) and ($_SESSION['adms_access_level_id']) and ($_SESSION['order_levels'])){
            //$this->classLoad = "\\App\\adms\\Controllers\\" . $this->urlController;
            $this->searchLevelPage();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Para acessar a página realize o login!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }

    private function searchLevelPage(): void 
    {
        $searchLevelPage = new \App\adms\Models\helper\AdmsRead();
        $searchLevelPage->fullRead("SELECT id, permission FROM adms_levels_pages 
                                        WHERE adms_page_id =:adms_page_id 
                                        AND adms_access_level_id =:adms_access_level_id
                                        AND permission =:permission
                                        LIMIT :limit", "adms_page_id={$this->resultPage[0]['id']}&adms_access_level_id=" . $_SESSION['adms_access_level_id'] . "&permission=1&limit=1");
        $this->resultLevelPage = $searchLevelPage->getResult();
        if ($this->resultLevelPage){
            $this->classLoad = "\\App\\" . $this->resultPage[0]['type'] . "\\Controllers\\" . $this->urlController;
            $this->loadMetodo();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário permissão para acessar a página!</p>";
            $urlRedirect = URLADM . "login/index";
            header("Location: $urlRedirect");
        }
    }
}