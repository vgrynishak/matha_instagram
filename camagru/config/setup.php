<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-01-31
 * Time: 17:12
 */

function create_database(){
    global $DB_DSNF;
    global $DB_USER;
    global $DB_PASSWORD;
    global $DB_NAME;
    try {
        $mysql = new PDO($DB_DSNF, $DB_USER, $DB_PASSWORD);
        $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $mysql->query("SHOW DATABASES LIKE 'camagru';");
        $new = $result->fetchAll(PDO::FETCH_ASSOC);
//        if (count($new) === 0)
        Db::create_db();
    }
    catch (PDOException $ex)
    {
        die("Fail connection ".$ex->getMessage().PHP_EOL);
    }
}
