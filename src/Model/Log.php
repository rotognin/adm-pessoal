<?php

namespace Src\Model;

use CoffeeCode\DataLayer\DataLayer;

class Log extends DataLayer
{
    public function __construct()
    {
        parent::__construct('log_tb', ['texto'], 'id', false);
    }
}