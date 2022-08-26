<?php

namespace App\adms\Models\helper;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

use PDO;
use PDOException;

/**
 * Classe genérica para apagar registro no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsDelete extends AdmsConn
{   
    /** @var string $table Recebe o nome da tabela */
    private string $table;

    /** @var string|null $terms */
    private string|null $terms;

    /** @var array $value */
    private array $value = [];

    /** @var string|null $result Retorna o status do cadastro */
    private string|null|bool $result;

    /** @var object $insert Recebe a QUERY preparada */
    private object $delete;

    /** @var string $query Recebe a QUERY */
    private string $query;

    /** @var object $conn Recebe a conexão com o BD */
    private object $conn;

    /**
     * Retornar o status do registro
     * @return string|null
     */
    function getResult(): string|null|bool
    {
        return $this->result;
    }

    /**
     * Deleta no banco de dados
     * 
     * @param string $table Recebe o nome da tabela
     * @param string|null $terms 
     * @param string|null $parseString 
     * @return void
     */
    public function exeDelete(string $table, string|null $terms = null, string|null $parseString = null): void
    {
        $this->table = $table;
        $this->terms = $terms;

        parse_str($parseString, $this->value);

        $this->query = "DELETE FROM {$this->table} {$this->terms}";

        $this->exeInstruction();
    }

    /**
     * Executa a QUERY. 
     * Quando executa a query com sucesso retorna TRUE, senão retorna FALSE.
     * 
     * @return void
     */
    private function exeInstruction(): void
    {
        $this->connection();
        try {
            $this->delete->execute($this->value);
            $this->result = true;
        } catch (PDOException $err){
            $this->result = false;
        }
    }

    /**
     * Obtem a conexão com o banco de dados da classe pai "Conn".
     * Prepara uma instrução para execução e retorna um objeto de instrução.
     * 
     * @return void
     */
    private function connection(): void
    {
        $this->conn = $this->connectDb();
        $this->delete = $this->conn->prepare($this->query);
    }
}