<?php

namespace Src\Model;

use CoffeeCode\DataLayer\DataLayer;

class Horario extends DataLayer
{
    public function __construct()
    {
        parent::__construct('horario_tb', ['tipo', 'hora'], 'id', false);
    }
}