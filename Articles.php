<?php
require_once ("pripoj.php");
/** Model spravující články.*/
class Articles extends Pripoj
{
    /**Vrátí všechny články.
     * @param int $count maximální počet článků.
     * @return všechny články s id, jménem, uživatelem, který je napsal, popisem a jejich souborem.
     * .*/
    public static function getAll($count = 100){
        return self::dotazVsechny("select a.id as id, a.name as 'clanek', u.name as 'user', a.desc, a.file from article a, user u where u.id = a.user_id group by a.id, u.id limit " .($count+0));
    }

    /**Vrací jeden článek podle id.
     * @param $id článku
     * @return vracený článek.
     */
    public static function getByID($id){
        return self::dotazJeden("select a.id as id, a.name as 'clanek', u.name as 'user', a.desc, a.file from article a, user u where u.id = a.user_id and a.id = :id group by a.id, u.id", array(':id' => $id));
    }

    /**Vrací články pro čtenáře (s ratingem větším než 20).
     * @param int $count maximální počet vrácených článků.
     * @return články pro čtenáře.
     */
    public static function getForViewers($count = 100){
        $sql = self::dotazVsechny("select a.id as id, a.name as 'clanek', u.name as 'user', sum(value)/count(value) as 'rating', a.desc, a.file from article a, comments c, user u where a.id = c.article_id and u.id = a.user_id group by a.id having sum(value)/count(value)>=20 order by sum(value)/count(value) desc limit " .($count+0));

        return $sql;
    }

    /**Vrací všechny články uživatele.
     * @param $id uživatele.
     * @param int $count maximální počet článků.
     * @return články uživatele.
     */
    public static function getByUser($id, $count = 100){
        return self::dotazVsechny("select a.id as id, a.name as 'clanek', u.name as 'user', a.desc, a.file from article a, user u where  u.id = a.user_id and u.id = :id limit " .($count+0), array(':id' => $id));
    }

    /**Vložení článku do databáze.
     * @param $user_id id uživatele, který článek napsal.
     * @param $name jméno článku.
     * @param $desc popis článku.
     * @param $file soubor článku.
     * @return id článku.
     */
    public static function insert($user_id , $name, $desc, $file){
        self::dotaz("insert into article (`user_id`, `name`, `desc`, `file`, `time`)"
            . " values (?,?,?,?,?)", array($user_id, $name, $desc, $file, date('Y-m-d H:i:s'))/*('".$user_id."', '".$name."', '".$desc
            . "', '".$file."', '".date('Y-m-d H:i:s')."')"*/);

        return self::getInsertId();
    }

    /**Smaže článek a jeho komentáře.
     * @param $id článku.
     */
    public static function smaz($id){
        self::dotaz("delete from comment where article_id = :id", array(':id' => $id) );
        self::dotaz("delete from article where id =:id limit 1", array(':id' => $id));
}

}