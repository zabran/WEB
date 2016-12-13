<?php
require_once (dirname(__DIR__).'/inc/db_settings.inc.php');

/**
 * Základní model, který extendují všechny ostatní modely.
 * Zde se řeší obecné připojení do databáze a ošetření příkazů.
 */
class Pripoj
{
    /**
     * @var aktualni spojeni
     */
    public static $spojeni;
    /**
     * @var int typ spojení - funguje ovšem pouze MYSQL.
     */
    private static $typ_spojeni = DB_CONNECTION_USE_PDO_MYSQL;

    /**
     * Při vytvoření se automaticky připojí na databázi.
     * Vzhledem ke statičnosti nevyužito.
     */
    function __construct()
    {
        self::Connect();
    }

    /**Vrací napodledy vložené id.
     * @return naposledy vložené id.
     */
    protected static function getInsertId()
    {
        return self::$spojeni->lastInsertId();
    }

    /**
     *Připojení do databáze.
     */
    static function Connect()
    {
        // připojení k DB provedu dle požadovaného typu
        if (self::$typ_spojeni == DB_CONNECTION_USE_PDO_MYSQL) {
            // PDO - MySQL
            try {
                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
                self::$spojeni = new PDO("mysql:host=" . MYSQL_DATABASE_SERVER . ";dbname=" . MYSQL_DATABASE_NAME . "",
                    MYSQL_DATABASE_USER, MYSQL_DATABASE_PASSWORD, $options);


            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }

    /**
     *Ukončí spojení.
     * Vzhledem ke statičnosti modulů nevyužito.
     */
    static function Disconnect()
    {
        if (self::$typ_spojeni == DB_CONNECTION_USE_PDO_MYSQL)
            self::$spojeni = null;
        else
            oci_close(self::$spojeni); // Oracle
    }

    /**Spustí dotaz a vrátí z něj první řádek.
     * @param $dotaz tázaný.
     * @param array $parametry k dotazu.
     * @return první získaný řádek.
     */
    public static function dotazJeden($dotaz, $parametry = array()) {
        self::Connect();
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetch();
    }

    /**Spustí dotaz a vrátí ho v nezpracované podobě.
     * @param $dotaz
     * @param array $parametry
     * @return nezpracovaný výsledek dotazu.
     */
    public static function dotazRow($dotaz, $parametry = array()) {
        self::Connect();
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat;
    }

    /**Spustí dotaz a vrátí všechny jeho řádky jako pole asociativních polí.
     * @param $dotaz
     * @param array $parametry
     * @return pole asiciativních pole jakožto výsledek dotazu.
     */
    public static function dotazVsechny($dotaz, $parametry = array()) {
        self::Connect();
        $navrat = self::$spojeni->prepare($dotaz);
        $navrat->execute($parametry);
        return $navrat->fetchAll();
    }

    /**Spustí dotaz a vrátí z něj první sloupec prvního řádku.
     * @param $dotaz
     * @param array $parametry
     * @return první sloupec prvního řádku.
     */
    public static function dotazSamotny($dotaz, $parametry = array()) {
        self::Connect();
        $vysledek = self::dotazJeden($dotaz, $parametry);
        return $vysledek[0];
    }

    /**Spustí dotaz a vrátí počet ovlivněných řádků.
     * @param $dotaz
     * @param array $parametry
     * @return počet získaných řádků.
     */
    public static function dotaz($dotaz, $parametry = array()) {
        self::Connect();
        $navrat = self::$spojeni->prepare($dotaz);
        $_SESSION["namicko2"]=$dotaz;
        $navrat->execute($parametry);
        return $navrat->rowCount();
    }
}