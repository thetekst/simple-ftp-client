<?php

// установка соединения
$conn_id = ftp_connect('62.76.187.249');

// проверка имени пользователя и пароля
$login_result = ftp_login($conn_id, 'user', '0J184yM7rt');

// получить содержимое текущей директории
$contents = ftp_nlist($conn_id, ".");

// вывод $contents
var_dump($contents);

?>