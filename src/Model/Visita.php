<?php

namespace Src\Model;

use CoffeeCode\DataLayer\DataLayer;

class Visita extends DataLayer
{
    public function __construct()
    {
        parent::__construct('visita_tb', ['visitante_id', 'data_visita', 'contrato_id'], 'id', false);
    }

    /**
     * Anexar as informações para cada visita: dados do contrato e do visitante
     */
    public function anexarDados()
    {
        $this->contrato = (new Contrato())->findById($this->contrato_id);
        $this->visitante = (new Visitante())->findById($this->visitante_id);
        $this->pessoas = (new Pessoa())->find('visita_id = :visita_id', 'visita_id=' . $this->id)->fetch(true);
    }
}