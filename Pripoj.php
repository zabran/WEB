<?php

require_once (dirname(__DIR__).'/inc/db_settings.inc.php');
class Pripoj
{
    public static $spojeni; 	// tam si ulozim aktualni spojeni
    private static $typ_spojeni = DB_CONNECTION_USE_PDO_MYSQL;

    function __construct()
    {
        self::Connect();
    }

    protected static function getInsertId()
    {
        return self::$spojeni->lastInsertId();
    }

    static function Connect()
    {
        // připojení k DB provedu dle požadovaného typu
        if (self::$typ_spojeni == DB_CONNECTION_USE_PDO_MYSQL) {
            // PDO - MySQL
            try {
                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
                self::$spojeni = new PDO("mysql:host=" . MYSQL_DATABASE_SERVER . ";dbname=" . MYSQL_DATABASE_NAME . "",
                    MYSQL_DATABASE_USER, MYSQL_DATABASE_PASSWORD, $options);

                // nastavit pripojeni na UTF-8 - pro starsi verze PHP
                //$this->connection->exec("SET NAMES UTF8");

            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }

   static function Disconnect()
    {
        if (self::$typ_spojeni == DB_CONNECTION_USE_PDO_MYSQL)
            self::$spojeni = null;
        else
            oci_close(self::$spojeni); // Oracle
    }

    // Spustí dotaz a vrátí z něj první řádek
    public static function dotazJeden($dotaz, $parametry = array()) {
        self::Connect();
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetch();
    }

    // Spustí dotaz a vrátí z něj první řádek
    public static function dotazRow($dotaz, $parametry = array()) {
        self::Connect();
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat;
    }

    // Spustí dotaz a vrátí všechny jeho řádky jako pole asociativních polí
    public static function dotazVsechny($dotaz, $parametry = array()) {
        self::Connect();
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetchAll();
    }

    // Spustí dotaz a vrátí z něj první sloupec prvního řádku
    public static function dotazSamotny($dotaz, $parametry = array()) {
        self::Connect();
        $vysledek = self::dotazJeden($dotaz, $parametry);
        return $vysledek[0];
    }

    // Spustí dotaz a vrátí počet ovlivněných řádků
    public static function dotaz($dotaz, $parametry = array()) {
        self::Connect();
        $navrat = self::$spojeni->prepare($dotaz);
        $_SESSION["namicko2"]=$dotaz;
        $navrat->execute($parametry);
        return $navrat->rowCount();
    }
}