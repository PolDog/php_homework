<?php
$a = 5;                                 //объявляю переменную a int
$b = '05';                              //объявляю переменную b text
echo "var_dump($a == $b) ";
var_dump($a == $b);                     //сравнивание переменных, переменная в автомат. преобразована. результат тру.
echo "<br/>";
echo "var_dump((int)'012345') ";
var_dump((int)'012345');                //явное преобразование из текста в инт .  результат 12345
echo "<br/>";
echo "var_dump((float)123.0 === (int)123.0) ";
var_dump((float)123.0 === (int)123.0);  //строгое сравнение, число с плавающей точкой и целочисленное. результат ложь
echo "<br/>";
echo " var_dump(0 == 'hello, world') ";
var_dump(0 == 'hello, world');          //сравнение нуля и текстовой строки. строка не пустая (т.е. не NULL) результат ложь

$a=2;
$b=3;
echo "a={$a}, b={$b}<br/>";
$a=$a+$b;
$b=$a-$b;
$a=$a-$b;
echo "a={$a}, b={$b}<br/>";
?>
