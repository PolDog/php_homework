<?php
namespace Geekbrains\Application1\Models;
class Phone{
    private string $phone;
    public function __construct() {
        $this->phone = '+7 912 123 23 23';
    }

    public function getPhone():string{
        return $this->phone;
    }
}