var setings = document.getElementById('setings');
var setings_div =document.getElementsByClassName('setings')[0];
var setings_inside = document.getElementsByClassName('ful-setings')[0];
var setings_of = document.getElementById('of');
var setings_on = document.getElementById('on');
var btn_seti = document.getElementById('btn-setings');
var all_error = document.getElementsByClassName('all_eror')[0];
var all_nice = document.getElementsByClassName('all_nice')[0];
var delete_ac = document.getElementById("delete_ac");


// if (delete_ac){
//     delete_ac.onclick = function () {
//         if (confirm("Ви точно хочете видалити акаунт? Цю дію не можна буде відмінити!")){
//             change_set('delete', "/change/delete", "");
//         }
//     }
// }
if (setings) {
    setings.addEventListener('click', function () {
        setings_div.style.display = "block";
        var notif =   document.getElementById('notif').innerText;
        console.log(notif);
        if (notif == 1){
            setings_on.checked = true;
            setings_of.checked = false;
        }
        else {
            console.log("here");
            setings_of.checked = true;
            setings_on.checked = false;
        }
    });
    window.onclick = function (event) {
        var el = event.target;
        if (el.className == "setings"){
            setings_div.style.display = "none";
        }
    };
    // console.dir(setings_inside);
    // console.log("here");
    // console.log(notif);
}

if (btn_seti) {
    btn_seti.addEventListener('click', function () {
        window.location.href = "/";
    });
}

// function setingss(element) {
//     if(element.login.value){
//         var login = element.login.value;
//         change_set(login, "/change/login");
//     }
//     if(element.email.value){
//         var email = element.email.value;
//         console.log(email);
//     }
//     if(element.pas.value && element.pas2.value){
//         if (element.pas.value == element.pas2.value) {
//             var pas = element.email.value;
//             console.log(pas);
//         }
//         else {
//             console.log("here");
//         }
//     }
//
// }

function shownice(container, msg) {
    var news = document.createElement('div');
    news.className = "nice-message";
    news.innerHTML = msg;
    news.style.color = "green";
    container.insertBefore(news, container.firstChild);
}
//
// function ft_clear(container) {
//     if (container.firstChild.className == "error-message")
//         container.removeChild(container.firstChild);
// }

function change_set(what, where, msg_succses) {
    var body = "set="+encodeURIComponent(what);
    var xhr = new XMLHttpRequest();

    xhr.open('POST', where, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (what == "delete"){
                window.location.href = "/";
            }
            else if (xhr.responseText){
                 showError(all_error, xhr.responseText);
            }
            else {
                 shownice(all_nice, msg_succses);
                 // if (where == "/change/login")
                    document.getElementById('show_ok').style.display = "block";
            }
        }
        };
    xhr.send(body);
}

function setings_login(login) {
    ft_clear(all_error);
    ft_clear(all_nice);
    change_set(login, "/change/login", "Ви успішно змінили логін!Для коректної роботи сторінки, після всіх змін натисніть OK");
}

function setings_email(email) {
    ft_clear(all_error);
    ft_clear(all_nice);
    change_set(email, "/change/email", "Ви успішно змінили емейл!!Для коректної роботи сторінки, після всіх змін натисніть OK");
}

function setings_pas(pas, pas1) {
    ft_clear(all_error);
    ft_clear(all_nice);
    if (pas === pas1)
        change_set(pas, "/change/paswd", "Ви успішно змінили пароль!!Для коректної роботи сторінки, після всіх змін натисніть OK");
    else
        showError(all_error, "Паролі не співпадають!")
}

function setings_notif(on) {
    ft_clear(all_error);
    ft_clear(all_nice);
    var notif;
    if (on[0].checked == true){
        notif = 0;
    }
    else if (on[1].checked == true){
        notif = 1;
    }
    change_set(notif, "/change/notif", "Ви успішно змінили сповіщення!!Для коректної роботи сторінки, після всіх змін натисніть OK");
}