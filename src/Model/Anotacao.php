<?php

namespace Src\Model;

use CoffeeCode\DataLayer\DataLayer;

class Anotacao extends DataLayer
{
    public function __construct()
    {
        parent::__construct('anotacao_tb', ['ano_data', 'ano_texto'], 'ano_id', false);
    }
}
