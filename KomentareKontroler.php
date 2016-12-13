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
    public function getArticle(){
        if($_SESSION["rule"]>0)
        {return Articles::getById($this->id);}
    }

    public function getKomentare(){
        if($_SESSION["rule"]>0)
        {return Comments::getByArticle($this->id);}
        //else error;
    }

    public function insertKoment( $art, $head, $value, $body){
        if($_SESSION["rule"]>0){
            $user= Users::getByName($_SESSION["login"]);
Comments::insert($user["id"], $art, $head, $body, $value);
        }
    }
}