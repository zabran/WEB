<?php
require_once (dirname(__DIR__).'/modely/Users.php');
class RegistraceKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Registrace',
            'klicova_slova' => 'login, registrace, heslo',
            'popis' => 'Registrace na web.'
        );



        $this->pohled = 'registrace';
    }

    public function registrace($user, $pas, $mail){
        Users::registrace($user, $pas, $mail);
    }
}