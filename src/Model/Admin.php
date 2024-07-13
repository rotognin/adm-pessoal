<?php

namespace Src\Model;

use CoffeeCode\DataLayer\DataLayer;

class Admin extends DataLayer
{
    public function __construct()
    {
        parent::__construct('admin_tb', ['nome', 'login', 'senha'], 'id', False);
    }
}