<?php
require_once (dirname(__DIR__).'/modely/Articles.php');
require_once (dirname(__DIR__).'/modely/Users.php');
require_once (dirname(__DIR__).'/modely/Comments.php');
class Moje_prispevkyKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Moje příspěvky',
            'klicova_slova' => 'moje články, moje témata, moje příspěvky',
            'popis' => 'Všechny mé články s komentáři.'
        );



        $this->pohled = 'moje_prispevky';
    }

    public function getClanky(){
        if($_SESSION["rule"]>1)

        {$user=Users::getByName($_SESSION["login"]);
            $id=$user["id"];
            return $this->osetri(Articles::getByUser($id));}
        //else error;
    }

    public function getRating($id){
        if($_SESSION["rule"]>1)
        {return $this->osetri(Comments::getRating($id));}
        //else error;
    }

    public function smaz($user, $id){
        if($_SESSION["rule"]>1){
            if($_SESSION["login"]==$user){
                Articles::smaz($id);
            }
        }
    }
}