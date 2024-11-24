<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Application;

class AbstractController
{

    protected array $actionsPermissions = [];

    public function __construct()
    {
        // var_dump("=====================");
        if (!isset($_SESSION['counter'])) {
            $_SESSION['counter'] = 0;
        }
        $_SESSION['counter']++;
    }

    public function getUserRoles(): array
    {
        $roles = [];
        $roles[] = 'user';

        if (isset($_SESSION['id_user'])) {
            $rolesSql = "SELECT * FROM user_roles WHERE id_user = :id";

            $handler = Application::$storage->get()->prepare($rolesSql);
            $handler->execute(['id' => $_SESSION['id_user']]);
            $result = $handler->fetchAll();

            if (!empty($result)) {
                foreach ($result as $role) {
                    $roles[] = $role['role'];
                }
            }
        }

        return $roles;
    }

    public function getActionsPermissions(string $methodName): array
    {
        return $this->actionsPermissions[$methodName] ?? [];
    }
}
