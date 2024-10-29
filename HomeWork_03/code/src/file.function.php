<?php

// function readAllFunction(string $address) : string {
function readAllFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        
        $contents = ''; 
    
        while (!feof($file)) {
            $contents .= fread($file, 100);
        }
        
        fclose($file);
        return $contents;
    }
    else {
        return handleError("Файл не существует");
    }
}

// function addFunction(string $address) : string {
function addFunction(array $config) : string {
    $address = $config['storage']['address'];

    $name = readline("Введите имя: ");
    $date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");

    if(!validate($date)){
        return handleError("Введена некорректная информация\n");
    }

    $data = $name . ", " . $date . "\r\n";

    $fileHandler = fopen($address, 'a');

    if(fwrite($fileHandler, $data)){
        fclose($fileHandler);
        return "Запись $data добавлена в файл $address";
    }
    else {
        fclose($fileHandler);
        return handleError("Произошла ошибка записи. Данные не сохранены");
    }
}

// function clearFunction(string $address) : string {
function clearFunction(array $config) : string {
    $address = $config['storage']['address'];

    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "w");
        
        fwrite($file, '');
        
        fclose($file);
        return "Файл очищен";
    }
    else {
        return handleError("Файл не существует");
    }
}

function helpFunction() {
    return handleHelp();
}

function readConfig(string $configAddress): array|false{
    return parse_ini_file($configAddress, true);
}

function readProfilesDirectory(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!is_dir($profilesDirectoryAddress)){
        mkdir($profilesDirectoryAddress);
    }

    $files = scandir($profilesDirectoryAddress);

    $result = "";

    if(count($files) > 2){
        foreach($files as $file){
            if(in_array($file, ['.', '..']))
                continue;
            
            $result .= $file . "\r\n";
        }
    }
    else {
        $result .= "Директория пуста \r\n";
    }

    return $result;
}

function readProfile(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!isset($_SERVER['argv'][2])){
        return handleError("Не указан файл профиля");
    }

    $profileFileName = $profilesDirectoryAddress . $_SERVER['argv'][2] . ".json";

    if(!file_exists($profileFileName)){
        return handleError("Файл $profileFileName не существует");
    }

    $contentJson = file_get_contents($profileFileName);
    $contentArray = json_decode($contentJson, true);

    $info = "Имя: " . $contentArray['name'] . "\r\n";
    $info .= "Фамилия: " . $contentArray['lastname'] . "\r\n";

    return $info;
}

function find_birthdays(array $config):string{
    $test=readAllFunction($config);
    //$current_day=24;
    //$current_month=8;
    $current_day=date("d");
    $current_month=date("m");
    $text="";
    $records = explode("\n", $test);
    $i=0;
    while ($i<count($records)) {
        $line = explode(", ", $records[$i]);
        $birthday= explode("-", $line[1]);
        if($birthday[0]==$current_day and $birthday[1]==$current_month){
            $text=$text."День рождения у $line[0] !!!!!!\n";
        }
        $i++;
    }
    if($text!=""){
        return $text;
    }
    return "Ни у кого нету деня рождения";
}

function remove_human(array $config):string{
    $data_for_remove="";
    $name_for_remove="";
    $test=readAllFunction($config);
    $new_list="";
    echo("Список всех людей\n");
    echo $test;
    echo "\n";
    $input = readline("Для удаления введите имя или дату рождения в формате ДД-ММ-ГГГГ:\n");

    if(count(explode("-", $input))>1){
        if(!validate($input)){
            return handleError("Введена некорректная дата\n");
        }
        $data_for_remove=$input;
    }else{
        $name_for_remove=$input;
    }
    $records = explode("\n", $test);
    $i=0;
    clearFunction($config);
    while ($i<count($records)) {
        if($records[$i]!=""){
        $records[$i]=str_replace("\r","",$records[$i]);
        $line = explode(", ", $records[$i]);
        if($line[1]===$data_for_remove or $line[0]===$name_for_remove){
            echo("     удалили $line[0]\n");
        }else{
            save_data($line[0],$line[1],$config);
        }
    }
        $i++;
    }
return $new_list;
}

function save_data(string $name, string $date,array $config ){

    $data = $name . ", " . $date . "\r\n";
    $address = $config['storage']['address'];

    $fileHandler = fopen($address, 'a');

    fwrite($fileHandler, $data);
    fclose($fileHandler);
}