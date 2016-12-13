<?php

/**
Propojení 4l8nk;.
 */
require_once ("pripoj.php");
class Articles extends Pripoj
{
    /**Vrátí všechny 4l8nkz.*/
    public static function getAll($count = 100){
        return self::dotazVsechny("select a.id as id, a.name as 'clanek', u.name as 'user', a.desc, a.file from article a, user u where u.id = a.user_id group by a.id, u.id limit " .$count);
    }

    public static function getByID($id,$count = 100){
        return self::dotazJeden("select a.id as id, a.name as 'clanek', u.name as 'user', a.desc, a.file from article a, user u where u.id = a.user_id and a.id = ".$id." group by a.id, u.id limit " .$count);
    }

    public static function getForViewers($count = 100){
        $sql = self::dotazVsechny("select a.id as id, a.name as 'clanek', u.name as 'user', sum(value)/count(value) as 'rating', a.desc, a.file from article a, comments c, user u where a.id = c.article_id and u.id = a.user_id group by a.id having sum(value)/count(value)>=20 order by sum(value)/count(value) desc limit " .$count);

        return $sql;
    }

    public static function getByUser($id, $count = 100){
        return self::dotazVsechny("select * from article where user_id = ".$id." limit " .$count);
    }

    public static function insert($user_id ,$name, $desc, $file){
        self::dotaz("insert into article (`user_id`, `name`, `desc`, `file`, `time`)"
            . " values ('".$user_id."', '".$name."', '".$desc
            . "', '".$file."', '".date('Y-m-d H:i:s')."')");

        return self::getInsertId();
    }


}