<?php

/**
Propojení komentářů.
 */
class Comments extends Pripoj
{
    /**Vrátí všechny uživatele.*/
    public static function getAll($count = 100){
        return self::dotazVsechny("select * from comment limit " .$count);
    }

    public static function getByUser($id, $count = 100){
        return self::dotazVsechny("select * from comment where user_id = ".$id." limit ".$count);
    }

    public static function getByArticle($id, $count = 100){
        return self::dotazVsechny("select c.head, c.body, c.value, u.name from comment c, user u where u.id = c.user_id and article_id = ".$id." limit ".$count);
    }


    public static function insert($user_id, $article_id,$head, $body, $value){
        self::dotaz("insert into comment (user_id, article_id, head, body, value, time) "
            . " values ('".$user_id."','".$article_id."','".$head."', '".$body
            . "', '".$value."', '".date('Y-m-d H:i:s')."')");

        return self::getInsertId();
    }

   public static function getRating($id){
        return self::dotazJeden("select sum(value)/count(value) as rating from comment WHERE article_id = ".$id);
   }



}