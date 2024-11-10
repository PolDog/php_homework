<?php
namespace Geekbrains\Application1\Models;
class SiteInfo{
    private array $info;
    public function __construct() {
        $this->info =$_SERVER;
    }

    public function getInfo():array{
        return $this->info;
    }

    public function getCurrentTime():string{
        return date('H:i   Y-m-d');
    }
}