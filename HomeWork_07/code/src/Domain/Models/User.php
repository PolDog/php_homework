<?php

namespace Geekbrains\Application1\Domain\Models;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Infrastructure\Storage;

class User
{

    private ?string $userName;
    private ?string $userLogin;
    private ?int $idUser;
    private ?string $userLastName;
    private ?int $userBirthday;

    private static string $storageAddress = '/storage/birthdays.txt';

    public function __construct(string $name = null, string $lastName = null, int $birthday = null, int $id_user = null)
    {
        $this->userName = $name;
        $this->userLastName = $lastName;
        $this->userBirthday = $birthday;
        $this->idUser = $id_user;
    }

    public function setName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function setUserLogin(string $userLogin): void
    {
        $this->userLogin = $userLogin;
    }

    public function setLastName(string $userLastName): void
    {
        $this->userLastName = $userLastName;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getUserLastName(): string
    {
        return $this->userLastName;
    }

    public function getUserBirthday(): ?int
    {
        return $this->userBirthday;
    }

    public function setUserId(int $id_user): void
    {
        $this->idUser = $id_user;
    }

    public function getUserId(): ?int
    {
        return $this->idUser;
    }

    public function setBirthdayFromString(string $birthdayString): void
    {
        $this->userBirthday = strtotime($birthdayString);
    }

    public static function getAllUsersFromStorage(): array
    {
        $sql = "SELECT * FROM users";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute();
        $result = $handler->fetchAll();

        $users = [];

        foreach ($result as $item) {
            $user = new User($item['user_name'], $item['user_lastname'], $item['user_birthday_timestamp'], $item['id_user']);
            $users[] = $user;
        }

        return $users;
    }

    public static function validateRequestData(): bool
    {
        $result = true;
        if (preg_match("/^[<]+\w+[>\w+\s]/", $_POST['login'])) {
            print_r("name error!  Script!");
            echo "<br>";
            $result = false;
        }

        if (preg_match("/^[<]+\w+[>\w+\s]/", $_POST['password'])) {
            print_r("pass error!  Script!");
            echo "<br>";
            $result = false;
        }

        
        if (!(
            isset($_POST['name']) && !empty($_POST['name']) &&
            isset($_POST['lastname']) && !empty($_POST['lastname']) &&
            isset($_POST['birthday']) && !empty($_POST['birthday'])
        )) {
            $result = false;
        }
        if (!empty($_POST['birthday'])) {
            if (!preg_match('/^(\d{2}-\d{2}-\d{4})$/', $_POST['birthday'])) {
                $result =  false;
            }
        }


        // if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']) {
        //     $result = false;
        // }
echo("======================".$result);

        return $result;
    }

    public function setParamsFromRequestData(): void
    {
        $this->userName = htmlspecialchars($_POST['name']);
        $this->userLastName = htmlspecialchars($_POST['lastname']);
        $this->setBirthdayFromString($_POST['birthday']);
    }

    public function saveToStorage()
    {
        $sql = "INSERT INTO users(user_name, user_lastname, user_birthday_timestamp) VALUES (:user_name, :user_lastname, :user_birthday)";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday
        ]);
    }


    public static function exists(int $id): bool
    {
        // echo($id);
        $sql = "SELECT count(id_user) as user_count FROM users WHERE id_user = :id_user";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'id_user' => $id
        ]);

        $result = $handler->fetchAll();

        if (count($result) > 0 && $result[0]['user_count'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getUserFromStorage(int $id): User
    {
        // echo("=======================");
        $sql = "SELECT * FROM users WHERE id_user=:id";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id' => $id]);
        $result = $handler->fetch();
        // var_dump($result);
        return new User($result['user_name'], $result['user_lastname'], $result['user_birthday_timestamp'], $result['id_user']);
    }

    public function updateInfo()
    {
        $sql = "UPDATE users SET user_name='{$this->userName}', user_lastname='$this->userLastName', user_birthday_timestamp='$this->userBirthday' WHERE id_user={$this->idUser}";

        // $sql = "UPDATE users SET user_name=':user_name', user_lastname=':user_lastname', user_birthday_timestamp=':user_birthday' WHERE id_user=:id";
        // $sql="UPDATE users "
        // echo("$sql");
        $handler = Application::$storage->get()->exec($sql);
        // $handler = Application::$storage->get()->prepare($sql);
        // $handler->execute([
        //     'user_name' => $this->userName,
        //     'user_lastname' => $this->userLastName,
        //     'user_birthday' => $this->userBirthday,
        //     'id' => $this->idUser
        // ]);
    }

    public static function deleteFromStorage(int $user_id): void
    {
        $sql = "DELETE FROM users WHERE id_user = :id_user";
        print_r($sql);
        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id_user' => $user_id]);
    }

    public function addUser()
    {
        $sql = "INSERT INTO users(user_name, user_lastname, user_birthday_timestamp, login) VALUES (:user_name, :user_lastname, :user_birthday,:user_name)";
        // echo ("$sql");
        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday
        ]);
    }
}
