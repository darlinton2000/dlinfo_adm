<?php

namespace App\adms\Models\helper;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

use PDO;
use PDOException;

/**
 * Conexão com o banco de dados
 * 
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
abstract class AdmsConn
{
    /** @var string $host Recebe o host da constante HOST */
    private string $host = HOST;
    /** @var string $user Recebe o usuário da constante USER */
    private string $user = USER;
    /** @var string $pass Recebe a senha da constante PASS */
    private string $pass = PASS;
    /** @var string $dbname Recebe a base de dados da constante DBNAME */
    private string $dbname = DBNAME;
    /** @var integer|string $port Recebe a porta da constante PORT */
    private int|string $port = PORT;
    /** @var object $connect Recebe a conexão com o bando de dados */
    private object $connect;

    /**
     * Realiza a conexão com o banco de dados.
     * Não realizando a conexão corretamente, ele para o processamento da página a apresenta a mensagem de erro, com o e-mail de contato do administrador
     * @return object retorna a conexão com o banco de dados
     */
    protected function connectDb(): object
    {
        try {
            //Conexão com a porta
            //$this->connect = new PDO("mysql: host={$this->host};port={$this->port};dbname=" . $this->dbname, $this->user, $this->pass);

            //Conexão sem a porta
            $this->connect = new PDO("mysql: host={$this->host};dbname=" . $this->dbname, $this->user, $this->pass);

            return $this->connect;
        } catch (PDOException $err){
            die("Erro - 001: Por favor tente novamente. Caso o problema persista, entre em contato com o administrador " . EMAILADM);
        }
    }
}