<?php

namespace Src\Model;

use CoffeeCode\DataLayer\DataLayer;

class Parametro extends DataLayer
{
    public function __construct()
    {
        parent::__construct('parametro_tb', [], 'id', false);
    }
}