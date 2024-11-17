<?php

namespace Geekbrains\Application1\Models;
use Geekbrains\Application1\Application;

class User {

    private ?int $idUser;

    private ?string $userName;

    private ?string $userLastName;
    private ?int $userBirthday;

    private static string $storageAddress = '/storage/birthdays.txt';

    public function __construct(string $name = null, string $lastName = null, int $birthday = null, int $id_user = null){
        $this->userName = $name;
        $this->userLastName = $lastName;
        $this->userBirthday = $birthday;
        $this->idUser = $id_user;
    }

    public function saveUser(string $name, string $birthday){
        $this->setName($name);
        $this->setBirthdayFromString($birthday);
        echo("Save user {$this->getUserName()}");
    }
    public function setUserId(int $id_user): void {
        $this->idUser = $id_user;
    }
    public function getUserId(): ?int {
        return $this->idUser;
    }
    public function setName(string $userName) : void {
        $this->userName = $userName;
    }
    public function setLastName(string $userLastName) : void {
        $this->userLastName = $userLastName;
    }

    public function getUserName(): string {
        return $this->userName;
    }
    public function getUserLastName(): string {
        return $this->userLastName;
    }

    public function getUserBirthday(): int {
        return $this->userBirthday;
    }

    public function setBirthdayFromString(string $birthdayString) : void {
        $this->userBirthday = strtotime($birthdayString);
    }

    // public static function getAllUsersFromStorage(): array|false {
    //     $address = $_SERVER['DOCUMENT_ROOT'] . User::$storageAddress;
        
    //     if (file_exists($address) && is_readable($address)) {
    //         $file = fopen($address, "r");
            
    //         $users = [];
        
    //         while (!feof($file)) {
    //             $userString = fgets($file);
    //             $userArray = explode(",", $userString);

    //             $user = new User(
    //                 $userArray[0]
    //             );
    //             $user->setBirthdayFromString($userArray[1]);

    //             $users[] = $user;
    //         }
            
    //         fclose($file);

    //         return $users;
    //     }
    //     else {
    //         return false;
    //     }
    // }
    public static function getAllUsersFromStorage(): array {
        echo("=======================");
        $sql = "SELECT * FROM users";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute();
        $result = $handler->fetchAll();
        $users = [];
        $id=0;
        foreach($result as $item){
            // print_r($result);
            // var_dump($item['user_lastname']);
            
            $user = new User($item['user_name'], $item['user_lastname'], $item['user_birthday_timestamp'],$item['id_user']);
            // $user = new User($item['user_name'], $item['user_lastname'],112222);
            $users[] = $user;
            $id++;
            
        }
        
        return $users;
    }

    public static function validateRequestData(): bool{
        if(
            isset($_GET['name']) && !empty($_GET['name']) &&
            isset($_GET['lastname']) && !empty($_GET['lastname']) &&
            isset($_GET['birthday']) && !empty($_GET['birthday'])
        ){
            return true;
        }
        else{
            return false;
        }
    }

    public function setParamsFromRequestData(): void {
        $this->userName = $_GET['name'];
        $this->userLastName = $_GET['lastname'];
        $this->setBirthdayFromString($_GET['birthday']); 
    }

    public function saveToStorage(){
        $sql = "INSERT INTO users(user_name, user_lastname, user_birthday_timestamp) VALUES (:user_name, :user_lastname, :user_birthday)";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'user_name' => $this->userName,
            'user_lastname' => $this->userLastName,
            'user_birthday' => $this->userBirthday
        ]);
    }

    public static function exists(int $id): bool{
        // echo($id);
        $sql = "SELECT count(id_user) as user_count FROM users WHERE id_user = :id_user";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute([
            'id_user' => $id
        ]);

        $result = $handler->fetchAll();

        if(count($result) > 0 && $result[0]['user_count'] > 0){
            return true;
        }
        else{
            return false;
        }
    }
    public function updateUser(array $userDataArray,int $user_id): void{
        // print_r($userDataArray);
        $sql = "UPDATE users SET user_name = '$userDataArray[user_name]' Where id_user={$user_id}";
        
        $handler = Application::$storage->get()->exec($sql);
        
        
    }

    public static function deleteFromStorage(int $user_id) : void {
        $sql = "DELETE FROM users WHERE id_user = :id_user";
        print_r($sql);
        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id_user' => $user_id]);
    }

    public static function getUserFromStorage(int $id):User{
        // echo("=======================");
        $sql = "SELECT * FROM users WHERE id_user=:id";

        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['id'=>$id]);
        $result = $handler->fetch();
        // var_dump($result);
        return new User($result['user_name'], $result['user_lastname'], $result['user_birthday_timestamp'],$result['id_user']);
    }
}