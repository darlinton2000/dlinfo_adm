<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Validar os dados do login
 * 
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsLogin
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;
    
    /** @var boolean $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /**
     * @return void Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult()
    {
        return $this->result;
    }

    /**
     * Recebe os valores do formulário.
     * Recupera as informações do usuário no banco de dados
     * Quando encontrar o usuário no banco de dados instanciar o método "valPassword" para validar a senha
     * Retorna FALSE quando não encontrar o usuário no banco de dados
     *
     * @param array|null $data Recebe as informações do formulário
     * @return void
     */
    public function login(array $data = null)
    {
        $this->data = $data;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT id, name, nickname, email, password, image, adms_sits_user_id FROM adms_users WHERE user =:user OR email =:email LIMIT :limit", "user={$this->data['user']}&email={$this->data['user']}&limit=1");

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd){
                $this->valEmailPerm();
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Usuário ou a senha incorreta!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo valida a situação do usuário
     * Se a situação for 1, chama chama a função valPassword para validar a senha
     * Se a situação for 3, retorna falso, pois, o usuario precisar confirmar o e-mail.
     * Se a situação for 5, retorna falso, pois, o e-mail do usuário foi descadastrado.
     * Se a situação for 2, retorna falso, pois, o e-mail esta inativo
     * @return void
     */
    private function valEmailPerm(): void
    {   
        if($this->resultBd[0]['adms_sits_user_id'] == 1){
            $this->valPassword();
        } else if ($this->resultBd[0]['adms_sits_user_id'] == 3){
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'>Clique aqui</a>!</p>";
            $this->result = false;
        } else if ($this->resultBd[0]['adms_sits_user_id'] == 5){
            $_SESSION['msg'] = "<p style='color: red;'>Erro: E-mail descadastrado, entre em contato com a empresa!</p>";
            $this->result = false;
        } else if ($this->resultBd[0]['adms_sits_user_id'] == 2){
            $_SESSION['msg'] = "<p style='color: red;'>Erro: E-mail inativo, entre em contato com a empresa!</p>";
            $this->result = false;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: E-mail inativo, entre em contato com a empresa!</p>";
            $this->result = false;  
        }
    }

    /** 
     * Compara a senha enviado pelo usuário com a senha que está salva no banco de dados
     * Retorna TRUE quando os dados estão corretos e salva as informações do usuário na sessão
     * Retorna FALSE quando a senha está incorreta
     * 
     * @return void
     */
    private function valPassword()
    {
        if (password_verify($this->data['password'], $this->resultBd[0]['password'])){
            $_SESSION['user_id'] = $this->resultBd[0]['id'];
            $_SESSION['user_name'] = $this->resultBd[0]['name'];
            $_SESSION['user_nickname'] = $this->resultBd[0]['nickname'];
            $_SESSION['user_email'] = $this->resultBd[0]['email'];
            $_SESSION['user_image'] = $this->resultBd[0]['image'];
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Usuário ou a senha incorreta!!</p>";
            $this->result = false;
        }
    }
}