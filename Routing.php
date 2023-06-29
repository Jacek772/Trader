<?php

// Controllers
require_once "src/controllers/DefaultController.php";
require_once "src/controllers/AuthController.php";
require_once "src/controllers/DocumentsController.php";
require_once "src/controllers/ExchangesController.php";
require_once "src/controllers/WarehousesController.php";
require_once "src/controllers/ContractorsController.php";
require_once "src/controllers/CurrenciesController.php";
require_once "src/controllers/DocumentsdefinitionsController.php";
require_once "src/controllers/CommoditiesController.php";
require_once "src/controllers/VatratesController.php";
require_once "src/controllers/UnitsController.php";
require_once "src/controllers/UsersController.php";
require_once "src/controllers/RolesController.php";
require_once "src/controllers/DocumentspositionsController.php";

class Routing {
    public static $routes;

    public static function get($url, $method, $controller) {
        $key = "GET-".$url;
        self::$routes[$key] = [
            "url" => $url,
            "method" => $method,
            "httpMethod" => "GET",
            "controller" => $controller
        ];
    }

    public static function post($url, $method, $controller) {
        $key = "POST-".$url;
        self::$routes[$key] = [
            "url" => $url,
            "method" => $method,
            "httpMethod" => "POST",
            "controller" => $controller
        ];
    }

    public static function put($url, $method, $controller) {
        $key = "PUT-".$url;
        self::$routes[$key] = [
            "url" => $url,
            "method" => $method,
            "httpMethod" => "PUT",
            "controller" => $controller
        ];
    }

    public static function delete($url, $method, $controller) {
        $key = "DELETE-".$url;
        self::$routes[$key] = [
            "url" => $url,
            "method" => $method,
            "httpMethod" => "DELETE",
            "controller" => $controller
        ];
    }

    public static function run($url) {
        $httpMethod = $_SERVER["REQUEST_METHOD"];
        $route = self::getRoute($url, $httpMethod);
        if(!$route)
        {
            die("Wrong url or method!");
        }

        $controller = new $route["controller"];
        $method = $route["method"];
        $controller->$method();
    }

    private static function getRoute($url, $httpMethod)
    {
        $key = $httpMethod."-".$url;
        if(!array_key_exists($key, self::$routes))
        {
            return null;
        }
        return self::$routes[$key];
    }
}