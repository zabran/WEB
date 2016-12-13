<?php

/**
Propojení uživatelů.
 */
require_once ("pripoj.php");
class Users extends Pripoj
{
    /**Vrátí všechny uživatele.*/
    public static function getAll(){
        return self::dotazVsechny("select * from user ");
    }

    public static function getByName($name){
        return self::dotazJeden("select * from user where name = '".$name."'");
    }

    public static function login($name, $pass){
        $dotaz ="select * from user where name = '".$name. "' and password = '".$pass."'";
        $_SESSION['dotaz']=$dotaz;
        $sql = self::dotaz($dotaz);
        $_SESSION['sql']=$sql;
        //$count = $sql->rowCount();
        //$sql->fatch();
        if($sql =1){
            $sql=self::dotazJeden($dotaz);

            $_SESSION['login']=$sql['name'];
            $_SESSION['rule']=$sql['rules_id'];
        }
    }

   /* public function insert($name, $pass, $mail){
        $this->execute("insert into users (name, password,, email, rules_id)"
            . "values ('".$name."', '".MiscHelpers::passwordHash($pass)
            . "', '".$mail."', '1')");

        return $this->getInsertId();
    }*/

    public static function insert($name, $pass, $mail, $rule =1){
        self::dotaz("insert into user (name, password,, email, rules_id)"
            . "values ('".$name."', '".$pass
            . "', '".$mail."', '".$rule."')");

        return self::getInsertId();
    }

    public static function getAllWithRule($rule){
        return self::dotazVsechny("select * from user where rule_id = " .$rule);
    }

    public static function setRule($id ,$rule){
        self::dotaz("UPDATE users SET role = '".$rule."' WHERE id = ".$id." limit 1");
    }
}