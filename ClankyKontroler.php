<?php
require_once (dirname(__DIR__).'/modely/Articles.php');
class ClankyKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Články',
            'klicova_slova' => 'články, témata, příspěvky',
            'popis' => 'Články s nejvyšším hodnocením.'
        );



        $this->pohled = 'clanky';
    }

    public function getClanky(){
        if($_SESSION["rule"]>0)
        {return Articles::getForViewers();}
        //else error;
    }
}