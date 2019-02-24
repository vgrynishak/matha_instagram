var max_page = document.getElementsByClassName('some_info')[1].innerHTML;
var clone_node = document.getElementsByClassName('news-img')[0];
var news_add = document.getElementsByClassName('news')[0];
var likes_two = document.getElementsByClassName('news-img');
var alert_error = document.getElementsByClassName('error_alert')[0];
var coment = document.getElementsByClassName('comentu')[0];
var coment_area_add = document.getElementsByClassName('add_coments')[0];
var coment_area = document.getElementsByClassName('comentu-inside')[0];
var btn_coments = document.getElementById('coments');
var all_coments = document.getElementsByClassName('all_coments')[0];
var users_check = document.getElementsByClassName('some_info')[0].innerHTML;
var all_coments_add = document.getElementsByClassName('all_coments_add')[0];

var id;
var pages = 1;

function clear() {
    for(var i = 0; i < all_coments_add.childElementCount; i++){
        if (all_coments_add.children[i].className == "all_coments"){
            all_coments_add.removeChild(all_coments_add.children[i]);
            i--;
        }
    }
}

if (max_page != 0){
    show_page();
}
function page_news(n) {
    console.log("here");
    if (n == -1 && pages > 1){
        pages += -1;
        show_page();
    }
    if (n == 1 && pages <max_page){
        pages += 1;
        show_page();
    }
    console.log(max_page)
}

function clear_news() {
    for(var i = 0; i < news_add.childElementCount; i++){
        if (news_add.children[i].className== "news-img"){
            news_add.removeChild(news_add.children[i]);
            i--;
        }
    }
}

function show_page() {
    // console.log(pages);
    body = "page="+encodeURIComponent(pages);
    var xhr = new XMLHttpRequest();
    xhr.open("POST","/pages", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200)
        {
            var result = JSON.parse(xhr.responseText);
            clear_news();
            try_to_show(result);
        }
    };
    xhr.send(body);
}


function go_to_profile(name) {
    if (users_check == 1) {
        window.location.href = "/selinfo/"+name;
    }
    else {
        alert_error.style.display = "block";
    }
}

function try_to_show(result) {
    for (var i = 0; i < result.length; i++){
        // console.log(result[i]);
        var new_element = clone_node.cloneNode(true);
        new_element.style.display = "inline-block";
        new_element.children[0].children[0].children[0].src = result[i]["avatar"];
        new_element.children[0].children[0].children[0].className = result[i]["name"];
        // new_element.children[0].children[0].onclick = go_to_profile(result[i]["name"]);
        new_element.children[0].children[1].children[0].innerHTML = result[i]["name"];
        new_element.children[1].src = "/"+result[i]["photo"];
        new_element.children[2].children[1].id = result[i]["image_id"];
        news_add.insertBefore(new_element, news_add.firstChild);
    }
    add_listener_my_like();
    add_color_two();
    add_listener_my_coment()
}


function new_color(hearts)
{
    // console.log(hearts);
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/color", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // console.log(xhr.responseText);
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


function add_color_two() {
    for (var i = 0; i < likes_two.length;i++){
        element = likes_two.item(i).children[2].children[1];
        new_color(element);
    }
}


function add_listener_my_like() {
    for (var i = 0; i < likes_two.length; i++) {
        // console.dir(likes_two.item(i).children[2]);
         likes_two.item(i).children[2].children[1].addEventListener('click', function () {
                 if (users_check == 1) {
                     var elem = this;
                     var xhr = new XMLHttpRequest();
                     xhr.open("POST", "/likes", true);
                     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                     xhr.onreadystatechange = function () {
                         if (xhr.readyState === 4 && xhr.status === 200) {
                             add_color_two();
                         }
                     };
                     xhr.send('id=' + this.id);
                 }
                 else {
                     alert_error.style.display = "block";
                 }
         });
    }
}

function add_listener_my_coment() {
    for (var i = 0; i < likes_two.length; i++) {
        likes_two.item(i).children[2].addEventListener('click', function () {
            var elem = event.target;
            var element = this;
            if (elem.className == "fa fa-comment-o"){
                if (users_check == 1) {
                    id = element.children[1].id;
                    coment.style.display = "block";
                    show_coments(id);
                }
                else {
                    alert_error.style.display = "block";
                }
            }
        });
    }
}

function show_coments(image_id) {
    var body = "image_id="+encodeURIComponent(image_id);
    var xhr = new XMLHttpRequest();

    xhr.open('POST', "/show_coment", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // console.log(xhr.responseText);
            if (xhr.responseText) {
                var result = JSON.parse(xhr.responseText);
                show_coments_on_page(result);
            }
            // console.log(result);
        }
    };
    xhr.send(body);
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
        // element.children[3].id = result[i][5];
        // element.children[3].onclick = function(){
        //     delete_from_db(this.id);
        //     element.remove();
        // };
        // console.log(element.children[3]);
        all_coments_add.insertBefore(element, all_coments_add.firstChild);
        // console.log(coment_area);
    }
    scrol_top();
}

coment.onclick = function (event) {
    // console.log(event.target);
    if (event.target.className == "comentu") {
        // ful_img_content.removeChild(ful_img_content.firstChild);
        clear();
        coment.style.display = "none";
    }

};

coment_area_add.children[2].addEventListener('click', function () {
    var text = coment_area_add.children[1].value;
    add_to_db(text, id);
    coment_area_add.children[1].value = "";
    btn_coments.disabled = true;
});

function add_to_db(text, image_id) {
    // console.log(text+image_id);
    var body = "text="+encodeURIComponent(text)+"&image_id="+encodeURIComponent(image_id);
    var xhr = new XMLHttpRequest();
    xhr.open('POST', "/coments", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200){
            show_last_coments(id);
        }

    };
    xhr.send(body);
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

function activates_btn(el) {
    if (el.value)
        btn_coments.disabled = false;
    else
        btn_coments.disabled = true;
}

 setInterval(function () {
    add_color_two();
}, 500);


function scrol_top() {
    // console.dir(all_coments_add);
    var diff = all_coments_add.scrollTop + all_coments_add.clientHeight;
    // console.log(diff);
    // console.log(all_coments_add.scrollHeight);
    if (diff < all_coments_add.scrollHeight){
        all_coments_add.scrollTop += all_coments_add.scrollHeight - diff;
    }
}