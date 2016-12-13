<?php
require_once('Kontroler.php');
require_once('LoginKontroler.php');
/** Smerovac je kontroler typu router - kontroler, který podle URL adresy zavolá
 správný podkontroler a jím vytvořený pohled uloží.*/
class SmerovacKontroler extends Kontroler
{
    /** Instance podkontroleru*/
    public $kontroler;

    /** Metoda převede pomlčkovou variantu kontroleru na název třídy.
     *  @param $text pomlčkovaný text.
     * @return vypomlčkovaná věta.
     */
    private function pomlckuj($text)
    {
        $_SESSION["hej0"]= "$text";
        $veta = str_replace('-', ' ', $text);
        $_SESSION["hej1"]= "$veta";
        $veta = ucwords($veta);
        $_SESSION["hej2"]= "$veta";
        $veta = str_replace(' ', '', $veta);
        $_SESSION["hej3"]= "$veta";
        return $veta;
    }

/** Naparsuje URL adresu podle lomítek a vrátí pole parametrů.
 * @param $url parsované url.
 *  @return vyparsované url.
 */
    private function parsujURL($url)
    {
        // Naparsuje jednotlivé části URL adresy do asociativního pole
        $naparsovanaURL = parse_url($url);
        // Odstranění počátečního lomítka
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
        // Odstranění bílých znaků kolem adresy
        $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
        // Rozbití řetězce podle lomítek
        $rozdelenaCesta = explode("/", $naparsovanaURL["path"]);
        return $rozdelenaCesta;
    }

    /** Přejde na nový pohled.
     * @param $url url, ne kterou se přešlo.
     */
    public function prejdi($url){
        if(substr($url[0],0,1)=="/") {
            $url[0]=substr($url[0], 1);
            $_SESSION["jsmeTam"]=$url[0];
        }
        $url = explode("/", $url);
        $_SESSION["url0"]= "$url[0]";
        $_SESSION["url1"]= "$url[1]";

        $i=0;
        $i2=1;
        foreach ($url as $slovo){
            if($slovo=="view"){$i2=$i;}
            $i++;
        }
        $url2 = $this->pomlckuj($url[$i2+1]);
        $tridaKontroleru = $url2 . "Kontroler";
        $_SESSION["tridaKontroleru"]= $tridaKontroleru;
       /* if (file_exists('web2/kontrolery/' . $tridaKontroleru . '.php'))

        {    */     $_SESSION["super"]= ('web2/kontrolery/' . $tridaKontroleru . '.php');
            $this->kontroler = new $tridaKontroleru;
            $this->kontroler->zpracuj($url);
            $this->data['titulek'] = $this->kontroler->hlavicka['titulek'];
            $this->data['popis'] = $this->kontroler->hlavicka['popis'];
            $this->data['klicova_slova'] = $this->kontroler->hlavicka['klicova_slova'];
            $_SESSION["titulek"]=$this->data['titulek'];
            $_SESSION["popis"]=$this->data['popis'];
            $_SESSION["klicova_slova"]=$this->data['klicova_slova'];

            // Nastavení hlavní šablony
            $this->pohled = $url[$i2+1];
            //$_SESSION['kontrol']=$this;

// Vyrenderování šablony
            $this->vypisPohled();
       /* }
        else {
            $this->presmeruj('web2/view/error');
            return;
        }*/
    }

    /**
     * Zkontroluje, jestli je nastavený správný pohled,
     * pokud se neaktivovalo přesměrování na index.
     * @param $url kontrolovaná.
     */
    public function zkontroluj($url){
        if(substr($url[0],0,1)=="/")
        {
            $url[0]=substr($url[0], 1);
            $_SESSION["jsmeTam"]=$url[0];
        }
        $url2 = explode("/", $url[0]);
        $i=0;
        $i2=1;
        foreach ($url2 as $slovo)
        {
            if($slovo=="view"){$i2=$i;}
            $i++;
        }
        $url3 = $this->pomlckuj($url2[$i2+1]);
        //if(iconv("utf-8", "us-ascii//TRANSLIT",$_SESSION["titulek"])!=$url3){

            $tridaKontroleru = $url3 . "Kontroler";
            $_SESSION["tridaKontroleru"]= $tridaKontroleru;
            $_SESSION["super"]= ('web2/kontrolery/' . $tridaKontroleru . '.php');
            $this->kontroler = new $tridaKontroleru;
            $this->kontroler->zpracuj($url2);
            $this->data['titulek'] = $this->kontroler->hlavicka['titulek'];
            $this->data['popis'] = $this->kontroler->hlavicka['popis'];
            $this->data['klicova_slova'] = $this->kontroler->hlavicka['klicova_slova'];
            $_SESSION["titulek"]=$this->data['titulek'];
            $_SESSION["popis"]=$this->data['popis'];
            $_SESSION["klicova_slova"]=$this->data['klicova_slova'];

            // Nastavení hlavní šablony
            $this->pohled = $url3;
        //}
    }

    /**Zpracuje URL a buď na ní přejde nebo přejde na login.
     * @param zpracovávaná $parametry
     */
    public function zpracuj($parametry)
    {
        $naparsovanaURL = $this->parsujURL($parametry[0]);
        $_SESSION["pars0"]= "$naparsovanaURL[0]";

        if (empty($naparsovanaURL[1])) {
            $url ='web2/view/login';
            $this->prejdi($url);
        }
        else{
        $this->prejdi($parametry[0]);}

    }
}