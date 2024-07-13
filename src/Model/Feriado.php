<?php

namespace Src\Model;

use CoffeeCode\DataLayer\DataLayer;

class Feriado extends DataLayer
{
    public function __construct()
    {
        parent::__construct('feriado_tb', ['dia', 'mes', 'descricao'], 'id', false);
    }
}