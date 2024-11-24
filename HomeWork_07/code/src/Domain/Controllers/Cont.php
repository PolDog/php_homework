<?php

namespace Geekbrains\Application1\Domain\Controllers;

class Cont
{
    public function __construct()
    {
        // var_dump("=====================");
        if (!isset($_SESSION['counter'])) {
            $_SESSION['counter'] = 0;
        }
        $_SESSION['counter']++;
    }
}
