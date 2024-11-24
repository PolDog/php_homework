<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Cont;
// use Geekbrains\Application1\Application\Controller;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Controllers\Cont as ControllersCont;

class PageController{

    public function actionIndex() {
        $render = new Render();
        
        return $render->renderPage('page-index.tpl', ['title' => 'Главная страница']);
    }
}