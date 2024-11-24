<?php

$hash = password_hash('123', PASSWORD_DEFAULT);
echo md5($hash);

if (password_verify('1232', $hash)) {
    echo ("find");
} else {
    echo ("not find");
}
