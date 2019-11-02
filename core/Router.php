<?php


namespace core;

use \Error;


/**
 * Роутер приложения
 *
 *
 * @package core
 */
class Router
{
    private $arrRoutes;

    /**
     * Router constructor.
     */
    function __construct()
    {


        //кодировка. задается втч для корректной работы регулярок на русском
        mb_regex_encoding(UTF8);

        date_default_timezone_set('Europe/Moscow');

        $this->arrRoutes        = require('../config/routes.php');

    }



    public function run()
    {

            if (!isset($_SERVER)) throw new Error();

            $serverRequestMethod = $_SERVER['REQUEST_METHOD'] ?? '';


            //число параметров комндной строки, должно быть равно нулю
            if ($this->getArgc()) throw new Error();

            $routeName = null;
            if ($serverRequestMethod === 'GET') {
                $routeType = 'get';

                //у нас GET запрос

                session_start();

                $routeName = $this->getRouteNameFrom_GET_request();


            } elseif ($serverRequestMethod === 'POST') {
                //  у нас POST запрос
                $routeType = 'post';

                session_start();

                $routeName = $this->getRouteNameFrom_POST_request();
            }
            else {
                //неизвестный тип обработчика
                throw new Error();
            }



            logout("routeType $routeType,routeName $routeName ");

            //ищем путь
            $finded = null;

            if (empty($routeType) || empty($routeName)) throw new Error();

            global_setRouteType($routeType);

            foreach ($this->arrRoutes as $key => $arrRoute) {

                logout("foreach, ${arrRoute['type']}, $routeType, ${arrRoute['routeName']}, $routeName");

                if ($arrRoute['type'] === $routeType && $arrRoute['routeName'] === $routeName) {
                    $finded = 1;
                    break;
                }
            }
            if (!$finded) throw new Error();


            $controllerClass = '\\controllers\\' . $arrRoute['Controller'];
            $controller = new $controllerClass();

            $funcName = $arrRoute['func'];

            $controller->$funcName();

    }


    /**
     * возвращает количесвто параметров командоной строки при вызове скрипта от linux
     * если параметров нет вернет 0
     * если вызов не от linux то вернем 0
     *
     *
     *  * @return int
     */
    private function getArgc()
    {
        return (int)(($_SERVER['argc']) ?? 0);
    }

    private function getRouteNameFrom_GET_request()
    {
        $routeName = null;

        if (!isset($_SERVER['REQUEST_URI'])) throw new Error();

        $len = strlen($_SERVER['REQUEST_URI']);
        if ($len < 1 || $len > MAX_STRLEN) return 0;

        $url        = $_SERVER['REQUEST_URI'];

        if ($url === '/') {
            //вариант когда адрес сотоит только из слеша (главная страница)
            $routeName = 'index';
        }
        else {
            //вариант GET без парметров
            $mask = "#^(/([A-z][A-z\d\-_]*))$#";
            if (preg_match($mask, $url, $arrMatches)) {
                $routeName = $arrMatches[2];
            }
        }

        if (is_null($routeName)) throw new Error;

        return $routeName;
    }

    private function getRouteNameFrom_POST_request()
    {
        $routeName = null;

        if ($_SERVER['REQUEST_URI'] !== '/index.php') throw new Error($_SERVER['REQUEST_URI']);

        if (!isset($_POST['routeName'])) throw new Error();

        $len = strlen($_POST['routeName']);
        if ($len < 2 || $len > MAX_STRLEN) throw new Error();

        return $_POST['routeName'];
    }
}
