<?php

// подключение файлов логики
// require_once('src/main.function.php');
// require_once('src/template.function.php');
// require_once('src/file.function.php');

require_once('vendor/autoload.php');

//print_r($_SERVER);
//die();

// вызов корневой функции
$result = main("/code/config.ini");
//echo dirname(__DIR__);
//echo"\n";
//$result = main("./config.ini");
// вывод результата
echo $result;
