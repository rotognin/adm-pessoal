<?php

session_start();

require('./lib/definicoes.php');

// Guardar gets e sets
global $request;
$request = new Lib\Kernel\Request;

$action = ($request->get('action', '') != '') ? $request->get('action') : 'home';
$control = ($request->get('control', '') != '') ? ucfirst($request->get('control')) : '';
$funcao = 'Src\\Controller\\' . $control . 'Controller::' . $action;

call_user_func($funcao);
