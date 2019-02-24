<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-02-10
 * Time: 14:23
 */

class Like{
    public static function like_n($image_id){
        $db = Db::getConnection();
        $sql = 'SELECT COUNT(*) as n FROM likes WHERE image_id=?';
        $wait = $db->prepare($sql);
        $wait->execute(array($image_id));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return ($result);
    }

    public static function add_likes($image_id, $user_id){
        $db = Db::getConnection();

        $sql = 'INSERT INTO likes (image_id, user_id) VALUES (?, ?)';
        $wait = $db->prepare($sql);
        $wait->execute(array($image_id, $user_id));
        return ($wait);
    }

    public static function delete_likes($user_id, $image_id){
        $db = Db::getConnection();

        $sql = 'DELETE  FROM likes WHERE user_id = ? AND image_id = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($user_id, $image_id));
        return ($wait);
    }

    public static function is_exist_user($user_id, $image_id)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM likes WHERE user_id = ? AND image_id = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($user_id, $image_id));
        $result = $wait->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function delete_likes_by_image( $image_id){
        $db = Db::getConnection();

        $sql = 'DELETE  FROM likes WHERE  image_id = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($image_id));
        return ($wait);
    }
}