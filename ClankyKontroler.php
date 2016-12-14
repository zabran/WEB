<?php
require_once (dirname(__DIR__).'/modely/Articles.php');
require_once (dirname(__DIR__).'/modely/Comments.php');

/**
 * Class ClankyKontroler
 */
class ClankyKontroler extends Kontroler
{
    /**
     * @param $parametry
     */
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Články',
            'klicova_slova' => 'články, témata, příspěvky',
            'popis' => 'Články s nejvyšším hodnocením.'
        );



        $this->pohled = 'clanky';
    }

    /**Vrací články pro čtenáře.
     * @return články
     */
    public function getClanky(){
        if($_SESSION["rule"]>0)
        {return $this->osetri(Articles::getForViewers());}
        //else error;
    }

    /**Vrací rating článku.
     * @param $id
     * @return mixed
     */
    public function getRating($id){
        if($_SESSION["rule"]>0)
        {return $this->osetri(Comments::getRating($id+0));}
        //else error;
    }
}