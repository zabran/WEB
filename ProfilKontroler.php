<?php
require_once (dirname(__DIR__).'/modely/Users.php');
class ProfilKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Profil',
            'klicova_slova' => 'profil, změna jména, změna heslo, nastavení',
            'popis' => 'Váš profil.'
        );



        $this->pohled = 'profil';
    }

    public function hesloOK($pas){
       return (Users::getByName($_SESSION["login"])["password"]==$pas);
    }
    public function zmenProfil($name, $pas, $rule){
        if($_SESSION["rule"]>1){
            $user = Users::getByName($_SESSION["login"]);
            $id = $user["id"];
            Users::setRule($id, $rule);
            Users::setName($id, $name);
            Users::setPass($id, $pas);
            $_SESSION["rule"]=$rule;
            $_SESSION["login"]=$name;
        }
    }
}