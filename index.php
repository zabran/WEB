<?php

mb_internal_encoding("UTF-8");

define('BASE_DIR', __DIR__);
define('UPLOADS_DIR', BASE_DIR.'/uploads/');

require_once("modely/Pripoj.php");
require_once("inc/db_settings.inc.php");


function autoloadFunkce($trida)
{
    // Končí název třídy řetězcem "Kontroler" ?
    if (preg_match('/Kontroler$/', $trida))
        require("kontrolery/" . $trida . ".php");
    else
        require("modely/" . $trida . ".php");
}

session_start();
spl_autoload_register("autoloadFunkce");

Pripoj::Connect();
// Vytvoření routeru a zpracování parametrů od uživatele z URL
$smerovac = new SmerovacKontroler();
$smerovac->zpracuj(array($_SERVER['REQUEST_URI']));
//$_SESSION['kontrol']=$smerovac;

// Vyrenderování šablony
//$smerovac->vypisPohled();

