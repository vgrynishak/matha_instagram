
<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-02-06
 * Time: 12:56
 */

require_once (ROOT."/views/layouts/header.php");
?>
<!--<div class="main">-->
<div class="file_upload">
    <form class="hide">
        <input type="file" id="file" name="file" value="Виберіть файл" accept=".jpg, .jpeg, .png">
        <input id="takes">
<!--        <button id="takes">Показати камеру!</button>-->
    </form>
    <label for="file">Вибрати картинку!</label>
    <label for="takes">Зробити Фотографію!</label>
</div>
<div class="container-photo">
    <div class="menu"><button id="back" type="button" class="btn btn-warning">Повернутися назад!</button></div>
    <div class="video-cont"><video  id="video"></video></div>
<!--    <div id="btn-photo"><button id="take">Зробити фото!</button></div>-->
    <div id="btn-photo"> <button id="take" type="button" class="btn btn-success">Зробити фото!</button></div>
</div>

<div class="cont">
    <div class="menu_two">
        <label for="file">Вибрати картинку!</label>
        <label for="takes">Зробити Фотографію!</label>
    </div>
    <div class="all_worplaces">
        <div id="slider">
            <div style="display: inline-flex"><a class="prev" onclick="plusSlides(-1)">&#10094</a></div>
            <div id="polosa">
                <div class="form-check">
                    <img  id="pic1" src="/stickers/1.png">
                </div>
                <div class="form-check">
                    <img   id="pic2" src="https://avatanplus.com/files/resources/mid/56714f2687738151aa9d2e9b.png">
                </div>
                <div class="form-check" >
                    <img  id="pic3"  src="https://stickeroid.com/uploads/pic/fx0n217l-full/86b7eaa08a4b36416a85039e87b9f074300982be.png">
                </div>
                <div class="form-check" >
                    <img  id="pic4" src="https://pngimage.net/wp-content/uploads/2018/06/%D0%BA%D0%BE%D1%82%D1%8B-png-2.png">
                </div>
                <div class="form-check" >
                    <img  id="pic5"  src="http://pngimg.com/uploads/hat/hat_PNG5700.png">
                </div>
                <div class="form-check" >
                   <img  id="pic6" src="http://pngimg.com/uploads/cigarette/cigarette_PNG4768.png">
                </div>
                <div class="form-check" >
                    <img  id="pic7"  src="http://fotodryg.ru/clipart/1/3/6.png">
                </div>
                <div class="form-check" >
                    <img  id="pic8"  src="https://avatanplus.com/files/resources/mid/5756ce96824e11552b16fc06.png">
                </div>
                <div class="form-check" >
                   <img  id="pic9"  src="https://pngimage.net/wp-content/uploads/2018/06/%D1%81%D0%B8%D0%B3%D0%B0%D1%80%D0%B5%D1%82%D0%B0-mlg-png-3.png">
                </div>
                <div class="form-check" >
                    <img  id="pic10"  src="https://avatanplus.com/files/resources/mid/5744009e1db8b154e1a269aa.png">
                </div>
            </div>
            <div style="display: inline-flex"><a class="next" onclick="plusSlides(1)">&#10095</a></div>
            <div id="insert" style="position:relative"></div>
            </div>
        <div id="camera-result"></div>
        <div class="btn-save">
            <button id="save" type="button" class="btn btn-outline-success" disabled  >Зберегти</button>
            <button id="save-as" class="btn btn-outline-success" disabled >Поставити на аватарку!</button>
            <button id="delete" class="btn btn-outline-danger">Видалити всі стікери</button>
        </div>
    </div>
</div>

<canvas id="canvas" data-id="0"></canvas>
<div id="lololo"></div>
<!--</div>-->
    <script src="/template/js/photos.js"></script>
<?php
require_once (ROOT."/views/layouts/footer.php");