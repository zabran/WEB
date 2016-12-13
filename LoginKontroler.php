<?php
require_once (dirname(__DIR__).'/modely/Users.php');
class LoginKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Login',
            'klicova_slova' => 'login, registrace, heslo',
            'popis' => 'Login na web.'
        );



        $this->pohled = 'login';
    }

    public function login($user, $pas){
        Users::login($user, $pas);
    }
}