<?php

namespace App\adms\Models\helper;

if (!defined('C8L6K7E')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Classe genérica de paginação
 *
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsPagination
{
    private int $page;
    private int $limitResult;
    private int $offset;
    private string $query;
    private string|null $parseString;
    private array $resultBd;
    private string|null $result;
    private int $totalPages;
    private int $maxLinks = 2;
    private string $link;
    private string|null $var;

    function getOffset(): int
    {
        return $this->offset;
    }

    function getResult(): string|null
    {
        return $this->result;
    }

    function __construct(string $link, string|null $var = null)
    {
        $this->link = $link;
        $this->var = $var;
    }

    public function condition(int $page, int $limitResult): void
    {
        $this->page = (int) $page ? $page : 1;
        $this->limitResult = (int) $limitResult;
        $this->offset = (int) ($this->page * $this->limitResult) - $this->limitResult;
    }

    public function pagination(string $query, string|null $parseString = null): void
    {
        $this->query = (string) $query;
        $this->parseString = (string) $parseString;
        $count = new \App\adms\Models\helper\AdmsRead();
        $count->fullRead($this->query, $this->parseString);
        $this->resultBd = $count->getResult();
        $this->pageInstruction();
    }

    private function pageInstruction(): void
    {
        /* $this->totalPages = (int) ceil($this->resultBd[0]['num_result'] / $this->limitResult);
        if ($this->totalPages >= $this->page){
            $_SESSION['total_registro'] = $this->resultBd[0]['num_result'];
            $this->layoutPagination();
        } else {
            header("Location: {$this->link}");
        } */

        if (!$this->resultBd[0]['num_result'] == 0) {
            $this->totalPages = (int) ceil($this->resultBd[0]['num_result'] / $this->limitResult);
            if ($this->totalPages >= $this->page) {
                $this->layoutPagination();
            } else {
                header("Location: {$this->link}");
            }
        } else {
            $this->result = 0;
        }
    }

    private function layoutPagination(): void
    {
        $this->result = "<ul>";

        $this->result .= "<li><a href='{$this->link}{$this->var}'>Primeira</a></li>";

        for ($beforePage = $this->page - $this->maxLinks; $beforePage <= $this->page - 1; $beforePage++) {
            if ($beforePage >= 1) {
                $this->result .= "<li><a href='{$this->link}/$beforePage{$this->var}'>$beforePage</a></li>";
            }
        }

        $this->result .= "<li>{$this->page}</li>";

        for ($afterPage = $this->page + 1; $afterPage <= $this->page + $this->maxLinks; $afterPage++) {
            if ($afterPage <= $this->totalPages) {
                $this->result .= "<li><a href='{$this->link}/$afterPage{$this->var}'>$afterPage</a></li>";
            }
        }

        $this->result .= "<li><a href='{$this->link}/{$this->totalPages}{$this->var}'>Última</a></li>";

        $this->result .= "</ul>";
    }
}
