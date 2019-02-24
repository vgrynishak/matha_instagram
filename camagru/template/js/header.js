function click_me() {

     var x = document.getElementById("myTopnav");
     console.log(x.className);
    if(x.className === "topnav"){
        x.className +=" display";
    }
    else {
        x.className = "topnav";
    }
}

var reg = document.getElementById("myModal");
var btn = document.getElementById("myBtn");

var log = document.getElementById("login");
var content = document.getElementById("modal_login");
var login_input = document.getElementsByClassName('login_input')[0];
var foget_input = document.getElementsByClassName('foget_input')[0];
var error_msg_login  = document.getElementsByClassName('error_msg_login')[0];

if (log) {
    log.onclick = function () {
        content.style.display = "block";
        login_input.style.display = "block";
        foget_input.style.display = "none";
    };
}

if (btn) {
    btn.onclick = function () {
        reg.style.display = "block";
    };

}



window.onclick =function(event) {
    if (event.target == reg) {
        reg.style.display = "none";
    }
    if (event.target == content)
        content.style.display = "none";
    var el = event.target;
    if (el.className == "error_alert"){
        alert_error.style.display = "none";
    }
};

function showError(container, msg) {
    var news = document.createElement('div');
    news.className = "error-message";
    news.innerHTML = msg;
    news.style.color = "red";
    container.insertBefore(news, container.firstChild);
}

function ft_clear(container) {
    if (container.firstChild) {
        if (container.firstChild.className == "error-message")
            container.removeChild(container.firstChild);
    }
}


function validate(form) {

    var element = form.elements;
    var error = 1;

    ft_clear(element.login.parentNode);
    if (!element.login.value) {
        showError(element.login.parentNode, " Ви не ввели логін!!");
        error = 0;
    }
    ft_clear(element.passwd.parentNode);
    if (!element.passwd.value){
        showError(element.passwd.parentNode, "Ви не ввели пароль!!");
        error = 0;
    }
    else if (element.passwd.value.length <= 6){
        showError(element.passwd.parentNode, "Пароль занадто короткий!!");
        error = 0;
    }
    else if (element.passwd.value !== element.passwd2.value){
        showError(element.passwd.parentNode, "Паролі не співпадають");
        error = 0;
        }

    ft_clear(element.email.parentNode);
    if (!element.email.value){
        showError(element.email.parentNode, "Ви не ввели електронну пошту!!");
        error = 0;
    }

    if (error === 1) {
        check_on_server(element);
    }
}

function clear_value(container) {
    for (var i = 0; i < container.length - 1; i++){
        container[i].value = "";
    }
}

function coder(element) {
    var body = "";
    for (var i = 0;i < element.length - 1; i++)
    {
        body += (i == 0)? (element[i].name + "=" + encodeURIComponent(element[i].value)): ( "&"+ element[i].name + "=" + encodeURIComponent(element[i].value));
    }
    return body;
}


function check_on_server(element) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/register", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200){
            if (xhr.responseText === "succses") {
                clear_value(element);
                open_new();
            }
            else {
                showError(element.login.parentNode, xhr.responseText);
            }
        }
    };
    body = coder(element);
    xhr.send(body);

}

var nice_alert = document.getElementsByClassName('nice_alert')[0];

function open_new() {
    reg.style.display = "none";
    nice_alert.style.display = "block";
    setTimeout(function () {
        nice_alert.style.display = "none";
    },2000)
}

function log_in(form) {
    element = form.elements;
    ft_clear(error_msg_login);
    // ft_clear(element.passwd.parentNode);
    var xhr = new XMLHttpRequest();
    xhr.open("POST","/login", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200)
        {
            if (xhr.responseText == "Sucsses")
                window.location.href="/news";
            else {
                console.log(error_msg_login);
                showError(error_msg_login, xhr.responseText);
            }
        }
    };
    body = coder(element);
    xhr.send(body);
}

var login_input = document.getElementsByClassName('login_input')[0];

var foget_input = document.getElementsByClassName('foget_input')[0];

function reset_passwd() {
    login_input.style.display = "none";
    foget_input.style.display = "block";
}

if (document.getElementById('back_to_login')) {
    document.getElementById('back_to_login').onclick = function () {
        login_input.style.display = "block";
        foget_input.style.display = "none";
    };
}

var nice_msg_reset = document.getElementsByClassName('nice_msg_reset')[0];


function shownice_alert(container, msg) {
    var news = document.createElement('div');
    news.className = "message_reset_pswd";
    news.innerHTML = msg;
    news.style.color = "green";
    container.insertBefore(news, container.firstChild);
    setTimeout(function () {
        container.firstChild.remove();
    },2000)
}

function change_set_imp(body, where, msg_succses) {
    var xhr = new XMLHttpRequest();

    xhr.open('POST', where, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText);
            if (xhr.responseText){
                showError(foget_error, xhr.responseText);
            }
            else {
                login_input.style.display = "block";
                foget_input.style.display = "none";
                shownice_alert(nice_msg_reset, msg_succses);
                // if (where == "/change/login")
                // document.getElementById('show_ok').style.display = "block";
            }
        }
    };
    xhr.send(body);
}

foget_error = document.getElementsByClassName('foget_error')[0];

function foget_pswd(login, email) {
    ft_clear(foget_error);
    if (!login || !email){
        showError(foget_error, "Заповніть всі поля!");
    }
    else {
        var body = "login="+encodeURIComponent(login) + "&email="+encodeURIComponent(email);
        change_set_imp(body, "/foget/pswd", "Новий пароль було надіслано на вашу пошту!");

    }
}

var forma = document.getElementById('search');

if (forma) {

    forma[0].addEventListener('input', function () {
        forma[0].style.color = "#495057";
    });

    forma[1].addEventListener('click', function () {

        // ft_clear(results);
        var login = forma[0].value;
        console.log(login);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "/search", true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText == '-') {
                    forma[0].style.color = "red";
                } else {
                    // console.log(xhr.responseText);
                    window.location.href = "/selinfo/"+login;
                }
                //console.log(xhr.responseText);
                //console.log(xhr.responseText);
            }
        };
        xhr.send('login=' + login);
    });
}