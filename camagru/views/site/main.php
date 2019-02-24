<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-01-31
 * Time: 20:30
 */
require_once (ROOT."/views/layouts/header.php");
?>
    <div class="some_info" style="display: none;"><?php if (isset($_SESSION["user"])) echo "1"; else echo "0"?></div>
    <div class="some_info" style="display: none;"><?= $max?></div>
    <div class="error_alert">
            <div class="alert alert-danger" role="alert">
                Коментувати, лайкати, і переглядати профіль можуть тільки авторизовані користувачі!
<!--                <a href="#" class="alert-link">an example link</a>. Give it a click if you like.-->
            </div>
    </div>
<!--    --><?php
//    echo $_SESSION["user"];
//    echo $avatar["photo"];
//    ?>
    <div class="comentu">
        <div class="comentu-inside">
            <div class="all_coments">
                <img   alt="Responsive image" class="rounded-circle img-fluid"  src="<?=$avatar["photo"]?>">
                <div class="date_class">
                    <a href="/selinfo/<?=$_SESSION["user"]?>"></a>
                    <div class="data_times"></div>
                </div>
                <div class="text_coment"></div>
<!--                <i class="fa fa-trash" aria-hidden="true"></i>-->
                <!--                <p1>2079</p1>-->
            </div>
            <div class="all_coments_add">

            </div>
            <div class="add_coments" id="add-coments">
                <img  alt="Responsive image" class="rounded-circle img-fluid"  src="<?=$avatar["photo"]?>">
                <!--                <form>-->
                <textarea id="text_coment" name="text" oninput="activates_btn(this)" placeholder="Введіть ваш коментар.."></textarea>
                <!--                </form>-->
                <button type="button" id="coments" class="btn btn-success" disabled>Коментувати</button>
            </div>
        </div>
    </div>
    <div class="news">
        <div  class="news-img">
            <div class="head">
                <a href="javascript:void(0);"><img class="img-fluid" alt="Responsive image" onclick="go_to_profile(this.className);" src=""></a>
                <a href="javascript:void(0);"><p1 onclick="go_to_profile(this.innerText);"></p1></a>
            </div>
            <img class="img-fluid" alt="Responsive image" src="">
            <div class="hearts-news" >
                <i class="fa fa-comment-o" aria-hidden="true"></i>
                <i  class=" fa fa-heart" aria-hidden="true"></i>
            </div>
        </div>
        <?php
        if ($all_photo["num"]){
        ?>
        <div class="arrows">
            <a href="javascript:void(0);" onclick="page_news(-1);"><i id="i-f" class="icons fa fa-arrow-left" aria-hidden="true"></i></a>
            <a href="javascript:void(0);" onclick="page_news(1);"><i id="i-s" class="icons fa fa-arrow-right" aria-hidden="true"></i></a>
        </div>
        <?php }?>
    </div>
    <script src="/template/js/main.js"></script>
<?php
require_once (ROOT."/views/layouts/footer.php");