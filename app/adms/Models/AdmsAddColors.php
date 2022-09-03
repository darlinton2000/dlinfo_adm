<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar a cor no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsAddColors
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    private array $listRegistryAdd;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * Recebe os valores do formulário.
     * Instancia o helper "AdmsValEmptyField" para verificar se todos os campos estão preenchidos 
     * Verifica se todos os campos estão preenchidos e instancia o método "valColorUnique" para verificar se já existe a determinada cor no banco de dados
     * Retorna FALSE quando algum campo está vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function create(array $data = null)
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->valColorUnique();
        } else {
            $this->result = false;
        }
    }

    /**
     * Verificar se já existe a determinada cor (hexadecimal) cadastrarda no banco de dados.
     * Se exister algum registro irá apresentar uma mensagem de erro, se não irá instanciar o método 'add' responsável por cadastrar a cor no banco de dados.
     *
     * @return void
     */
    private function valColorUnique(): void
    {
        $color = $this->data['color'];
        $listColorUnique = new \App\adms\Models\helper\AdmsRead();
        $listColorUnique->fullRead("SELECT id, color FROM adms_colors WHERE color = '" . $color . "'");
        $this->resultBd = $listColorUnique->getResult();

        if ($this->resultBd) {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Cor já cadastrada!</p>";
            $this->result = false;
        } else {
            $this->add();
        }
    }

    /** 
     * Cadastrar a cor no banco de dados
     * Retorna TRUE quando cadastrar a cor com sucesso
     * Retorna FALSE quando não cadastrar a cor
     * 
     * @return void
     */
    private function add(): void
    {
        $this->data['created'] = date("Y-m-d H:i:s");

        $createSitUser = new \App\adms\Models\helper\AdmsCreate();
        $createSitUser->exeCreate("adms_colors", $this->data);

        if ($createSitUser->getResult()) {
            $_SESSION['msg'] = "<p style='color: green;'>Cor cadastrada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Cor não cadastrada com sucesso!</p>";
            $this->result = false;
        }
    }
}
