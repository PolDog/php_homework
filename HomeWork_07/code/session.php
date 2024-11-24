<?php
session_start();
$_SESSION['message'] = 'Пользователь удален';


echo $_SESSION['message'] = 'admin';
unset($_SESSION['message']);
session_destroy();