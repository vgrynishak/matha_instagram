<?php
require_once (ROOT."/views/layouts/header.php");

?>
    <div class="ful-img">
        <div class="ful-img-content">
            <div>
                <?php if ($_SESSION["user"] == $login):?>
                <a id="save_as_ava" class="btn btn-success" href="javascript:void(0); "><p1>Поставити на аву</p1></a>
                <a id="delert" class="btn btn-danger" href="javascript:void(0); "><p1>Видалити</p1></a>
                <?php endif;?>
            </div>
        </div>
    </div>
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
    <div class="last">
        <div class="login"> <p1><?php if($_SESSION["user"] == $login) echo " Мій Альбом"; else echo "Альбом ".$login;?></p1></div>
            <?php
            if (!$all_photo['num']){
                if ($_SESSION["user"] == $login) {
                    ?>
                    <div class="none_photo"><p1> У вас поки що немає фоток!</p1></div><?php
                }
                else {
                    ?>
                    <div class="none_photo"><p1> У користувача ще немає фоток!</p1></div>
                    <?php
                }
            }
            else {
                $i = 0;

                while ($i < count($all_p)) {
                    ?>
                    <div id="<?php echo $all_p[$i]["image_id"]?>"  class="last-img">
                        <!--                                --><?php //echo $all_p[$i]['path']; ?>
                        <img  alt="Responsive image" class="img-fluid rounded float-right"  src="<?php echo '/'.$all_p[$i]['path'] ?>">
                        <div class="hearts" >
                            <i class="fa fa-comment-o" aria-hidden="true"></i>
                            <i id="<?php echo $all_p[$i]["image_id"]?>" class=" fa fa-heart" aria-hidden="true"></i>
                        </div>
                    </div>
                    <?php
                    $i++;
                }
            }
            ?>
        <?php
            if ($all_photo["num"]){
        ?>
            <div class="arrows">
                <a href=<?php if ($_SESSION["page"] > 1)echo $_SESSION["page"] - 1; else echo "javascript:void(0);";?>> <i id="i-f"  class="icons fa fa-arrow-left" aria-hidden="true"></i></a>
                <a href="<?php if ($_SESSION["page"] < $max) echo $_SESSION["page"] + 1; else echo "javascript:void(0);";?>"><i id="i-s" class="icons fa fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        <?php } ?>
    </div>
        <script src="/template/js/albom.js"></script>
<?php
require_once (ROOT."/views/layouts/footer.php");