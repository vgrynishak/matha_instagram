<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-01-31
 * Time: 20:26
 */

class SiteControlers
{
    public function ActionIndex(){
        // talk with DB
        // check if pass is right
        if (isset($_SESSION["user"])){
//            echo $_SESSION["user"];
            header('Location:selinfo/'.$_SESSION["user"]);
        }
        else {
            $all_photo = Image::all_photos();
            $max = ceil($all_photo['num']/6);
            require_once ROOT . "/views/site/main.php";
        }
    }

    public function ActionPage(){
        if (isset($_POST["page"])) {
            $all_photo = Image::all_photos();
            $max = ceil($all_photo['num'] / 6);
            if ($all_photo['num']) {
                if ($_POST["page"] * 6 <= $all_photo['num']) {
                    $start = $all_photo['num'] - $_POST["page"] * 6;
                    $finish = 6;
                } else {
                    $start = 0;
                    $finish = ($all_photo['num'] > 6) ? $all_photo['num'] - ($_POST["page"] - 1) * 6 : $all_photo['num'];
                }
                $all_p = Image::photos_n($start, $finish);
                $ful_info = array();
                $i = 0;
                foreach ($all_p as $value) {
                    $ful_info[$i]["photo"] = $value["path"];
                    $ful_info[$i]["avatar"] = User::get_photo_by_id($value['user_id'])['photo'];
                    $ful_info[$i]["name"] = USER::get_login_by_id($value['user_id'])['login'];
                    $ful_info[$i]["image_id"] = $value["image_id"];
                    $ful_info[$i]["user_id"] = $value["user_id"];
                    $i++;
                }
               echo json_encode($ful_info);
            }
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }
}