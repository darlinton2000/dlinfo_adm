<?php

namespace Core;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Carregar as páginas da View
 * 
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class ConfigView
{   
    /**
     * Recebe o endereço da VIEW e os dados.
     * @param string $nameView Endereço da VIEW que deve ser carregada.
     * @param array|string|null $data Dados que a VIEW deve receber.
     */
    public function __construct(private string $nameView, private array|string|null $data)
    {
    }

    /**
     * Carregar a VIEW
     * Verifica se o arquivo existe, e carrega caso exista, não existindo apresenta a mensagem de erro
     * Carrega o menu
     * 
     * @return void
     */
    public function loadView(): void
    {
        if (file_exists('app/' . $this->nameView . '.php')){
            include 'app/adms/Views/include/head.php';
            include 'app/adms/Views/include/menu.php';
            include 'app/' . $this->nameView . '.php';
            include 'app/adms/Views/include/footer.php';
        } else {
            die("Erro - 002: Por favor tente novamente. Caso o problema persista, entre em contato com o administrador " . EMAILADM);
        }
    }

    /**
     * Carregar a VIEW login
     * Verifica se o arquivo existe, e carrega caso exista, não existindo apresenta a mensagem de erro
     * Não carrega o menu
     * 
     * @return void
     */
    public function loadViewLogin(): void
    {
        if (file_exists('app/' . $this->nameView . '.php')){
            include 'app/adms/Views/include/head.php';
            include 'app/' . $this->nameView . '.php';
            include 'app/adms/Views/include/footer.php';
        } else {
            die("Erro - 005: Por favor tente novamente. Caso o problema persista, entre em contato com o administrador " . EMAILADM);
        }
    }
}