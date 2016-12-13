<?php
require_once (dirname(__DIR__).'/modely/Articles.php');
require_once (dirname(__DIR__).'/modely/Users.php');
class Novy_prispevekKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Nový příspěvek',
            'klicova_slova' => 'psaní, příspěvek, článek',
            'popis' => 'Napsat nový příspěvek.'
        );



        $this->pohled = 'novy_prispevek';
    }

    public function novyPrispevek($name, $desc, $file){
        if($_SESSION["rule"]>1){

            $user = Users::getByName($_SESSION["login"]);
            $id = $user["id"];
            $_SESSION["namicko"]=$id;
            Articles::insert($id, $name, $desc, $file);
        }
    }

}