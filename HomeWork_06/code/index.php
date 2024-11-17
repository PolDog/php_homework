<?php


require_once(__DIR__ . '/vendor/autoload.php');
use Geekbrains\Application1\Application;
// use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Render;

try{
    $app = new Application();
    echo $app->run();
}
catch(Exception $e){
    echo Render::renderExceptionPage($e);
}