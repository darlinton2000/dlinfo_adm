<?php

//Iniciando a sessão no projeto
session_start();

//Limpar o buffer de saída
ob_start();

//Constante de segurança dos diretórios do código fonte 
define('C8L6K7E', true);

//Carrega o Composer
require './vendor/autoload.php';

//Instanciar a classe ConfigController, responsável em tratar a URL
$home = new Core\ConfigController();

//Instaciar o método para carregar a página/controller
$home->loadPage();


