<?php
require_once (dirname(__DIR__).'/modely/Articles.php');
require_once (dirname(__DIR__).'/modely/Comments.php');
class PrispevkyKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Příspěvky',
            'klicova_slova' => 'články, témata, příspěvky',
            'popis' => 'Všechny články s komentáři.'
        );



        $this->pohled = 'prispevky';
    }

    public function getClanky(){
        if($_SESSION["rule"]>1)
        {return Articles::getAll();}
        //else error;
    }
}