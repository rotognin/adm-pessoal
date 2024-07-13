<?php

namespace Src\Model;

use CoffeeCode\DataLayer\DataLayer;

class Pessoa extends DataLayer
{
    public function __construct()
    {
        parent::__construct('pessoa_tb', ['visita_id', 'nome'], 'id', false);
    }
}