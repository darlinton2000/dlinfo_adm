<?php

namespace Core;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

abstract class Config
{   
    /**
     * Possui as constantes com as configurações.
     * Configurações de endereço do projeto.
     * Página principal do projeto.
     * Credênciais de acesso ao banco de dados.
     * E-mail do administrador.
     *
     * @return void
     */
    protected function configAdm()
    {
        define('URL', 'http://localhost/celke/');
        define('URLADM', 'http://localhost/adm/');

        define('CONTROLLER', 'Login');
        define('METODO', 'index');
        define('CONTROLLERERRO', 'Login');
        
        define('HOST', 'localhost');
        define('USER', 'root');
        define('PASS', '');
        define('DBNAME', 'adm');
        define('PORT', 3306);

        define('EMAILADM', 'darlinton2000@gmail.com');
    }
}