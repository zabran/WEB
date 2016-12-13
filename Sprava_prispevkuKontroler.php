<?php
require_once (dirname(__DIR__).'/modely/Articles.php');
require_once (dirname(__DIR__).'/modely/Users.php');
require_once (dirname(__DIR__).'/modely/Comments.php');
class Sprava_prispevkuKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Správa příspěvků',
            'klicova_slova' => 'správa, příspěvky, články',
            'popis' => 'Adminská správa příspěvků.'
        );



        $this->pohled = 'sprava_prispevku';
    }

    public function getClanky(){
        if($_SESSION["rule"]==3)

        {
            return $this->osetri(Articles::getAll());}
        //else error;
    }

    public function getRating($id){
        if($_SESSION["rule"]==3)
        {return $this->osetri(Comments::getRating($id));}
        //else error;
    }

    public function smaz($id){
        if($_SESSION["rule"]==3){
                Articles::smaz($id);
        }
    }
}