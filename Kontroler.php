<?php

/**
 * Abstraktní trída, kterou všechny ostatní kontrolery extendují.
 * Vzhledem k tomu, že se ostatní kontrolery liší jen nepatrně, neobsahují dokumentaci (s výjimkou SmerovacKontroler).
 */
abstract class Kontroler
{
    /**
     * @var Pole, jehož indexy jsou poté viditelné v šabloně jako běžné proměnné.
     */
    protected $data = array();
    /**
     * @var Název šablony bez přípony
     */
    protected $pohled = "";
    /**
     * @var Hlavička HTML stránky
     */
    protected $hlavicka = array('titulek' => '', 'klicova_slova' => '', 'popis' => '');

    /**
     * Ošetří proměnnou pro výpis do HTML stránky.
     *
     * @param $x libovolný vstup.
     * @return ošetřený vstup.
     */
    public function osetri($x = null)
    {
        if (!isset($x))
            return null;
        elseif (is_string($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x))
        {
            foreach($x as $k => $v)
            {
                $x[$k] = $this->osetri($v);
            }
            return $x;
        }
        else
            return $x;
    }

    /**
     *Vyrenderuje pohled a přesune na správné URL.
     */
    public function vypisPohled()
    {
        if ($this->pohled)
        {


            extract($this->osetri($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            header("Location: /web2/view/".$this->pohled);
            header("Connection: close");
            require_once(dirname(__DIR__)."/view/" . $this->pohled . ".phtml");

            //exit;
        }
    }

    /**Přesměruje na dané URL
     * @param $url
     */
    public static function presmeruj($url)
    {
        header("Location: $url");
        header("Connection: close");
        exit;
    }

    /**Hlavní metoda controlleru.
     * Zpracovává url a podle ní nastavuje pohled.
     * @param $parametry zpracovávaná url
     */
    abstract function zpracuj($parametry);
}