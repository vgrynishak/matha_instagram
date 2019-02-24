<?php
/**
 * Created by PhpStorm.
 * User: vgrynish
 * Date: 2019-01-31
 * Time: 12:51
 */

class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = include(ROOT."/config/routes.php");
    }

    private function get_Uri()
    {
        if (!empty($_SERVER['REQUEST_URI']))
            return (trim($_SERVER["REQUEST_URI"], '/'));
    }

    /**
     *Controler run
     */
    public function run()
    {
        $uri = urldecode($this->get_Uri());
        $check = 0;
//        echo $uri;
//        echo urldecode($uri);
//        if ($uri === "")
//           echo "lol";
//        print_r($this->routes);
        foreach ($this->routes as $uri_patern => $path)
        {
//            echo $uri_patern."<br>";
            if (preg_match("~^$uri_patern$~u", $uri))
            {
                $check = 1;
//                echo "HELLO";
//                echo "внутрішній шлях ".$path."<br />";
//                echo "То що шукаєм ".$uri_patern."<br />";
//                echo "то що приходить ".$uri."<br />";
                $intarnalRoute = preg_replace("~$uri_patern~u", $path, $uri);
//                echo "внутрішній шлях новий ".$intarnalRoute."<br />";
                $components = explode("/",$intarnalRoute);
                $Controlername = ucfirst(array_shift($components))."Controlers";
                $methodname = "Action".ucfirst(array_shift($components));
                $parameters = $components;
//                print_r( $parameters);
//                $Controlerfile  = ROOT."/controllers/".$Controlername.".php";
//                if (file_exists($Controlerfile))
//                    include_once($Controlerfile);
//                else
//                    die("error");
                $Controlerobject = new $Controlername();
                $result = call_user_func_array(array($Controlerobject, $methodname), $parameters);
                if ($result != NULL) {
                    break;
                }
            }
        }
//        echo $check;
        if ($check == 0){
            require_once ROOT."/views/layouts/error.php";
        }
//        die("error");
    }
}