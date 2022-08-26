<?php

namespace Core;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Recebe a URL e manipula
 * Carrega a CONTROLLER
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 * 
 * https://www.php-fig.org/psr/
 * https://github.com/php-fig/fig-standards/blob/master/proposed/phpdoc.md
 * https://github.com/php-fig/fig-standards/blob/master/proposed/phpdoc-tags.md
 */
class ConfigController extends Config
{
    /** @var string $url Recebe a URL do .htaccess */
    private string $url;
    /** @var array $urlArray Recebe a URL convertida para array */
    private array $urlArray;
    /** @var string $urlController Recebe da URL o nome da controller*/
    private string $urlController;
    /** @var string $urlMetodo Recebe da URL o nome do método */
    private string $urlMetodo;
    /** @var string $urlParameter Recebe da URL o parâmetro */
    private string $urlParameter;
    /** @var string $classLoad Controller que deve ser carregada */
    private string $classLoad;
    /** @var array $format Recebe o array de caracteres especiais que devem ser substituido */
    private array $format;
    /** @var string $urlSlugController Recebe o controller tratada */
    private string $urlSlugController;
    /** @var string $urlSlugMetodo Recebe o metodo tratado */
    private string $urlSlugMetodo;

    /**
     * Recebe a URL do .htaccess
     * Valida a URL
     */
    public function __construct()
    {
        $this->configAdm();

        if (!empty(filter_input(INPUT_GET, 'url', FILTER_DEFAULT))){
            $this->url = filter_input(INPUT_GET, 'url', FILTER_DEFAULT);
            $this->clearUrl();
            $this->urlArray = explode("/", $this->url);

            if (isset($this->urlArray[0])){
                $this->urlController = $this->slugController($this->urlArray[0]);
            } else {
                $this->urlController = $this->slugController(CONTROLLER);
            }

            if (isset($this->urlArray[1])){
                $this->urlMetodo = $this->slugMetodo($this->urlArray[1]);
            } else {
                $this->urlMetodo = $this->slugMetodo(METODO);
            }

            if (isset($this->urlArray[2])){
                $this->urlParameter = $this->urlArray[2];
            } else {
                $this->urlParameter = "";
            }
        } else {
            $this->urlController = $this->slugController(CONTROLLERERRO);
            $this->urlMetodo =  $this->slugMetodo(METODO);
            $this->urlParameter = "";
        }
    }

    /**
     * Método privado não pode ser instanciado fora da classe
     * Limpara a URL, elimando as TAG, os espaços em brancos, retirar a barra no final da URL e retirar os caracteres especiais
     *
     * @return void
     */
    private function clearUrl(): void
    {
        //Eliminar as tags
        $this->url = strip_tags($this->url);
        //Eliminar espaços em branco
        $this->url = trim($this->url);
        //Eliminar a barra no final da URL
        $this->url = rtrim($this->url, "/");
        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-------------------------------------------------------------------------------------------------';
        $this->url = strtr(utf8_decode($this->url), utf8_decode($this->format['a']), $this->format['b']);
    }

    /**
     * Connverter o valor obtido da URL Ex: "view-users" e converter no formato da classe Ex: "ViewUsers".
     * Utilizado as funções para converter tudo para minúsculo, converter o traço pelo espaço, converter cada letra da primeira palavra para maiúsculo, retirar os espaços em branco
     *
     * @param string $slugController Nome da classe
     * @return string Retorna a controller Ex: "view-users" convertido para o nome da classe Ex: "ViewUsers"
     */
    private function slugController(string $slugController): string
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
    private function slugMetodo(string $urlSlugMetodo): string
    {
        $this->urlSlugMetodo = $this->slugController($urlSlugMetodo);
        //Converter para minusculo a primeira letra
        $this->urlSlugMetodo = lcfirst($this->urlSlugMetodo);
        return $this->urlSlugMetodo;
    }

    /**
     * Carregar as Controllers
     * Instanciar as classes da controller e carregar o método
     *
     * @return void
     */
    public function loadPage(): void
    {
        $loadPgAdm = new \Core\CarregarPgAdm();
        $loadPgAdm->loadPage($this->urlController, $this->urlMetodo, $this->urlParameter);
    }
}