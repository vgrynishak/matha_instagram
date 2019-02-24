var likes = document.getElementsByClassName('last-img');
var likes_two = document.getElementsByClassName('news-img');
var delert = document.getElementById('delert');
var saves_as_ava = document.getElementById('save_as_ava');
var coment = document.getElementsByClassName('comentu')[0];
var coment_area_add = document.getElementsByClassName('add_coments')[0];
var coment_area = document.getElementsByClassName('comentu-inside')[0];
var btn_coments = document.getElementById('coments');
var all_coments = document.getElementsByClassName('all_coments')[0];
var all_coments_add = document.getElementsByClassName('all_coments_add')[0];

if (coment) {
    coment.onclick = function (event) {
        // console.log(event.target);
        if (event.target.className == "comentu") {
            // ful_img_content.removeChild(ful_img_content.firstChild);
            clear();
           coment.style.display = "none";
        }

    };
}


function clear() {
    for(var i = 0; i < all_coments_add.childElementCount; i++){
        if (all_coments_add.children[i].className == "all_coments"){
            all_coments_add.removeChild(all_coments_add.children[i]);
            i--;
        }
    }
}

if (saves_as_ava) {
    saves_as_ava.addEventListener('click', function () {
        var path = ful_img_content.firstChild.src;
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/save", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // console.log(xhr.responseText);
                 // window.location.reload();
                alert_albom("Аватар успішно змінений!")
                // ful_img_content.removeChild(ful_img_content.firstChild);
                // ful_img.style.display = "none";
            }
        };
        xhr.send('save_albom=' + path);

    });
}

if (delert) {
    delert.addEventListener('click', function () {
        if (confirm("Точно видалити фотографію? Цю дію не можна буде повернути!")) {
            var path = ful_img_content.firstChild.src;
            // console.log(path);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/delete/photo", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // console.log(xhr.responseText);
                     window.location.reload();
                }
            };
            xhr.send('path=' + path);
        }
    });
}

for (var i = 0; i < likes.length;i++){
         // console.dir(likes.item(i));
     likes.item(i).children.item(1).children.item(1).addEventListener('click', function () {
         var elem = this;
          console.dir(elem);
         var xhr = new XMLHttpRequest();
         xhr.open("POST","/likes", true);
         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
         xhr.onreadystatechange = function () {
             if (xhr.readyState === 4 && xhr.status === 200) {
                  add_color();
             }
         };
         xhr.send('id='+this.id);
     });
}



function activates_btn(el) {
    if (el.value)
        btn_coments.disabled = false;
    else
        btn_coments.disabled = true;
}

var id;

if (coment_area_add) {
    coment_area_add.children[2].addEventListener('click', function () {
        var text = coment_area_add.children[1].value;
        add_to_db(text, id);
        // clear()
        coment_area_add.children[1].value = "";
        btn_coments.disabled = true;
    });
}
function show_coments_on_page_last(result) {
    // console.log(coment_area);
    //     console.log("vova"+result);
    var element = all_coments.cloneNode(true);
    element.style.display = "inline-flex";
    //console.dir(element);
    element.children[0].src = result[2];
    element.children[1].children[0].innerHTML = result[3];
    element.children[1].children[0].href = "/selinfo/"+result[3];
    element.children[2].innerHTML = result[1];
    element.children[1].children[1].innerHTML = result[4];
    // element.children[3].innerHTML = result[i][4];
    all_coments_add.appendChild(element);
    scrol_top();
    // // console.log(coment_area);
}

function show_last_coments(image_id) {
    var body = "image_id="+encodeURIComponent(image_id);
    var xhr = new XMLHttpRequest();

    xhr.open('POST', "/show_coment_last", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // console.log(xhr.responseText);
            if (xhr.responseText) {
                  // console.log(xhr.responseText);
                  var result = JSON.parse(xhr.responseText);
                 show_coments_on_page_last(result);
            }
            // console.log(result);
        }
    };
    xhr.send(body);
}

for (var i = 0; i < likes.length;i++){
    likes.item(i).children.item(1).addEventListener('click', function (event) {
        var elem = event.target;
        var element = this;
         if (elem.className == "fa fa-comment-o"){
             id = element.children[1].id;
             coment.style.display = "block";
             show_coments(id);
         }
    });
}


function show_coments_on_page(result) {
    // console.log(coment_area);
    // clear();
    for (var i = 0;i < result.length; i++) {
        // console.log(result[i]);
        var element = all_coments.cloneNode(true);
        element.style.display = "inline-flex";
        element.children[0].src = result[i][2];
        // console.dir(element.children[1]);
        element.children[1].children[0].href = "/selinfo/"+result[i][3];
        element.children[1].children[0].innerHTML = result[i][3];
        element.children[1].children[1].innerHTML = result[i][4];
        element.children[2].innerHTML = result[i][1];
        all_coments_add.insertBefore(element, all_coments_add.firstChild);
    }
    scrol_top();
}

// function delete_from_db(image_id) {
//     var body = "image_id="+encodeURIComponent(image_id);
//     var xhr = new XMLHttpRequest();
//     xhr.open('POST', "/coments/delete", true);
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200){
//             console.log(xhr.responseText);
//         }
//
//     };
//     xhr.send(body);
// }

function show_coments(image_id) {
    var body = "image_id="+encodeURIComponent(image_id);
    var xhr = new XMLHttpRequest();

    xhr.open('POST', "/show_coment", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {

            if (xhr.responseText) {
                var result = JSON.parse(xhr.responseText);
                show_coments_on_page(result);
            }
        }
    };
    xhr.send(body);
}

function add_to_db(text, image_id) {
    // console.log(text+image_id);
    var body = "text="+encodeURIComponent(text)+"&image_id="+encodeURIComponent(image_id);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "/coments", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200){
            console.log(xhr.responseText);
            show_last_coments(id);
        }

    };
    xhr.send(body);
}


 add_color();

function add_color() {
    for (var i = 0; i < likes.length;i++){
        element = likes.item(i).children.item(1).children.item(1);
        new_color(element);

    }
}



function new_color(hearts)
 {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/color", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var result  =  JSON.parse(xhr.responseText);
            if (result[1] == "+") {
                hearts.style.color = "red";
                hearts.innerText = result[0];
            }
            else{
                hearts.style.color = "white";
                if (result[0] == 0) {
                    hearts.innerText = "";
                }
                else
                    hearts.innerText = result[0];
            }
        }
    };
    xhr.send('check=' + hearts.id);
}

var ful_img = document.getElementsByClassName('ful-img')[0];
var ful_img_content = document.getElementsByClassName('ful-img-content')[0];
for (var i = 0; i < likes.length;i++){
     // console.log(likes.item(i).children.item(0));
        likes.item(i).children.item(0).addEventListener('click', function () {
        var elem = this;
        // console.log(elem);
        var clones = elem.cloneNode();
        ful_img.style.display = "block";
        // ful_img_content.remove(ful_img_content.firstChild);
        ful_img_content.insertBefore(clones, ful_img_content.firstChild);

     });
}

if (ful_img) {
    ful_img.onclick = function (event) {
        if (event.target.className == "ful-img") {
            ful_img_content.removeChild(ful_img_content.firstChild);
            ful_img.style.display = "none";
        }
    };
}

function scrol_top() {
    var diff = all_coments_add.scrollTop + all_coments_add.clientHeight;
    if (diff < all_coments_add.scrollHeight){
        all_coments_add.scrollTop += all_coments_add.scrollHeight - diff;
    }
}

var albom_my = document.getElementsByClassName('login')[0];

function alert_albom(msg){
    var elem = document.createElement('div');
    elem.className = "success_nice_update";
    elem.role = "alert";
    elem.innerText = msg;
    ful_img_content.removeChild(ful_img_content.firstChild);
    ful_img.style.display = "none";
    albom_my.appendChild(elem);
    setTimeout(function () {
        albom_my.lastChild.remove();
    }, 1500)
}