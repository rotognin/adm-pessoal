<?php

header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');

require ('./vendor/autoload.php');

require_once('informacoes.php');
require_once('funcoes.php');
require_once('auxiliares.php');
require_once('emails.php');


define("DS", DIRECTORY_SEPARATOR);

define("STATUS_VISITA", array(
    '0' => 'Agendada',
    '1' => 'Impedida',
    '2' => 'Cancelada',
    '3' => 'Realizada'
));

define("STATUS_ADMIN", array(
    '0' => 'Ativo',
    '1' => 'Inativo',
    '2' => 'Pendente'
));

define("NIVEL_ADMIN", array(
    '0' => 'Administrador',
    '1' => 'Comum',
    '2' => 'Convidado'
));

define("MES", array(
    '1' => 'Janeiro',
    '2' => 'Fevereiro',
    '3' => 'Março',
    '4' => 'Abril',
    '5' => 'Maio',
    '6' => 'Junho',
    '7' => 'Julho',
    '8' => 'Agosto',
    '9' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro'
));

define("DIA", array(
    '0' => 'Domingo',
    '1' => 'Segunda',
    '2' => 'Terça',
    '3' => 'Quarta',
    '4' => 'Quinta',
    '5' => 'Sexta',
    '6' => 'Sábado',
    '7' => 'Feriado'
));