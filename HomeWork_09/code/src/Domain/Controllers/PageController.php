<?php

namespace Geekbrains\Application1\Domain\Controllers;
use Geekbrains\Application1\Application\Render;

class PageController {

    public function actionIndex() {
        $render = new Render();
        
        return $render->renderPage('page-index.tpl', ['title' => 'Главная страница']);
    }
    public function actionError() {
        $render = new Render();
        
        return $render->renderPage('page-error.tpl', ['title' => '404']);
    }

    public function actionTime():string {
        return json_encode(date("d-m-y H:i:s"));
    }
}