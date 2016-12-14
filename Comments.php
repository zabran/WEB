<?php

/**
Model spravující komentáře.
 */
class Comments extends Pripoj
{
    /**Vrátí všechny uživatele.
     * @param int $count maximální počet uživatelů.
     * @return všichni uživatelé.
     */
    public static function getAll($count = 100){
        return self::dotazVsechny("select * from comment limit " .($count+0));
    }

    /**Vrací komentáře podle id uživatele.
     * @param $id uživatele.
     * @param int $count maximální počet komentářů.
     * @return komentáře daného uživatele.
     */
    public static function getByUser($id, $count = 100){
        return self::dotazVsechny("select * from comment where user_id = :id limit ".($count+0), array(':id' => $id));
    }

    /**Vrací komentáře podle id článku.
     * @param $id článku
     * @param int $count maximální počet komentářů.
     * @return komentáře pod článek.
     */
    public static function getByArticle($id, $count = 100){
        return self::dotazVsechny("select c.id,c.head, c.body, c.value, u.name from comment c, user u where u.id = c.user_id and article_id = :id limit ".($count+0), array(':id' => $id));
    }


    /**Vloží nový komentář do databáze.
     * @param $user_id id uživatele, který tento komentář napsal.
     * @param $article_id id článku, pod kterým je komentář napsán.
     * @param $head nadpis komentáře.
     * @param $body text komentáře.
     * @param $value hodnocení v komentáři.
     * @return id komentáře.
     */
    public static function insert($user_id, $article_id, $head, $body, $value){
        self::dotaz("insert into comment (user_id, article_id, head, body, value, time)
 values (?,?,?,?,?,?)", array($user_id, $article_id , $head , $body
            , $value, date('Y-m-d H:i:s'))); /*('".$user_id."','".$article_id."','".$head."', '".$body
            . "', '".$value."', '".date('Y-m-d H:i:s')."')");*/

        return self::getInsertId();
    }

    /**Vrací hodnocení článku.
     * @param $id článku.
     * @return hodnocení článku.
     */
    public static function getRating($id){
        return self::dotazJeden("select sum(value)/count(value) as rating from comment WHERE article_id = :id", array(':id' => $id));
   }

    /**Smaže komentář z databáze.
     * @param $id komentáře.
     */
    public static function smaz($id){
    self::dotaz("delete from comment where id = :id limit 1", array(':id' => $id) );
}

}