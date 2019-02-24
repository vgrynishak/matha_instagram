<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-02-15
 * Time: 16:16
 */

class Coment{
    public static function add_coment($user_id, $image_id, $text){
        $db = Db::getConnection();

        $sql = "INSERT INTO coments (`image_id`, `user_id`, `text`) VALUES (?, ?, ?)";
        $wait = $db->prepare($sql);
        $wait->execute(array($image_id, $user_id,$text));
        return $wait;
    }

    public static function take_coment($image_id){
        $db = Db::getConnection();

        $sql = "SELECT user_id, text, date_format(`date`, '%Y-%m-%d %H:%i:%s') as 'date', coment_id FROM coments WHERE image_id = ?";
        $wait = $db->prepare($sql);
        $wait->execute(array($image_id));
        $result = $wait->fetchAll(PDO::FETCH_ASSOC);
        return array_reverse($result);
    }

    public static function take_coment_last($image_id){
        $db = Db::getConnection();

        $sql = 'SELECT user_id, text, `date`, coment_id FROM coments WHERE image_id=? ORDER BY date DESC    LIMIT 1';
        $wait = $db->prepare($sql);
        $wait->execute(array($image_id));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function delete_coment( $coment_id){
        $db = Db::getConnection();

        $sql = "DELETE FROM  coments WHERE coment_id = ?";
        $wait = $db->prepare($sql);
        $wait->execute(array($coment_id));
        return $wait;
    }

    public static function delete_coment_by_photo( $image_id){
        $db = Db::getConnection();

        $sql = "DELETE FROM  coments WHERE image_id = ?";
        $wait = $db->prepare($sql);
        $wait->execute(array($image_id));
        return $wait;
    }
}