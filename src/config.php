<?php

define("DATA_LAYER_CONFIG", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3308",
    "dbname" => "adm_pessoal_db",
    "username" => "root",
    "passwd" => "euaquinanet",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

require_once('configemail.php');

define("EMAIL_DATA", [
    "host" => $email_host,
    "user" => $email_user,
    "pass" => $email_pass,
    "port" => 465,
    "reply" => $email_reply
]);
