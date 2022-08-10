<?php

namespace App\adms\Models\helper;

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
            $_SESSION['msg'] = "<p style='color: red'>Erro: Necessário preencher todos os campos!</p>";
            $this->result = false;
        } else {
            $this->result = true;
        }
    }
}