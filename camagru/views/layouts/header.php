<?php
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" content="text/html">
        <meta name="viewport" content="width=device-width, initial-scale = 1">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"-->
<!--              integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
<!---->
<!
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"-->
<!--              integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css"
              integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
        <link href="/template/css/header.css" rel="stylesheet" type="text/css">
        <link href="/template/css/footer.css" rel="stylesheet" type="text/css">
        <link href="/template/css/main.css" rel="stylesheet" type="text/css">
        <link href="/template/css/photos.css" rel="stylesheet" type="text/css">
        <link href="/template/css/user.css" rel="stylesheet" type="text/css">
        <link href="/template/css/albom.css" rel="stylesheet" type="text/css">
        <link href="/template/css/news.css" rel="stylesheet" type="text/css">
        <link href="/template/css/css/font-awesome.css" rel="stylesheet" type="text/css">
        <title>Camagru</title>
</head>
    <body>
    <div class="nice_alert">
        <div class="alert alert-success" role="alert">
            Ви успішно зареєструвались!Перейдіть на пошту і активуйте акаунт!
        </div>
    </div>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
<!--            <div class="container-fluid">-->
                    <a href="javascript:void(0);" class="navbar-brand">Camagru</a>
                <div class="collapse navbar-collapse" >
                        <?php if(empty($_SESSION["user"])):?>
                            <ul class="navbar-nav mr-auto " id="myTopnav">
                                 <li class="nav-item active"><a class="nav-link" href="/" >Головна</a></li>
                                <li class="nav-item "><a class="nav-link" href="/">Про нас</a></li>
                            </ul>
                            <ul class="navbar-nav ml-auto  " id="myTopnav">
                                <li  class="nav-item "class="right">
                                    <a class="nav-link" href="javascript:void(0);" id="myBtn">Реєстрація</a>
                                    <div id="myModal" class="modal">
                                        <div class="registration">
                                            <img src="https://banner2.kisspng.com/20180419/qrw/kisspng-computer-icons-button-clip-art-login-5ad8b9b51737e5.5961092515241527570951.jpg">
                                            <form method="POST" name="reg">
                                                <div class="login_"><input class="forma" type="text" name="login" required placeholder="Введіть логін" autocomplete="new_password" ></div>
                                                <div class="reg"><input class="forma" type="password" name="passwd" required placeholder="Введіть пароль" autocomplete="new_password" ></div>
                                                <div class="reg"><input class="forma" type="password" name="passwd2" required placeholder="Введіть пароль повторно" autocomplete="new_password" ></div>
                                                <div class="email"><input class="forma" type="email" name="email" required placeholder="Введіть email" autocomplete="new_password" ></div>
                                                <button class=" btn btn-primary" type="button" name="btn" onclick="validate(this.form)">Реєстрація</button><br />
                                            </form>
                                            <div class="sociality">
                                                <i class="fa fa-vk" aria-hidden="true"></i>
                                                <i class="fa fa-twitter" aria-hidden="true"></i>
                                                <i class="fa fa-slack" aria-hidden="true"></i>
                                                <a  href="https://www.facebook.com/v3.2/dialog/oauth?client_id=<?=ID?>&redirect_uri=<?=URL?>&state={{st=state123abc,ds=123456789}}&response_type=code&scope=public_profile,email"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item " ><a  class="nav-link" href="javascript:void(0);" id="login" >Вхід</a>
                                    <div id="modal_login" class="modal">
                                        <div class="modal-content">
                                            <img src="https://st.depositphotos.com/1005920/1294/i/950/depositphotos_12946417-stock-photo-login-icon.jpg">
                                                <div class="login_input">
                                                    <div class="error_msg_login"></div>
                                                    <div class="nice_msg_reset"></div>
                                                    <form>
                                                        <div class="dws-input"><input type="text" name="login" placeholder="Введіть логін" required ></div>
                                                        <div class="dws-input"><input type="password" name="passwd" placeholder="Введіть пароль" autocomplete="new_password" required ></div>
<!--                                                        <input class="dws-submit" type="button" name="btn" onclick="log_in(this.form)" value="Вхід"><br />-->
                                                        <button class=" btn btn-primary" type="button" name="btn" onclick="log_in(this.form)">Вхід</button><br />
                                                        <div class="reset_pswd"><a href="javascript:void(0);" onclick="reset_passwd();">Відновити пароль</a></div>
                                                    </form>
                                                    <div class="sociality">
                                                        <i class="fa fa-vk" aria-hidden="true"></i>
                                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                                        <i class="fa fa-slack" aria-hidden="true"></i>
                                                        <a  href="https://www.facebook.com/v3.2/dialog/oauth?client_id=<?=ID?>&redirect_uri=<?=URL?>&state={{st=state123abc,ds=123456789}}&response_type=code&scope=public_profile,email"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                                <div class="foget_input">
                                                    <div class="foget_error"></div>
                                                    <form>
                                                        <div class="form-group">
                                                            <input type="text" name="login_foget" placeholder="Введіть логін">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text"  id="email" name="email_foget"  placeholder="Введіть емейл">
                                                        </div>
                                                        <button type="button" id="back_to_login" class="btn btn-warning">Назад</button>
                                                        <button type="button" onclick="foget_pswd(this.form.login_foget.value, this.form.email_foget.value);" class="btn btn-success">Відновити пароль</button>
                                                    </form>
                                                </div>
<!--                                            <div class="sociality">-->
<!--                                                <i class="fa fa-vk" aria-hidden="true"></i>-->
<!--                                                <i class="fa fa-twitter" aria-hidden="true"></i>-->
<!--                                                <i class="fa fa-slack" aria-hidden="true"></i>-->
<!--                                                <i class="fa fa-facebook" aria-hidden="true"></i>-->
<!--                                            </div>-->
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        <?php endif; ?>
                        <?php if (isset($_SESSION["user"])):?>
                    <div class="setings">
                        <span id="notif" style="display: none"><?=$notif?></span>
                        <div class="ful-setings">
                            <div class="logoss">
                                <img src="http://s1.iconbird.com/ico/2013/9/446/w512h5121380376547MetroUIConfigure.png">
                            </div>
                            <div class="all_eror"></div>
                            <div class="all_nice"></div>
                            <form>
                                <div class="input-seting">
                                    <input name="login" type="text"  placeholder="новий логін" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button  onclick="setings_login(this.form.login.value)" type="button" class="btn btn-success">Зберегти</button>
                                    </div>
                                </div>
                                <div class="input-seting">
                                    <input name="email" type="email"  placeholder="новий емейл" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button  onclick="setings_email(this.form.email.value)" type="button" class="btn btn-success">Зберегти</button>
                                    </div>
                                </div>
<!--                                <div class="input-group">-->
                                <div class="input-setingpas">
                                    <input name="pas" type="password" placeholder="новий пароль" aria-label="First name" autocomplete="new_password" >
                                </div>
                                <div class="input-setingpas">
                                    <input name="pas2" type="password" placeholder="введіть ще раз" aria-label="Last name" autocomplete="new_password" >
                                </div>
<!--                                    <div class="input-group-prepend">-->
                                        <button  onclick="setings_pas(this.form.pas.value, this.form.pas2.value)" type="button" class="btn btn-success">Зберегти</button>
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="input-seting">
                                    <label class="l-n">Сповіщення:</label>
                                    <label class="l-set" for="of">off</label>
                                    <input name="on" id="of" type="radio" name="choose">
                                    <label class="l-set" for="on">on</label>
                                    <input name="on"  id="on" type="radio" name="choose" >
                                    <button  onclick="setings_notif(this.form.on)" type="button" class="btn btn-success">Зберегти!</button>
                                </div>

                                <div id="show_ok" style="display: none">
                                    <button  id="btn-setings" type="button" class="btn btn-success">OK</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <ul class="navbar-nav mr-auto " id="myTopnav">
                            <li class="nav-item " class="active"><a class="nav-link" href="/" >Моя сторінка</a></li>
                            <li class="nav-item "><a class="nav-link" href="/news" class="active">Новини</a></li>
                    </ul>
                    <ul class="navbar-nav ml-auto " id="myTopnav">
                            <form id="search" class="form-inline my-2 my-lg-0">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn-outline-success my-2 my-sm-0" type="button">Пошук</button>
                            </form>
                            <li class="nav-item "><a class="nav-link" id="setings" href="javascript:void(0);">Налаштування</a> </li>
                            <li class="nav-item "><a class="nav-link" href=<?php echo "/logout";?> id="login" >Вийти</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
<!--
   </div>-->
    </nav>
    </header>
    <div class="content">
<script src="/template/js/header.js"></script>
