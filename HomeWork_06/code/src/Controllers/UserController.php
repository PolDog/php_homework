<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Render;
use Geekbrains\Application1\Models\User;

class UserController
{

    public function actionTestMetod()
    {
        return "это мой тестовый метод ( http://mysite.local/user/testmetod )";
    }

    public function actionIndex()
    {
        $users = User::getAllUsersFromStorage();
        // http://mysite.local/user/index/?user_info=123&birthday=05-05-1991
        // var_dump($_GET);
        $userInfo = $_GET['user_info'] ?? '';

        if ($userInfo != '') {
            (new User())->saveUser($_GET['user_info'], $_GET['birthday']);
        }

        $render = new Render();

        if (!$users) {
            return $render->renderPage(
                'user-empty.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден"
                ]
            );
        } else {
            return $render->renderPage(
                'user-index.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users

                ]
            );
        }
    }
    public function actionShow()
    {
        // $id=(int)$_GET['id'] ?? 0;
        // if(isset($_POST['rename_btn'])){
        // echo ("++++++++++++++++++");
        // }
        // echo ("2");
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
        if (User::exists($id)) {
            $user = User::getUserFromStorage($id);
            //    var_dump($user);
            $render = new Render();

            return $render->renderPage(
                'user-page.twig',
                ['user' => $user]
            );
        } else {
            throw new \Exception("Пользователь не существует");
        }
    }

    public function actionUpdate(): string {
        if(User::exists($_GET['id'])) {
            $user = new User();
            $user->setUserId($_GET['id']);
            
            $arrayData = [];
            // if(isset($_GET['id']))
                // $arrayData['user_id'] = $_GET['id'];
            if(isset($_GET['name']))
                $arrayData['user_name'] = $_GET['name'];

            if(isset($_GET['lastname'])) {
                $arrayData['user_lastname'] = $_GET['lastname'];
            }
            
            $user->updateUser($arrayData,$_GET['id']);
        }
        else {
            throw new \Exception("Пользователь не существует");
        }

        $render = new Render();
        return $render->renderPage(
            'user-created.twig', 
            [
                'title' => 'Пользователь обновлен',
                'message' => "Обновлен пользователь " . $user->getUserId()
            ]);
    }
    public function actionDelete(): string {
        if(User::exists($_GET['id'])) {
            User::deleteFromStorage($_GET['id']);

            $render = new Render();
            
            return $render->renderPage(
                'user-removed.twig', []
            );
        }
        else {
            throw new \Exception("Пользователь не существует");
        }
    }
}
