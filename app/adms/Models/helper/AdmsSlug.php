<?php

namespace App\adms\Models\helper;

if (!defined('C8L6K7E')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Classe genérica para converter o SLUG
 * 
 * @author Darlinton Luis Siqueira <darlinton2000@gmail.com>
 */
class AdmsSlug
{
    /** @var string $text Recebe o texto que deve ser convertido para o SLUG */
    private string $text;

    /** @var array $format Recebe o array de caracteres especiais que devem ser substituido */
    private array $format;

    /**
     * Recebe a string e faz a conversão se existir caracteres especiais ou espaços em branco.
     *
     * @param string $text Recebe a string que deve ser convertida/otimizada
     * @return string|null
     */
    public function slug(string $text): string|null
    {
        $this->text = $text;

        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:,\\\'<>°ºª';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-----------------------------------------------------------------------------------------------';
        //Retirando os caracteres especiais e atribuindo no que estiver em '$this->format['b']'
        $this->text = strtr(utf8_decode($this->text), utf8_decode($this->format['a']), $this->format['b']);
        //Retirando os espaços do texto e trocando por -
        $this->text = str_replace(" ", "-", $this->text);
        //Verificando se no texto existe mais de um espaço, se existir irá atribuir o -
        $this->text = str_replace(array('-----', '----', '---', '--'), '-', $this->text);
        //Convertendo tudo para minúsculo
        $this->text = strtolower($this->text);

        return $this->text;
    }
}