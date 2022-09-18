<?php

namespace App\adms\Models\helper;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Classe genêrica para validar os campos
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsValEmptyField
{
    private array|null $data;
    private bool $result;

    function getResult()
    {
        return $this->result;
    }

    /**
     * Função para verificar se existe algum campo vazio
     * @param array|null $data
     * @return void
     */
    public function valField(array $data = null)
    {
        $this->data = $data;
        $this->data = array_map('strip_tags', $this->data);
        $this->data = array_map('trim', $this->data);

        if (in_array('', $this->data)){
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário preencher todos os campos!</p>";
            $this->result = false;
        } else {
            $this->result = true;
        }
    }
}