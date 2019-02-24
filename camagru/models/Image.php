<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-02-07
 * Time: 16:47
 */

class Image{
    public static function max_id(){
        $db = Db::getConnection();
        $sql = 'SELECT MAX(image_id) as id FROM `image`';
        $wait = $db->prepare($sql);
        $wait->execute();
        $result=$wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function add($id, $path){
        $db = Db::getConnection();
        $sql = 'INSERT INTO `image` (`user_id` , `path`) VALUES (?, ?)';
        $wait = $db->prepare($sql);
        $wait->execute(array($id, $path));
        return $wait;
    }
    public static function all_photo($id){
        $db = Db::getConnection();
        $sql = 'SELECT COUNT(*) as num FROM image WHERE user_id=?';
        $wait = $db->prepare($sql);
        $wait->execute(array($id));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function all_photos(){
        $db = Db::getConnection();
        $sql = 'SELECT COUNT(*) as num FROM image ';
        $wait = $db->prepare($sql);
        $wait->execute(array());
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function photos($id, $start, $finish){
        $db = Db::getConnection();
        $sql = 'SELECT path, image_id FROM image WHERE user_id=? ORDER BY image_id ASC   LIMIT '.$start.', '.$finish;
        $wait = $db->prepare($sql);
        $wait->execute(array($id));
        $result = $wait->fetchAll(PDO::FETCH_ASSOC);
        return array_reverse($result);
    }

    public static function photos_n($start, $finish){
        $db = Db::getConnection();
        $sql = 'SELECT path, image_id, user_id FROM image  ORDER BY image_id ASC   LIMIT '.$start.', '.$finish;
        $wait = $db->prepare($sql);
        $wait->execute(array());
        $result = $wait->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function delete_photos($path){
        $db = Db::getConnection();
        $sql = 'DELETE  FROM image  WHERE path = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($path));
        return $wait;
    }

    public static function get_user_by_photo($id){
        $db = Db::getConnection();
        $sql = 'SELECT user_id  FROM image  WHERE image_id = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($id));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function get_id_by_path($path){
        $db = Db::getConnection();
        $wait = $db->prepare('SELECT image_id FROM image WHERE path = ?');
        $wait->execute(array($path));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}