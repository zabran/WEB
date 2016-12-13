<?php
class LogoutKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Logout',
            'klicova_slova' => 'logout, odhlášení',
            'popis' => 'Odhlášní z webu.'
        );



        $this->pohled = 'logout';
    }
}