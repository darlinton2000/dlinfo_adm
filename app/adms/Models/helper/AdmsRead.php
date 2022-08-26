<?php

namespace App\adms\Models\helper;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

use PDO;
use PDOException;

/**
 * Classe genérica para selecionar registro no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsRead extends AdmsConn
{   
   private string $select;
   private array $values = [];
   private array|null $result;
   private object $query;
   private object $conn;

   function getResult(): array|null
   {
        return $this->result;
   }
   
   public function exeRead(string $table, string|null $terms = null, string|null $parseString = null): void
   {
        if (!empty($parseString)){
            parse_str($parseString, $this->values);
        }

        $this->select = "SELECT * FROM {$table} {$terms}";
        $this->exeInstruction();
   }

   public function fullRead(string $query, string|null $parseString = null): void
   {
        $this->select = $query;
        if (!empty($parseString)){
            parse_str($parseString, $this->values);
        }
        $this->exeInstruction();
   }

   private function exeInstruction(): void
   {
        $this->connection();
        try {
            $this->exeParameter();
            $this->query->execute();
            $this->result = $this->query->fetchAll();
        } catch (PDOException $err){
            $this->result = null;
        }
   }

   private function connection(): void
   {
        $this->conn = $this->connectDb();
        $this->query = $this->conn->prepare($this->select);
        $this->query->setFetchMode(PDO::FETCH_ASSOC);
   }

   private function exeParameter(): void
   {
        if ($this->values){
            foreach ($this->values as $link => $value){
                if (($link == 'limit') or ($link == 'offset') or ($link == 'id')){
                    $value = (int) $value;
                }
                $this->query->bindValue(":{$link}", $value, (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR));
            }
        }
   } 
}