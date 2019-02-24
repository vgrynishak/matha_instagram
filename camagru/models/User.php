<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-01-31
 * Time: 15:01
 */

class User
{
    /**
     * @return string
     */

    public static function login($login)
    {
        $db = Db::getConnection();

        $sql = 'SELECT password, activate FROM users WHERE username = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($login));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    public static function is_exist_log($login)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE username = :name';
        $wait = $db->prepare($sql);
        $wait->execute(array(':name'=>$login));
        $result = $wait->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public static function add($login, $pas, $email, $url_activate){
        $db = Db::getConnection();

        $sql = 'INSERT INTO `users` (`username`, `password`, `email`, `url_activate`) VALUES (?, ?, ?,?)';
        $wait = $db->prepare($sql);
        $wait->execute(array($login, $pas, $email, $url_activate));
        return ($wait);
    }


    public static function is_exist_url($url){
        $db = Db::getConnection();

        $sql = 'SELECT * FROM users WHERE url_activate =?';
        $wait = $db->prepare($sql);
        $wait->execute(array($url));
        $result = $wait->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function activate($url){
        $db = Db::getConnection();

        $sql = 'UPDATE users SET activate = 1 WHERE url_activate = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($url));
        return $wait;
    }

    public static function is_activate($url){
        $db = Db::getConnection();

        $sql = 'SELECT activate FROM users WHERE url_activate =?';
        $wait = $db->prepare($sql);
        $wait->execute(array($url));
        $result = $wait->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function get_id($login){
        $db = Db::getConnection();

        $sql = 'SELECT user_id as id FROM users WHERE username =?';
        $wait = $db->prepare($sql);
        $wait->execute(array($login));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function get_photo($login){
        $db = Db::getConnection();

        $sql = 'SELECT user_pic as photo FROM users WHERE username = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($login));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function sava_as($path, $login){
        $db = Db::getConnection();

        $sql = 'UPDATE users  SET user_pic = ? WHERE username = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($path, $login));
//        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $wait;
    }

    public static function get_photo_by_id($id){
        $db = Db::getConnection();

        $sql = 'SELECT user_pic as photo FROM users WHERE user_id = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($id));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function get_login_by_id($id){
        $db = Db::getConnection();

        $sql = 'SELECT username as login FROM users WHERE user_id = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($id));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function get_email_by_id($id){
        $db = Db::getConnection();

        $sql = 'SELECT email FROM users WHERE user_id = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($id));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function get_notification_by_id($id){
        $db = Db::getConnection();

        $sql = 'SELECT notification as notif FROM users WHERE user_id = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($id));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function save_login($login_old, $login){
        $db = Db::getConnection();

        $sql = 'UPDATE users  SET username = ? WHERE username = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($login, $login_old));
        return $wait;
    }

    public static function save_new_email($new_email, $login){
        $db = Db::getConnection();

        $sql = 'UPDATE users  SET email = ? WHERE username = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($new_email, $login));
        return $wait;
    }

    public static function save_new_pas($new_pas, $login){
        $db = Db::getConnection();

        $sql = 'UPDATE users  SET password = ? WHERE username = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($new_pas, $login));
        return $wait;
    }

    public static function save_new_notif($new_notif, $login){
        $db = Db::getConnection();

        $sql = 'UPDATE users SET notification = ? WHERE username = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($new_notif, $login));
        return $wait;
    }

    public static function get_email_by_login($login){
        $db = Db::getConnection();

        $sql = 'SELECT email FROM users WHERE username = ?';
        $wait = $db->prepare($sql);
        $wait->execute(array($login));
        $result = $wait->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function add_by_fb($login, $email){
        $db = Db::getConnection();

        $sql = 'INSERT INTO `users` (`username`, `email`, `activate`, `url_activate`) VALUES (?, ?, 1, 0)';
        $wait = $db->prepare($sql);
        $wait->execute(array($login,  $email));
        return ($wait);
    }
}