<?php
class UvodKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Úvod',
            'klicova_slova' => 'titulní stránka, úvod, info',
            'popis' => 'Úvodní stránka.'
        );



        $this->pohled = 'uvod';
    }
}