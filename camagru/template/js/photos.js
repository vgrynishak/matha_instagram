var btn_photo = document.getElementById('btn-photo');
navigator.mediaDevices.getUserMedia({video:true,audio:false}).then(function(stream){
    video.srcObject=stream;
    video.play();
        setTimeout(function () {
            btn_photo.style.display = "block";
        }, 500);
        // btn_photo.style.display = "block";
}).catch(function(er){alert(er.message);});

// function alert_er(msg){
//     var elem = document.createElement('div');
//     elem.className = "alert alert-danger";
//     elem.role = "alert";
//     elem.style.color = "red";
//     elem.innerText = msg;
//     file_upload.style.display = "block";
//     workplace.style.display = "none";
//     container.style.display = "none";
//     file_upload.insertBefore(elem, file_upload.firstChild);
//     setTimeout(function () {
//         file_upload.firstChild.remove();
//     }, 4000)
// }


var video = document.getElementById("video");
var canvas  = document.getElementById('canvas');
var ctx = canvas.getContext('2d');
var take_photo = document.getElementById('take');
var saves = document.getElementById('save');
var saves_as = document.getElementById('save-as');
var show = document.getElementById('takes');
var del = document.getElementById('delete');
var workplace = document.getElementsByClassName('cont')[0];
var back_gr = document.getElementById('camera-result');
var polosa = document.getElementById('polosa');
var ctx = canvas.getContext("2d");
var stick = document.getElementsByClassName('sticker');
var container = document.getElementsByClassName('container-photo')[0];
var file_upload = document.getElementsByClassName('file_upload')[0];
var back = document.getElementById('back');

back.onclick = function () {
    file_upload.style.display = "block";
    workplace.style.display = "none";
    container.style.display = "none";
};
function clear(){
     console.log(back_gr);
    while (back_gr.firstChild) {
        back_gr.removeChild(back_gr.firstChild);
    }
   // console.log(back_gr);
}

var w = window.innerWidth;
// canvas.width = back_gr.clientWidth;
// canvas.height = back_gr.clientHeight;

console.dir(window.innerWidth);
if (w <= 500){
    console.log("here");
    canvas.width = 250;
    canvas.height = 250;
}
else if (w>=500 ){
    canvas.width = 500;
    canvas.height = 500;
}
// else  {
//     canvas.width = 800;
//     canvas.height = 600;
// }
//

del.onclick = function(){
     console.dir(back_gr);
    for (var i = 0; i < back_gr.childElementCount; i++)
    {
        if (back_gr.children[i].className == 'sticker'){
              back_gr.children[i].remove();
              i = 0;
        }
    }
    saves.disabled = true;
    saves_as.disabled = true;
};

show.onclick = function(){
    console.log(back_gr);
    saves.disabled = true;
    saves_as.disabled = true;
    file_upload.style.display = "none";
    workplace.style.display = "none";
    container.style.display = "block";
};

polosa.onclick = function(event){
    var target = event.target;
    if (target.src) {
         saves.disabled = false;
         saves_as.disabled = false;
        //console.log(saves);
        var new_stick = document.createElement('img');
        new_stick.id = target.id;
        new_stick.src = target.src;
        new_stick.style.position = 'absolute';
        new_stick.style.left = '0';
        new_stick.style.top = '0';
        new_stick.style.width = target.clientWidth + 'px';
        new_stick.style.height = target.clientHeight + 'px';
        new_stick.style.zIndex = '1';
        new_stick.className = "sticker";
        back_gr.appendChild(new_stick);
}
};

take_photo.addEventListener('click', function () {
    // add_photo(video);
    workplace.style.display = "block";
    container.style.display = "none";
     console.dir(canvas);

    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    var image = canvas.toDataURL('image.png');
    clear();
    var back = document.createElement('img');
    back.src = image;
    back.id = 'background-image';
    back.style.position = 'absolute';
    back.style.left = '0';
    back.style.top = '0';
     // document.getElementById('insert').appendChild(back);
    back_gr.appendChild(back);

});


console.log(document.getElementById('slider').offsetTop);
console.log(back_gr.offsetTop);

var DragManager = new function() {

    /**
     * составной объект для хранения информации о переносе:
     * {
     *   elem - элемент, на котором была зажата мышь
     *   avatar - аватар
     *   downX/downY - координаты, на которых был mousedown
     *   shiftX/shiftY - относительный сдвиг курсора от угла элемента
     * }
     */
    var dragObject = {};

    var self = this;

    function onMouseDown(e) {

        if (e.which != 1) return;

        var elem = e.target.closest('.sticker');
        if (!elem) return;

        dragObject.elem = elem;

        // запомним, что элемент нажат на текущих координатах pageX/pageY
        dragObject.downX = e.pageX;
        dragObject.downY = e.pageY;

        return false;
    }

    function onMouseMove(e) {
        if (!dragObject.elem) return; // элемент не зажат

        if (!dragObject.avatar) { // если перенос не начат...
            var moveX = e.pageX - dragObject.downX;
            var moveY = e.pageY - dragObject.downY;

            // если мышь передвинулась в нажатом состоянии недостаточно далеко
            if (Math.abs(moveX) < 3 && Math.abs(moveY) < 3) {
                return;
            }

            // начинаем перенос
            dragObject.avatar = createAvatar(e); // создать аватар
            if (!dragObject.avatar) { // отмена переноса, нельзя "захватить" за эту часть элемента
                dragObject = {};
                return;
            }

            // аватар создан успешно
            // создать вспомогательные свойства shiftX/shiftY
            var coords = getCoords(dragObject.avatar);
           // alert(coords.top);
            //alert(coords.left);
            dragObject.shiftX = dragObject.downX - coords.left;
            dragObject.shiftY = dragObject.downY - coords.top;
            startDrag(e); // отобразить начало переноса
        }

        // отобразить перенос объекта при каждом движении мыши
        dragObject.avatar.style.left = e.pageX - back_gr.offsetLeft -dragObject.shiftX + 'px';
        dragObject.avatar.style.top = e.pageY - back_gr.offsetTop  -dragObject.shiftY + 'px';

        return false;
    }

    function onMouseUp(e) {
        if (dragObject.avatar) { // если перенос идет
            finishDrag(e);
        }

        // перенос либо не начинался, либо завершился
        // в любом случае очистим "состояние переноса" dragObject
        dragObject = {};
    }

    function finishDrag(e) {
        var dropElem = findDroppable(e);

        //console.log(dropElem);
        if (!dropElem) {
            self.onDragCancel(dragObject);
        } else {
            self.onDragEnd(dragObject, dropElem);
        }
    }

    function createAvatar(e) {

        // запомнить старые свойства, чтобы вернуться к ним при отмене переноса
        var avatar = dragObject.elem;
        var old = {
            parent: avatar.parentNode,
            nextSibling: avatar.nextSibling,
            position: avatar.position || '',
            left: avatar.left || '',
            top: avatar.top || '',
            zIndex: avatar.zIndex || ''
        };

        avatar.rollback = function() {

            avatar.style.position = 'absolute';
            avatar.style.left = '0';
            avatar.style.top = '0';
            avatar.style.zIndex = '1';
            back_gr.appendChild(avatar);
        };

        return avatar;
    }

    function startDrag(e) {
        var avatar = dragObject.avatar;

        // инициировать начало переноса
        back_gr.appendChild(avatar);
        avatar.style.zIndex = 9999;
        avatar.style.position = 'absolute';
    }

    function findDroppable(event) {
        // спрячем переносимый элемент
        dragObject.avatar.hidden = true;

        // получить самый вложенный элемент под курсором мыши
        var elem = document.elementFromPoint(event.clientX, event.clientY);

        //console.log(elem);

        // показать переносимый элемент обратно
        dragObject.avatar.hidden = false;

        if (elem == null) {
            // такое возможно, если курсор мыши "вылетел" за границу окна
            return null;
        }

        return elem.closest('#background-image');
    }

    document.onmousemove = onMouseMove;
    document.onmouseup = onMouseUp;
    document.onmousedown = onMouseDown;

    this.onDragEnd = function(dragObject, dropElem) {};
    this.onDragCancel = function(dragObject) {};

};


function getCoords(elem) { // кроме IE8-
    var box = elem.getBoundingClientRect();

    return {
        top: box.top + pageYOffset,
        left: box.left + pageXOffset
    };

}



DragManager.onDragCancel = function(dragObject) {
    // откат переноса
    dragObject.avatar.rollback();
};


function cooder(){
    var i = 0;
    var stick = document.getElementsByClassName('sticker');
    var bakend = document.getElementById('background-image');

    var img = canvas.toDataURL('image/png').replace('data:image/png;base64,', '');
    var body = 'back-img=' + img + '&back-left=' + bakend.style.left  + '&back-top=' + bakend.style.top +'&back-width=' + bakend.style.width  + '&back-height=' + bakend.style.height;
    while(i < stick.length)
    {
        body +=  '&src'+ i + '=' + stick.item(i).src  + '&width'+ i + '=' + stick.item(i).style.width + '&height'+ i + '=' + stick.item(i).style.height + '&top'+ i + '=' + stick.item(i).style.top + '&left'+ i + '=' + stick.item(i).style.left;
        i++;
    }
    body+= '&num=' + i;
    return body;
}

function alert(msg){
    var elem = document.createElement('div');
    elem.className = "success-nice";
    elem.role = "alert";
    elem.innerText = msg;
    file_upload.style.display = "block";
    workplace.style.display = "none";
    container.style.display = "none";
    file_upload.insertBefore(elem, file_upload.firstChild);
    setTimeout(function () {
        file_upload.firstChild.remove();
    }, 2000)
}

saves_as.addEventListener('click', function () {
    var body;
    body = cooder();
    body+= "&lol=" + '2' ;
    var xhr = new XMLHttpRequest();
    xhr.open("POST","/save", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200)
            alert("Аватар успішно змінено!");
            console.log(xhr.responseText);
    };
    xhr.send(body);
});


saves.addEventListener('click',function () {
    var body;
    body = cooder();
    var xhr = new XMLHttpRequest();
    xhr.open("POST","/save", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200)
            alert("Ваша фотографія успішно збережена!");
            console.log(xhr.responseText);
    };
    xhr.send(body);
});



var slides = document.getElementsByClassName('form-check');
var parent_slides = slides[0].parentNode;

var slideIndex = 1;

showSlides(slideIndex);
function plusSlides(n) {
    if (n === 1){
        parent_slides.insertBefore(slides[slides.length - 1], parent_slides.firstChild);
    }
    if (n === -1 ){
        parent_slides.appendChild(slides[0]);
    }
    showSlides();
}


function showSlides(){
    slides = document.getElementsByClassName('form-check');
    for (var i = 0; i < slides.length; i++)
        slides[i].style.display = "none";
    var k = 0;
    while (k < 4){
        slides[k].style.display = "inline-block";
        k++;
    }
}


window.onload = function() {
    var file = document.getElementById('file');
    file.addEventListener('change', handleFiles);
};

function handleFiles(e) {
    //var ctx = document.getElementById('canvas').getContext('2d');
    var url = URL.createObjectURL(e.target.files[0]);
    var img = new Image();
    img.onload = function() {
        workplace.style.display = "block";
        container.style.display = "none";
        file_upload.style.display = "none";
        ctx.drawImage(img, 0, 0,500,500);
        var image = canvas.toDataURL('image.png');
        clear();
        var back = document.createElement('img');
        back.src = image;
        back.id = 'background-image';
        back.style.position = 'relative';
        back.style.left = '0';
        back.style.top = '0';

        back_gr.appendChild(back);
    };
    img.src = url;
}