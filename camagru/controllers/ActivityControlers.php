<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-02-06
 * Time: 12:54
 */

class ActivityControlers {
    public function ActionPhoto(){
        if (isset($_SESSION["user"])){
            $user_id = User::get_id($_SESSION["user"]);
            $notif = User::get_notification_by_id($user_id["id"])["notif"];
            require_once ROOT. "/views/user/photos.php";
            return true;
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }

    public function ActionSave()
    {
        if ($_SESSION["user"] && $_POST['save_albom'])
        {
            $result = preg_replace("~http://".$_SERVER["HTTP_HOST"]."/(images/\d+)~", '$1', $_POST['save_albom']);
            User::sava_as("/".$result, $_SESSION["user"]);
//            echo $result;
        }
        else if ($_SESSION['user'] && $_POST['back-img']) {
            $img = str_replace(' ', '+', $_POST["back-img"]);
            $img = base64_decode($img);
            $n = $_POST["num"];
            $gd_photo = imagecreatefromstring($img);
            $i = 0;
            while ($i < $n) {
                $sticker = $_POST['src' . $i];
                $gd_filter = imagecreatefrompng($sticker);
                $width = $_POST['width' . $i];
                $height = $_POST['height' . $i];
                $top = $_POST['top' . $i];
                $left = $_POST['left' . $i];
                imagecopyresampled($gd_photo, $gd_filter, intval($left), intval($top), 0, 0, intval($width), intval($height), imagesx($gd_filter), imagesy($gd_filter));
                $i++;
            }
            ob_start();
            imagepng($gd_photo);
            $image_data = ob_get_contents();
            ob_end_clean();
            $user_id = User::get_id($_SESSION["user"]);
            $result = Image::max_id();
            if (!$result["id"])
                $new = 1;
            else
                $new = $result["id"] + 1;
            $path = 'images/' . $new . ".png";
            file_put_contents($path, $image_data);
            Image::add($user_id["id"], $path);
            if (isset($_POST['lol'])) {
                User::sava_as("/".$path, $_SESSION["user"]);
                echo "lol";
            }
            else
                echo "nope";
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }

    public function ActionSearch(){
        if (isset($_SESSION["user"]) && $_POST['login']){
            $array = User::is_exist_log($_POST['login']);
            if ($array && $array[0]['activate'] == 1){
                echo User::get_id($_POST['login'])['id'];
            }
            else
                echo '-';
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }

    public function ActionShow($id){
        if (isset($_SESSION['user'])) {
            echo $id;
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }
    public function ActionAlbom($login, $page){
        if (isset($_SESSION["user"]) && User::is_exist_log($login)) {
            $_SESSION["page"] = $page;
            $user_id = User::get_id($_SESSION["user"]);
            $notif = User::get_notification_by_id($user_id["id"])["notif"];
            $avatar = User::get_photo($_SESSION["user"]);
            $user_id = User::get_id($login);
            $all_photo = Image::all_photo($user_id["id"]);
            $max = ceil($all_photo['num'] / 12);
            if ($all_photo['num']) {
                if ($page * 12 <= $all_photo['num']) {
                    $start = $all_photo['num'] - $page * 12;
                    $finish = 12;
                } else {
                    $start = 0;
                    $finish = ($all_photo['num'] > 12) ? $all_photo['num'] - ($page - 1) * 12 : $all_photo['num'];
                }

                $all_p = Image::photos($user_id["id"], $start, $finish);
            }
            require_once ROOT . "/views/user/albom.php";
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }
    public function ActionLikes(){
        if ( isset($_POST["id"]))
        {
            $user_id = User::get_id($_SESSION["user"]);
            if (Like::is_exist_user($user_id["id"], $_POST["id"])) {
                Like::delete_likes($user_id["id"], $_POST["id"]);
            }
            else {
                Like::add_likes($_POST["id"], $user_id["id"]);
            }
        }
        else
            require_once ROOT."/views/layouts/error.php";

    }

    public function ActionColor(){
        if ( isset($_POST["check"]))
        {
            $element =  array();
            $n = Like::like_n($_POST["check"]);
            $element[] = $n["n"];
            if (isset($_SESSION["user"])) {
                $user_id = User::get_id($_SESSION["user"]);
                if (Like::is_exist_user($user_id["id"], $_POST["check"])) {
                    $element[] = "+";
                } else {
                    $element[] = "-";
                }
            }
            else
                $element[] = "-";
            echo json_encode($element);
        }
        else
            require_once ROOT."/views/layouts/error.php";

    }

    public function ActionNews(){
//        if (!isset($page))
//            $page = 1;
//        $_SESSION["page"] = $page;
        $user_id = User::get_id($_SESSION["user"]);
        $notif = User::get_notification_by_id($user_id["id"])["notif"];
        $all_photo = Image::all_photos();
        $max = ceil($all_photo['num']/6);
        $avatar = User::get_photo($_SESSION["user"]);
//        if ($all_photo['num']) {
//            if ($page * 6 <= $all_photo['num']) {
//                $start = $all_photo['num'] - $page * 6;
//                $finish = 6;
//            }
//            else {
//                $start = 0 ;
//                $finish =   ($all_photo['num'] > 6)?$all_photo['num'] - ($page-1)*6 : $all_photo['num'];
//            }
//            $all_p = Image::photos_n($start, $finish);
//            $avatar = array();
//            $name = array();
//            foreach ($all_p as $value){
//                $avatar[] = User::get_photo_by_id($value['user_id'])['photo'];
//                $name[] = USER::get_login_by_id($value['user_id'])['login'];
//            }
//        }
        require_once ROOT."/views/site/main.php";
    }

    public function ActionDelete(){
        if ( isset($_POST["path"]))
        {
            $result = preg_replace("~http://".$_SERVER["HTTP_HOST"]."/(images/\d+)~", '$1', $_POST['path']);
            $avatar = User::get_photo($_SESSION["user"]);
            $files = glob('images/*');
//            echo "here";
//            echo $avatar["photo"]."<br>";
//            echo $result;
            if ($avatar["photo"] == "/".$result){
                User::sava_as("/template/img/avatars/nopic.png", $_SESSION["user"]);
            }
            foreach ($files as $file) {
                if ($file == $result) {
                    unlink($file);
                    break;
                }
            }
            Image::delete_photos($result);
        }
        else
            require_once ROOT."/views/layouts/error.php";

    }
    public function ActionComents(){
        if ( isset($_POST["image_id"]) && isset($_POST["text"]) && isset($_SESSION["user"]))
        {
            $coment = htmlspecialchars($_POST["text"]);
            $image_id = $_POST["image_id"];
            $user_id =  User::get_id($_SESSION["user"])["id"];
            $id_to = Image::get_user_by_photo($image_id)["user_id"];
            $login = User::get_login_by_id($id_to)["login"];
            $notif = User::get_notification_by_id($id_to)["notif"];
//            echo $notif;
            if ($login !== $_SESSION["user"] && $notif)
            {
                $to = User::get_email_by_id($id_to)["email"];
//                echo $to;
                $new_user = new UsersControlers();
                $new_user->Send_mail($to,"Вам хтось прокоментував фотографію на сайті Camagru VD!","Notification on site VG");
            }
            Coment::add_coment($user_id, $image_id, $coment);
        }
        else
            require_once ROOT."/views/layouts/error.php";

    }

    public function showDate($time){
        if ($time == 0)
            return "1c";
        if ($time < 60) {
            return $time.'c';
        } elseif ($time < 3600) {
            return ceil($time/60)."хв";
        } elseif ($time < 86400) {
            return ceil($time/3600)." год";
        } elseif ($time < 2592000) {
            return ceil($time/86400)." дн";
        } elseif ($time < 31104000) {
            return ceil($time/2592000)." міс";
        } elseif ($time >= 31104000) {
            return ceil($time/31104000)." рок";
        }
    }

    public function ActionComents_show(){
        if ( isset($_POST["image_id"])  && isset($_SESSION["user"]))
        {
            $image_id = $_POST["image_id"];
            $result = Coment::take_coment($image_id);
            if ($result) {
                $full = array();
                $i = 0;
                foreach ($result as $path) {
                    $ful[$i][] = $path["user_id"];
                    $ful[$i][] = $path["text"];
                    $ful[$i][] = User::get_photo_by_id($path["user_id"])["photo"];
                    $ful[$i][] = User::get_login_by_id($path["user_id"])["login"];
                    $time = time() - strftime('%s', strtotime($path["date"]));
                    $ful[$i][] = $this->showDate($time);
                    $ful[$i][] = $path["coment_id"];
                    $i++;
                }
                echo json_encode($ful);
            }
        }
        else
            require_once ROOT."/views/layouts/error.php";

    }

    public function ActionComents_last(){
        if ( isset($_POST["image_id"])  && isset($_SESSION["user"]))
        {
            $image_id = $_POST["image_id"];
           $result = Coment::take_coment_last($image_id);
            if ($result) {
                $full = array();
                    $ful[] = $result["user_id"];
                    $ful[] = $result["text"];
                    $ful[] = User::get_photo_by_id($result["user_id"])["photo"];
                    $ful[] = User::get_login_by_id($result["user_id"])["login"];
                    $time = time() - strftime('%s', strtotime($result["date"]));
                    $ful[] = $this->showDate($time);
                    $ful[] = $result["coment_id"];
                    echo json_encode($ful);
            }
        }
        else
            require_once ROOT."/views/layouts/error.php";

    }

    public function ActionComents_delete(){
        if ( isset($_POST["image_id"])  && isset($_SESSION["user"]))
        {
            $coment_id = $_POST["image_id"];
            Coment::delete_coment($coment_id);
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }
}