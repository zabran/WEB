<?php
require_once (dirname(__DIR__).'/modely/Users.php');
class Sprava_uzivateluKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'Správa uživatelů',
            'klicova_slova' => 'uživatelé, adminská sprava, mazání uživatelů, nastavení',
            'popis' => 'Adminská správa uživatelů.'
        );



        $this->pohled = 'sprava_uzivatelu';
    }

    /*Vrátí všechny uživatele.*/
    public function getUzivatele(){
        if($_SESSION["rule"]==3){
           return $this->osetri(Users::getAll());
        }
    }

    /*Nastaví uživateli práva.*/
    public function setRule($id, $rule){
        if($_SESSION["rule"]==3){
            Users::setRule($id+0, $rule);
        }
    }
    //TODO
    /*Smaže uživatele. Ze strukturních důvodů neimplementováno.*/
    public function smaz($id){

    }
}