<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-01-31
 * Time: 13:58
 */

Class UsersControlers
{
    public function ActionLogin(){
        if (isset($_POST["login"]) && isset($_POST["passwd"])) {
            $login = htmlspecialchars($_POST["login"]);
            $pas = hash('whirlpool', $_POST["passwd"]);
            if (User::is_exist_log($login)) {
                $mas = User::login($login);
                if ($mas["password"] == $pas) {
                    if ($mas["activate"] == 1) {
                        $_SESSION["user"] = $login;
//                         $_SESSION["page"] = 1;
                        echo "Sucsses";
                        return true;
                    } else {
                        echo "Ви не активували свій акаунт!";
                        return true;
                    }
                }
                else {
                    echo "Ви ввели не вірний пароль!!";
                    return false;
                }
            }
            else {
                echo "Користувача з таким іменем не знайдено!";
                return false;
            }
        }
        else {
            require_once ROOT."/views/layouts/error.php";
            return true;
        }

    }

    public function isMail_valid($mail){
        if (preg_match("/^[a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $mail))
            return true;
        return false;
    }

    public function ispas_valid($pas){
        if (preg_match("/^\S*(?=\S{7,15})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $pas))
            return true;
        return false;
    }

    public function islogin_valid($login){
        if (!preg_match("/^[A-Za-z0-9]{3,20}$/", $login))
            return false;
        return true;
    }

    public function special_Message(){
        $string = "qwertyuiopasdfghjklzxcvbnm1234567890QWERTYUIOPLKJHGFDSAZXCVBNM65";
        $i = 0;
        $message = "";
        while ($i < 50){
            $k = rand(0, strlen($string) - 1);
            $message .= $string[$k];
            $i++;
        }
        return $message;
    }

    public function special_pswd(){
        $string1 = "qwertyuiopasdfghjklzxcvbnm";
        $string2 = "QWERTYUIOPLKJHGFDSAZXCVBNM";
        $string3 = "1234567890";
        $i = 0;
        $message = "";
        $k = rand(0, strlen($string3) - 1);
        $message .= $string3[$k];
        $k = rand(0, strlen($string2) - 1);
        $message .= $string2[$k];
        while ($i < 10){
            $k = rand(0, strlen($string1) - 1);
            $message .= $string1[$k];
            $i++;
        }
        return $message;
    }

    public function Send_mail($to, $message, $subject){
        $encoding = "utf-8";

        $subject_preferences = array(
            "input-charset" => "utf-8",
            "output-charset" => "utf-8",
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );
        $header = "Content-type: text/html; charset=" . $encoding . " \r\n";
        $header .= "From: Camagru <no-reply@gmail.com> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";
        $header .= iconv_mime_encode("Subject", $subject, $subject_preferences);
        return (mail($to, $subject, $message, $header));
    }


    public function ActionRegister(){
        if (isset($_POST["login"]) && isset($_POST["email"]) && isset($_POST["passwd"])) {
            if (!User::is_exist_log($_POST["login"])) {
                if (!$this->islogin_valid($_POST["login"])) {
                    echo "Даний логін не валідний!Повторіть спробу!!";
                    return false;
                } elseif (!$this->isMail_valid($_POST["email"])) {
                    echo "Введіть коректну пошту!!";
                    return false;
                } else {
                    $url_activate = $this->special_Message();
                    $new_pas = hash('whirlpool', $_POST["passwd"]);
                    $message = "Hi, " . $_POST["login"] . "!\nPlease activate your account for" . "<a href=\"http://" . $_SERVER['HTTP_HOST'] . "/user/activate/" . $url_activate . "\">Підтведжую!</a>";
                    User::add($_POST["login"], $new_pas, $_POST["email"], $url_activate);
                    echo "succses";
                    //$mail = htmlspecialchars($_POST["email"]);
                    $this->Send_mail($_POST["email"], $message, "Registration on site VG");
                    return true;
                }
            } else {
                echo "Користувач з таким іменем існує!Введіть інше імя!";
                return false;
            }
        }
        else {
            require_once ROOT . "/views/layouts/error.php";
            return true;
        }
    }

    public function ActionActivate($url_special){
        if (User::is_exist_url($url_special)){
           $result = User::is_activate($url_special);
            if ($result[0]["activate"] == 1) {
                echo "Ви вже зареєстровані!";
                header('Location: /');
            }
           else {
               User::activate($url_special);
//               $activate = 1;
               header('Location: /');
           }
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }

    public function ActionMain($login){
        if (!User::is_exist_log($login)){
            require_once ROOT."/views/layouts/error.php";
            return false;
        }
        if (isset($_SESSION["user"])){
            $avatar = User::get_photo($login);
            $user_id = User::get_id($login);
            $all_photo = Image::all_photo($user_id["id"]);
            $notif = User::get_notification_by_id($user_id["id"])["notif"];
            require_once ROOT."/views/user/user.php";
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }
    public function ActionLogout(){
        if (isset($_SESSION["user"])){
            session_destroy();
            header('Location: /');
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }

    public function ActionChange_login(){
        if (isset($_SESSION["user"]) && isset($_POST["set"])){
            $login = htmlspecialchars($_POST["set"]);
            if (!User::is_exist_log($login)){
                if (!$this->islogin_valid($login)){
                    echo "Даний логін не валідний!Повторіть спробу!!";
                    return false;
                }
                else {
                    $login_old = $_SESSION["user"];
                    User::save_login($login_old,$login);
                    $_SESSION["user"] = $login;
                }
            }
            else
                echo "Даний логін вже існує!";
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }

    public function ActionChange_email(){
        if (isset($_SESSION["user"]) && isset($_POST["set"])){
            $email = htmlspecialchars($_POST["set"]);
            if (!$this->isMail_valid($email)){
                echo "Введіть коректну пошту!!";
                return false;
            }
            else{
                $login = $_SESSION["user"];
                User::save_new_email($email, $login);
            }
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }

    public function ActionChange_pas(){
        if (isset($_SESSION["user"]) && isset($_POST["set"])){
            if (!$this->ispas_valid($_POST["set"])){
                echo "Пароль повинен містити хочаб одну маленьку букву, одну велику і цифру!!!";
                return false;
            }
            else{
                $new_pas = hash('whirlpool', $_POST["set"]);
                $login = $_SESSION["user"];
                User::save_new_pas($new_pas, $login);
            }
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }

    public function ActionChange_notif(){
        if (isset($_SESSION["user"]) && isset($_POST["set"])){
                $notif = $_POST["set"];
                $login = $_SESSION["user"];
                User::save_new_notif($notif, $login);
        }
        else
            echo "error;";
    }

    public function ActionFoget_pswd(){
        if (isset($_POST["login"]) && isset($_POST["email"])){
            $login = $_POST["login"];
            $email = $_POST["email"];
            if (User::is_exist_log($login)){
                $email_user = User::get_email_by_login($login)["email"];
                if ($email == $email_user){
                    $new_pswd = $this->special_pswd();
                    $message = "Ваш логін:".$login.PHP_EOL."Ваш новий пароль:".$new_pswd.PHP_EOL;
                    User::save_new_pas(hash('whirlpool',$new_pswd), $login);
                    $this->Send_mail($email, $message, "reset_pswd");
                }
                else {
                    echo "Користувач ".$login." має іншу пошту!";
                }
//                if (!$this->islogin_valid($login)){
//                    echo "Даний логін не валідний!Повторіть спробу!!";
//                    return false;
//                }
//                else {
//                    $login_old = $_SESSION["user"];
//                    User::save_login($login_old,$login);
//                    $_SESSION["user"] = $login;
//                }
            }
            else
                echo "Користувача з таким логіном не знайдено!!";
        }
        else
            require_once ROOT."/views/layouts/error.php";
    }

    public function ActionAuthfb(){
       if (!$_GET["code"]){
           require_once ROOT."/views/layouts/error.php";
       }
       $token = json_decode(file_get_contents('https://graph.facebook.com/v3.2/oauth/access_token?client_id='.ID.'&redirect_uri='.URL.'&client_secret='.SECRET.'&code='.$_GET['code']), true);
       if (!$token){
           require_once ROOT."/views/layouts/error.php";
       }
       $data = json_decode(file_get_contents('https://graph.facebook.com/v3.2/me?client_id='.ID.'&redirect_uri='.URL.'&client_secret='.SECRET.'&code='.$_GET['code'].'&access_token='.$token['access_token'].'&fields=id,name,email'), true);
        if (!$data){
            require_once ROOT."/views/layouts/error.php";
        }
//    echo $data["name"];
        $name = explode(' ', $data["name"]);
//        print_r($name);
        if (!(User::is_exist_log($name[0])))
            User::add_by_fb($name[0], $data["email"]);
        $_SESSION["user"] = $name[0];
        header('Location: /news/');
//        var_dump($data);
    }
}