<?php

namespace Lib\Anotacao;

class LibAnotacao
{
    public array $prioridade = array(
        'B' => 'Baixa',
        'M' => 'Média',
        'A' => 'Alta'
    );

    public static function getPrioridade(string $prioridade = '')
    {
        return ($prioridade == '') ? self::$prioridade : self::$prioridade[$prioridade];
    }

    public static function extrairData($dataHora)
    {
        $array = explode(' ', $dataHora);
        $data_sql = explode('-', $array[0]);
        $data_ptBR = $data_sql[2] . '/' . $data_sql[1] . '/' . $data_sql[0];
        return $data_ptBR;
    }

    public static function extrairHora($dataHora)
    {
        $array = explode(' ', $dataHora);
        $hora_sql = explode('-', $array[1]);
        $hora_ptBR = $hora_sql[0] . ':' . $hora_sql[1];
        return $hora_ptBR;
    }
}
