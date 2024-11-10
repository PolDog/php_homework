<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Models\SiteInfo;
use Geekbrains\Application1\Render;

class InfoController
{
    public function actionIndex()
    {
        $info = (new SiteInfo)->getInfo();
        $render = new Render();
        return $render->renderPage('info.twig', [
            'web_srv' => $info['SERVER_SOFTWARE'],
            'php_info' => $info['PHP_VERSION'],
            'user_br' => $info['HTTP_USER_AGENT'],
            'title' => 'System info'
        ]);
    }
}
