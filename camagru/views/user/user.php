<?php
require_once (ROOT."/views/layouts/header.php");
?>
        <div class="photo">
            <div class="name"><p1><?php echo $login;?></p1></div>
            <img src="<?php echo $avatar['photo']?>" class="rounded-circle img-fluid" alt="Responsive image">
            <div class="some-btn">
                <?php if ($_SESSION["user"] == $login){?>
                <div class="btn-photos" ><a  class="btn btn-primary" data-toggle="collapse" href="/takephoto" aria-expanded="false" aria-controls="collapseExample" title="photo">Зробити фото</a></div>
                <?php }?>
                <div class="btn-photos">  <a class="btn btn-primary" data-toggle="collapse" href="<?php echo "galary/".$login."/1"?>" aria-controls="collapseExample" title="photo" title="photo"> Альбом (<?php echo $all_photo['num'];?>)</a> </div>
            </div>
        </div>
<?php
require_once (ROOT."/views/layouts/footer.php");
