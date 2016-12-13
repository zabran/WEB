<?php
class AboutKontroler extends Kontroler
{
    public function zpracuj($parametry)
    {
        $this->hlavicka = array(
            'titulek' => 'O konferenci',
            'klicova_slova' => 'informace, FAQ, info',
            'popis' => 'Úvodní stránka.'
        );



        $this->pohled = 'about';
    }

    public function update(){
        if($_SESSION["rule"]==1){
            $user = Users::getByName($_SESSION["login"]);
            $id = $user["id"];
            Users::setRule($id, 2);
            $_SESSION["rule"]=2;
        }
    }
}