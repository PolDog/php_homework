<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Render;
use Geekbrains\Application1\Models\User;

class UserController {

    public function actionTestMetod(){
        return "это мой тестовый метод ( http://mysite.local/user/testmetod )";
    }

    public function actionIndex() {
        $users = User::getAllUsersFromStorage();
        // http://mysite.local/user/index/?user_info=123&birthday=05-05-1991
// var_dump($_GET);
        $userInfo=$_GET['user_info'] ?? '';

        if($userInfo!=''){
            (new User())->saveUser($_GET['user_info'],$_GET['birthday']);
        }

        $render = new Render();

        if(!$users){
            return $render->renderPage(
                'user-empty.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден"
                ]);
        }
        else{
            return $render->renderPage(
                'user-index.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users
                ]);
        }
    }
}