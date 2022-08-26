<?php

namespace App\adms\Models;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

use App\adms\Models\helper\AdmsConn;
use PDO;

/**
 * Confirmar o cadastro do usuário, alterando a situação no banco de dados
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsConfEmail extends AdmsConn
{
    /** @var string $key Recebe a chave para confirmar o cadastro */
    private string $key;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    private array $dataSave;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * @return void
     */
    public function confEmail(string $key): void
    {
        $this->key = $key;
        
        if (!empty($this->key)){
            $viewKeyConfEmail = new \App\adms\Models\helper\AdmsRead();
            $viewKeyConfEmail->fullRead("SELECT id FROM adms_users WHERE conf_email =:conf_email LIMIT :limit", "conf_email={$this->key}&limit=1");
            $this->resultBd = $viewKeyConfEmail->getResult();

            if ($this->resultBd){
                $this->updateSitUsers();
            } else {
                $_SESSION['msg'] = "<p style='color: red;'>Erro: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'>Clique aqui</a>!</p>";
                $this->result = false;
            }   
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'>Clique aqui</a>!</p>";
            $this->result = false;
        }
    }

    private function updateSitUsers(): void
    {
        $this->dataSave['conf_email'] = null;
        $this->dataSave['adms_sits_user_id'] = 1;
        $this->dataSave['modified'] = date("Y-m-d H:i:s");

        $upConfEmail = new \App\adms\Models\helper\AdmsUpdate();
        $upConfEmail->exeUpdate("adms_users", $this->dataSave, "WHERE id=:id", "id={$this->resultBd[0]['id']}");

        if ($upConfEmail->getResult()){
            $_SESSION['msg'] = "<p style='color: green;'>E-mail ativado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: red;'>Erro: Necessário confirmar o e-mail, solicite novo link <a href='".URLADM."new-conf-email/index'>Clique aqui</a>!</p>";
            $this->result = false;
        }   
    }
}
