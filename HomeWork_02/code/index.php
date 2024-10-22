<?php
echo "Home work 2";
$oblast = [
    'Московская область' => [
        'Москва',
        'Зеленоград',
        'Клин',
    ],
    'Ленинградская область' => [
        'Санкт-Петербург',
        'Всеволжск',
        'Павловск',
    ],
    'Рязанская область область' => [
        'Шилово',
        'Чучково',
        'Сараи',
    ],
  ];
    
  $letters = [
      'а' => 'a',   'б' => 'b',   'в' => 'v',
      'г' => 'g',   'д' => 'd',   'е' => 'e',
      'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
      'и' => 'i',   'й' => 'y',   'к' => 'k',
      'л' => 'l',   'м' => 'm',   'н' => 'n',
      'о' => 'o',   'п' => 'p',   'р' => 'r',
      'с' => 's',   'т' => 't',   'у' => 'u',
      'ф' => 'f',   'х' => 'h',   'ц' => 'c',
      'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
      'ь' => '\'',  'ы' => 'y',   'ъ' => '\'',
      'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
      ' ' => ' '
  ];
  
next_stage(1);

$a=1;
$b=0;
$operation="/";
echo "a= {$a}, b={$b}, operation is {$operation} , rezult = ";
echo calc($a,$b,$operation);

function calc( $a, $b, string $operation):float|string{
    if($operation==="+"){
        return $a+$b;
    }
    if($operation==="-"){
        return $a-$b;
    }
    if($operation==="*"){
        return $a*$b;
    }
    if($operation==="/" && $b!=0){
        return $a/$b;
    }
    return "error! Деление на 0";
}


next_stage(2);
$a=1;
$b=2;
$operation="plus";
$operation="minus";
$operation="multiplication";
$operation="division";
echo "a= {$a}, b={$b}, operation is {$operation} , rezult = ";
switch ($operation){
    case "plus":
        echo calc($a,$b,"+");
        break;
    case "minus":
        echo calc($a,$b,"-");
        break;
    case "multiplication":
        echo calc($a,$b,"*");
        break;
    case "division":
        echo calc($a,$b,"/");
        break;
    default:
        echo "Not correct input! <br/>";
}

next_stage(3);

foreach ($oblast as $obl =>$city)
{
    echo "{$obl}: ";
    for ($i=0; $i<count($city);$i++){
        echo $city[$i];
        if($i<(count($city)-1)){
        echo ", ";
        }else{
        echo "<br/>";
        }
    }
}

next_stage(4);

$string="привет как дела";
$array = mb_str_split($string);
echo $string;
echo "<br/>";

for($i=0;$i<count($array);$i++){
    echo change($array[$i]);
}


function change(string $l){
    global $letters;
    foreach ($letters as $rus=>$tr){
        if($l==$rus){
            echo "$tr";
        }
    }
}



function next_stage(int $index){
    echo "<br/>";
    echo "<br/>";
    echo "{$index}). ";
}

?>
