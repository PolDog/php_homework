<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Application;
use Geekbrains\Application1\Models\SiteInfo;
use Geekbrains\Application1\Render;

class PageController {

    public function actionIndex() {
        $render = new Render();
        // echo Application::config()['storage']['addres'];

        return $render->renderPage('page-index.twig', [
            'title' => 'Главная страница',
            'current_time' => (new SiteInfo)->getCurrentTime()
        // 'settings_patch'=>Application::config()['storage']['addres']
        ]);
    }
}