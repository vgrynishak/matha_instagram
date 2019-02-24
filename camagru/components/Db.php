<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-01-31
 * Time: 15:07
 */

class Db
{
    /**
     *
     */
    public static function create_db()
    {
        self::create_camagru();
        $db = self::getConnection();;
        if ($db !== null){
            try
            {
                $table = file_get_contents(ROOT."/config/table.sql");
//                print_r($table);
                $db->exec($table);
                return true;
            }
            catch (PDOException $ex)
            {
                die ("Fail to create table : ".$ex->getMessage().PHP_EOL);
            }
        }
        else
            return false;
    }

    /**
     * @return bool
     */

    private static function create_camagru()
    {
        global $DB_DSNF;
        global $DB_USER;
        global $DB_PASSWORD;
        global $DB_NAME;
        try {
            $mysql = new PDO($DB_DSNF, $DB_USER, $DB_PASSWORD);
            $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $create = $mysql->prepare("CREATE DATABASE IF NOT EXISTS $DB_NAME");
            $create->execute();

        } catch (PDOException $ex) {
            die ("Failure to create database" . $ex->getMessage() . PHP_EOL);
        }
    }

//    public   function delete_db()
//    {
//
//       global $DB_NAME;
//        $db = self::getConnection();
//        //include ROOT."/config/db_params.php";
//        try
//        {
//            $db->beginTransaction();
//            $db->exec("DROP DATABASE  $DB_NAME;");
//            $db->commit();
//            return true;
//        }
//        catch (PDOException $ex)
//        {
//            $db->rollBack();
//            die("Fail to drop databases".$ex->getMessage().PHP_EOL);
//        }
//    }

    public static function getConnection()
    {
        global $DB_DSN;
        global $DB_USER;
        global $DB_PASSWORD;

        try
        {
            $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $ex)
        {
            echo ("Conection error: ". $ex->getMessage() .PHP_EOL );
            $db = NULL;
        }
        return $db;
    }
}