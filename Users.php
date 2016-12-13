<?php
require_once ("pripoj.php");
/**
Model spravující uživatele.
 */
class Users extends Pripoj
{
    /**Vrátí všechny uživatele.
     * @return všechny uživatele.
     */
    public static function getAll(){
        return self::dotazVsechny("select * from user ");
    }

    /**Vrátí uživatele se zadaným jménem.
     * @param $name jméno uživatele
     * @return první uživatel s tímto jménem.
     */
    public static function getByName($name){
        return self::dotazJeden("select * from user where name = '".$name."'");
    }

    /**Vyzkouší, jestli uživatel je v databázi a připadně ho připojí do sessiony.
     * @param $name zadané jméno uživatele.
     * @param $pass zadané heslo.
     */
    public static function login($name, $pass){
        $dotaz ="select * from user where name = '".$name. "' and password = '".$pass."'";
        $_SESSION['dotaz']=$dotaz;
        $sql = self::dotaz($dotaz);
        $_SESSION['sql']=$sql;
        //$count = $sql->rowCount();
        //$sql->fatch();
        if($sql ==1){
            $sql=self::dotazJeden($dotaz);

            $_SESSION['login']=$sql['name'];
            $_SESSION['rule']=$sql['rules_id'];
        }
    }

    /**Vyzkouší, jestli uživatelské jméno už není zabrané, zaregistruje uživatele a zaloguje ho.
     * @param $name zadané jméno uživatele.
     * @param $pass zadané heslo.
     */
    public static function registrace($name, $pass, $mail){
        $dotaz ="select * from user where name = '".$name."' or email = '".$mail."'";
        $sql = self::dotaz($dotaz);
        //$count = $sql->rowCount();
        //$sql->fatch();
        if($sql ==0){

            self::insert($name, $pass, $mail);
            $_SESSION['login']=$name;
            $_SESSION['rule']=1;
        }
    }


    /**Vloží nové uživatele do databáze.
     * @param $name jméno uživatele.
     * @param $pass heslo.
     * @param $mail email.
     * @param int $rule přístupová práva.
     * @return naposledy zadané id.
     */
    public static function insert($name, $pass, $mail, $rule =1){
        self::dotaz("insert into user (`name`, `password`, `email`, `rules_id`) values ('".$name."', '".$pass
            . "', '".$mail."', '".$rule."')");

        return self::getInsertId();
    }

    /**Vrátí všechny uživatele s danými přístupovými právy.
     * @param $rule přístupová práva.
     * @return pole uživatelé s danými právy.
     */
    public static function getAllWithRule($rule){
        return self::dotazVsechny("select * from user where rule_id = " .$rule);
    }

    /**Přenastaví práva uživatele.
     * @param $id uživatele.
     * @param $rule nová práva uživatele.
     */
    public static function setRule($id , $rule){
        self::dotaz("UPDATE user SET rules_id = '".$rule."' WHERE id = ".$id." limit 1");
    }

    /**Přenastaví jméno uživatele.
     * @param $id uživatele.
     * @param $rule nové jméno uživatele.
     */
    public static function setName($id , $name){
        self::dotaz("UPDATE user SET `name` = '".$name."' WHERE id = ".$id." limit 1");
    }

    /**Přenastaví heslo uživatele.
     * @param $id uživatele.
     * @param $rule nové heslo uživatele.
     */
    public static function setPass($id , $pas){
        self::dotaz("UPDATE user SET password = '".$pas."' WHERE id = ".$id." limit 1");
    }
}