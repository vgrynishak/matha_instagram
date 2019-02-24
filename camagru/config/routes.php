<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-01-31
 * Time: 13:09
 */
return array(
    'login' => 'users/login', //actionlogin в UsersControler
    'register' => 'users/register', //actionregister в UsersControler
    'user/activate/([a-zA-Z0-9]{50})' => 'users/activate/$1',
    'news' => 'activity/news',
    'selinfo/([A-Za-z0-9а-щА-ЩЬьЮюЯяЇїІіЄєҐґ]{3,20})' => 'users/main/$1',
    'selinfo/galary/([A-Za-z0-9а-щА-ЩЬьЮюЯяЇїІіЄєҐґ]{3,20})/([0-9]*)' => 'activity/albom/$1/$2',
    'logout' => 'users/logout',
    'show/([0-9]*)' => 'activity/show/$1',
    "takephoto" => 'activity/photo',
    'delete/photo' => 'activity/delete',
    'save' => 'activity/save',
    'search' => 'activity/search',
    'likes' => 'activity/likes',
    'coments' => 'activity/coments',
    'show_coment' => 'activity/coments_show',
    'show_coment_last' => 'activity/coments_last',
    'coments/delete' =>  'activity/coments_delete',
    'color' => 'activity/color',
    'change/login' => 'users/change_login',
    'change/email' => 'users/change_email',
    'change/paswd' => 'users/change_pas',
    'change/notif' => 'users/change_notif',
    'foget/pswd' => 'users/foget_pswd',
    'pages' => 'site/page',
    'authfb(.*)' => 'users/authfb',
    '' => 'site/index',
);