<?php
class zaklad{

    public static function hlavicka(){

        $titulek =$_SESSION['titulek'];
        $popis =$_SESSION["popis"];
        $klic =$_SESSION["klicova_slova"];

        return "<head>
       <meta charset=\"utf-8\">
       <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
       <meta http-equiv=\"Content-language\" content=\"cs\">
       <meta name=\"robots\" content=\"index,follow\">
       <meta name=\"author\" content=\"zabran\">
       <link href=\"/web2/css/foundation.min.css\" rel=\"stylesheet\" />
       <link href=\"/web2/css/main.css\" rel=\"stylesheet\" />".
       "<title>"  .$titulek."</title>".
       '<meta name=\\"description\\" content=\\" ' .$popis. '\\" />
       <meta name=\\"keywords\\" content=\\"'. $klic. '\\"/>


   </head>';

    }

    public static function spodek(){
      return  '<body><div class="container">'.'<div id="footer">
            Copyright &copy; 2016, <a href="mailto:zabran@students.zcu.cz" title="E-mail autora - Marek Zábran">Marek Zábran</a>
        </div>'.'</div></body>';
    }

    public static function leveMenu(){
        if(!empty($_SESSION["login"])){
          return  /*'<body>
    <div class="container">'.'
            <div class="content nopad">'.*/'
            <div id="leftmenu">
                <a title="Úvod" href="../view/uvod" class="item">Úvod</a>
                <a title="O konferenci" href="../view/about" class="item">O konferenci</a>
                <a title="Články" href="../view/clanky" class="item">Články</a>
            </div>


        '/*.'</div>
            </div>
</body>'*/;
        }


    }

    public static function horniMenu(){
        $rule = array("Čtenář", "Spisovatel", "Admin");

        $html =
        '<body>'.'
    <div class="container">
        <div id="header">
            <a href="../view/login" class="nodecor" title="Zpět na titulní stranu"><h1>Konference</h1></a>';
            if(!empty($_SESSION["login"])){
                $prav = $_SESSION['rule']-1;
                $rule = $rule[$prav];
            $html = $html . '<div class="userpanel">
        Uživatel: '.$_SESSION["login"].'<br />
                    Role: '.$rule.'<br/>
                    <a href="../view/logout" title="Odhlásit se ze systému">Odhlásit se</a>
                </div></div>';//TODO
            if($_SESSION["rule"]>1)
            {

                $html=$html . '<div id="navmenu">
                <a class="item" href="../view/profil" title="Jít na profil" >Profil</a>
                
                    <a class="item" href="../view/novy_prispevek" title="Jít na přidávání příspěvku">Nový příspěvek</a>
                    <a class="item" href="../view/moje_prispevky" title="Jít na seznam mých příspěvků">Moje příspěvky</a>
                
                    <a class="item" href="../view/prispevky" title="Jít na seznam příspěvků">Všechny příspěvky</a>';
                if($_SESSION["rule"]==3)
                {
                    $html=$html . '<a class="item" href="../view/sprava_prispevky" title="Spravovat příspěvky">Správa příspěvků</a>
                    <a class="item" href="../view/sprava_uzivatele" title="Spravovat uživatele">Správa uživatelů</a>';
                }
                $html=$html . '</div>';
            }
            }
        $html=$html . '</div></div>'
       .' </body>';
            return $html;
    }

    public static function allIn(){
       return self::hlavicka().self::horniMenu()/*.self::leveMenu().self::spodek()*/;

    }
}