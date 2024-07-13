<?php

namespace Src\Model;

use CoffeeCode\DataLayer\DataLayer;

class Visitante extends DataLayer
{
    public function __construct()
    {
        parent::__construct('visitante_tb', ['contrato_id', 'email', 'nome'], 'id', false);
    }

    public function jaCadastrado()
    {
        $params = http_build_query(['email' => $this->email, 'contrato_id' => $this->contrato_id]);
        $visitante = (new Visitante())->find('email = :email AND contrato_id = :contrato_id', $params)->fetch(true);
        return $visitante;
    }
}