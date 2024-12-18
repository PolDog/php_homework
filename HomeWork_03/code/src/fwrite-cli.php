<?php
/*
$address = '/code/birthdays.txt';

$name = readline("Введите имя: ");
$date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");

if(validate($date)){
    $data = $name . ", " . $date . "\r\n";

    $fileHandler = fopen($address, 'a');
    
    if(fwrite($fileHandler, $data)){
        echo "Запись $data добавлена в файл $address";
    }
    else {
        echo "Произошла ошибка записи. Данные не сохранены";
    }
    
    fclose($fileHandler);
}
else{
    echo "Введена некорректная информация";
}
*/
function validate(string $date): bool {
    echo("start\n");
    $dateBlocks = explode("-", $date);
    echo ($date."\n");
    if(count($dateBlocks) < 3){
        echo("<3\n");
        return false;
    }

    if(isset($dateBlocks[0]) && $dateBlocks[0] > 31) {
        echo("$dateBlocks[0]  day");
        return false;
    }

    if(isset($dateBlocks[1]) && $dateBlocks[0] > 12) {
        echo("month\n");
        return false;
    }

    if(isset($dateBlocks[2]) && $dateBlocks[2] > date('Y')) {
        echo("year\n");
        return false;
    }

    return true;
}
