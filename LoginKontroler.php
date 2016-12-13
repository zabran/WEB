<?php
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
}