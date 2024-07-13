<?php

$_SESSION['usuId'] = 0;

$arquivo = 'login.php';

if (!isset($mensagem)){
    $mensagem = '';
}

require ($arquivo);