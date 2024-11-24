<?php

namespace Geekbrains\Application1\Domain\Controllers;

// use Cont;
use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Application\Auth;
use Geekbrains\Application1\Domain\Models\User;

class UserController extends AbstractController
{
    // class UserController extends Cont {

    protected array $actionsPermissions = [
        'actionHash' => ['admin'],
        'actionSave' => ['admin'],
        'actionEdit' => ['admin'],
        'actionIndex' => ['admin'],
        'actionLogout' => ['admin'],
        'actionAddUser' => ['admin'],
    ];

    public function actionIndex(): string
    {
        $users = User::getAllUsersFromStorage();

        $render = new Render();

        if (!$users) {
            return $render->renderPage(
                'user-empty.tpl',
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

    public function actionSave(): string
    {
        if (User::validateRequestData()) {
            $user = new User();
            $user->setParamsFromRequestData();
            $user->saveToStorage();

            $render = new Render();

            return $render->renderPage(
                'user-created.tpl',
                [
                    'title' => 'Пользователь создан',
                    'message' => "Создан пользователь " . $user->getUserName() . " " . $user->getUserLastName()
                ]
            );
        } else {
            throw new \Exception("Переданные данные некорректны");
        }
    }
    public function actionUpdateInfo(): string
    {

        // print_r($_SESSION);
        // echo($_POST['user_name']);
        // echo"<br>";
        // echo($_POST['user_lastname']);
        // echo"<br>";
        // echo($_POST['user_birthday']);
        // echo"<br>";
        // echo($_POST['user_id']);
        // if (User::validateRequestData()) {
        $user = new User();
        $user->setUserId($_POST['user_id']);
        $user->setName($_POST['user_name']);
        $user->setLastName($_POST['user_lastname']);
        $user->setBirthdayFromString($_POST['user_birthday']);
        $user->setUserLogin($_POST['user_name']);

        // print_r($user);
        $user->updateInfo();

        $render = new Render();

        return $render->renderPage(
            'user-created.tpl',
            [
                'title' => 'Пользователь обновлен',
                'message' => "Пользователь обновлен " . $user->getUserName() . " " . $user->getUserLastName()
            ]
        );
        // } else {
        //     throw new \Exception("Переданные данные некорректны");
        // }
        // return "ok";
    }

    public function actionEdit(): string
    {
        $render = new Render();

        return $render->renderPageWithForm(
            'user-form.tpl',
            [
                'title' => 'Форма создания пользователя'
            ]
        );
    }

    public function actionAuth(): string
    {
        $render = new Render();

        return $render->renderPageWithForm(
            'user-auth.tpl',
            [
                'title' => 'Форма логина'
            ]
        );
    }

    public function actionHash(): string
    {
        return Auth::getPasswordHash($_GET['pass_string']);
    }

    public function actionLogin(): string
    {
        $result = false;

        if (isset($_POST['login']) && isset($_POST['password'])) {
            // print_r("check");
            $result = Application::$auth->proceedAuth($_POST['login'], $_POST['password']);
        }

        if (!$result) {
            $render = new Render();

            return $render->renderPageWithForm(
                'user-auth.tpl',
                [
                    'title' => 'Форма логина',
                    'auth-success' => false,
                    'auth-error' => 'Неверные логин или пароль'
                ]
            );
        } else {
            header('Location: /');
            return "";
        }
    }
    public function actionLogout(): void
    {
        session_destroy();
        unset($_SESSION['user_name']);
        header("Location: /");
        die();
    }

    public function actionShow()
    {
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
        echo ("$id");
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

    public function actionDelete(): string
    {
        // echo"del User::exists($_POST['user_id'])";
        // print_r($_POST['user_id']);
        // $id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
        // print_r (User::getUserFromStorage($_POST['user_id']));

        if (User::exists($_POST['user_id'])) {
            User::deleteFromStorage($_POST['user_id']);

            $render = new Render();

            return $render->renderPage(
                'user-removed.twig',
                []
            );
        } else {
            throw new \Exception("Пользователь не существует");
        }
        // return "ok";
    }

    public function actionAddUser(): string
    {
        $isAdd = false;
        if (isset($_POST['add'])) {
            echo"add user";
            $user = new User();
            // $user->setUserId($_POST['user_id']);
            $user->setName($_POST['name']);
            $user->setLastName($_POST['lastname']);
            $user->setBirthdayFromString($_POST['birthday']);
            $_POST['password']="none";
            $_POST['login']="login";
            // echo("33333333333333".$user->validateRequestData());
            // if ($user->validateRequestData()) {
                $user->addUser();
                $isAdd = true;
            // }
        }
        // print_r(isset($_POST['add']));
        $render = new Render();

        // if (!$users) {
        // return $render->renderPage(
        // 'user_add-page.twig',
        //         [
        //             'title' => 'Список пользователей в хранилище',
        //             'message' => "Список пуст или не найден"
        //         ]
        //     );
        // } else {
        if ($isAdd) {
            return $render->renderPage(
                'user_add.twig',
                [
                    'title' => 'Созхдать пользователя'
                    // 'users' => $users
                ]
            );
        } else {
            return $render->renderPage(
                'user_add-page.twig',
                [
                    'title' => 'Созхдать пользователя'
                    // 'users' => $users
                ]
            );
        }
        // }
    }
}
