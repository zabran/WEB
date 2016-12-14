<?php
require_once (dirname(__DIR__).'/modely/Articles.php');
require_once (dirname(__DIR__).'/modely/Comments.php');
require_once (dirname(__DIR__).'/modely/Users.php');
class KomentareKontroler extends Kontroler
{

    public $id = null;
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Komentáře',
            'klicova_slova' => 'komentáře, příspěvky, hodnocení',
            'popis' => 'Komentáře k danému příspěvku.'
        );



        $this->pohled = 'komentare';
        $_SESSION["adacko2"]=$parametry[2];
        $_SESSION["adacko3"]=$parametry[3];
        $this->id=$parametry[3];
        //$this->id=substr($this->id, 4);

    }
    /*Vrací otevřený článek.*/
    public function getArticle(){
        if($_SESSION["rule"]>1)
        {return $this->osetri(Articles::getById($this->id+0));}
    }

    /*Vrací komentáře tohoto článku.*/
    public function getKomentare(){
        if($_SESSION["rule"]>1)
        {return $this->osetri(Comments::getByArticle($this->id+0));}
        //else error;
    }

    /*Vrací hodnocení článku.*/
    public function getRating($id){
        if($_SESSION["rule"]>1)
        {return $this->osetri(Comments::getRating($id+0));}
        //else error;
    }

    /*Vloží komentář do databáze.*/
    public function insertKoment( $art, $head, $value, $body){
        if($_SESSION["rule"]>1){
            $user= Users::getByName($_SESSION["login"]);
Comments::insert($user["id"], $art, $head, $body, $value+0);
        }
    }
    /*Přidá adminské tlačítko pro smazání komentáře.*/
    public function getSmazButton($id){
        $adminOnly=null;
        if($_SESSION["rule"]==3) $adminOnly = '<form action = "" method = "post">
                <input type = "hidden" name = "id" value="'. $id.'" />
                <input type="submit" class="btn btn-danger btn-xs" name="smazat" value="Smazat" />
                </form>';
        return $adminOnly;
    }
    /*Smaže komentář.*/
    public function smaz($id){
        if($_SESSION["rule"]==3)
        {
            Comments::smaz($id+0);
        }
    }
}