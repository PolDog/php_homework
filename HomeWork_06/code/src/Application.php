<?php

namespace Geekbrains\Application1;
use Exception;
use Geekbrains\Application1\Infrastructure\Config;
use Geekbrains\Application1\Infrastructure\Storage;

class Application
{

    private const APP_NAMESPACE = 'Geekbrains\Application1\Controllers\\';

    private string $controllerName;
    private string $methodName;

    public static Config $config;
    public static Storage $storage;

    // public static function config(): array
    // {
        // return Application::$config;
    // }
    public function __construct(){
        Application::$config = new Config();
        Application::$storage = new Storage();
    }

    public function run(): string
    {
        // echo"<pre>";
        // print_r($_SERVER);
        // Application::$config = parse_ini_file('config.ini', true);


        $routeArray = explode('/', $_SERVER['REQUEST_URI']);

        if (isset($routeArray[1]) && $routeArray[1] != '') {
            $controllerName = $routeArray[1];
        } else {
            $controllerName = "page";
        }

        $this->controllerName = Application::APP_NAMESPACE . ucfirst($controllerName) . "Controller";

        if (class_exists($this->controllerName)) {
            // пытаемся вызвать метод
            if (isset($routeArray[2]) && $routeArray[2] != '') {
                $methodName = $routeArray[2];
            } else {
                $methodName = "index";
            }

            $this->methodName = "action" . ucfirst($methodName);

            if (method_exists($this->controllerName, $this->methodName)) {
                $controllerInstance = new $this->controllerName();
                //$method = $this->methodName;
                //return $controllerInstance->$method();
                return call_user_func_array(
                    [$controllerInstance, $this->methodName],
                    []
                );
            } else {
                // header($_SERVER["SERVER_PROTOCOL"]." 404",true,404);
                // include("page404.html");
                // die();
                // return "Метод не существует";
                throw new Exception("Метод " .  $this->methodName . " не существует");
            }
        } else {
            // header($_SERVER["SERVER_PROTOCOL"]." 404",true,404);
            // include("page404.html");
            // die();
            // return "Класс $this->controllerName не существует";
            throw new Exception("Класс $this->controllerName не существует");
        }
    }

    // public function render(array $pageVariables) {

    // }
}
