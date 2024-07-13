<?php

namespace Src\Model;

use CoffeeCode\DataLayer\DataLayer;

class Contrato extends DataLayer
{
    public function __construct()
    {
        parent::__construct('contrato_tb', ['numero', 'data_inicio', 'nome'], 'id', false);
    }

    /**
     * Buscar todos os visitantes deste Contrato
     */
    public function visitantes()
    {
        return (new Visitante())->find("contrato_id = :contrato_id", "contrato_id={$this->id}")->fetch(true);
    }
}