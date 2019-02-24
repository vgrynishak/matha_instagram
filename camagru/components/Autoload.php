<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-01-31
 * Time: 16:04
 */

spl_autoload_register(function ($class_name){
   $tmp = array(
       '/components/',
       '/controllers/',
       '/models/',
   );
   foreach ($tmp as $path)
   {
       $path = ROOT.$path.$class_name.".php";
       if (is_file($path)){
           require_once $path;
       }
   }
});