<?php

namespace Src\Model;

class DataSemana
{
    public $data_atual;
    public $data_inicial;
    public $data_final;
    public array $datas;

    public function __construct()
    {
        $this->data_atual = date_create(date('Y-m-d'));
        $this->data_inicial = date_create($this->data_atual->format('Y-m-d'));
        $this->data_final = date_create($this->data_atual->format('Y-m-d'));

        $reduzir = date('w', strtotime($this->data_atual->format('Y-m-d')));
        $this->data_inicial->modify('-' . $reduzir . ' day');

        $aumentar = 6 - $reduzir;
        $this->data_final->modify('+' . $aumentar . ' day');
    }

    /**
     * Monta um array com as datas da semana entro o início e o fim
     */
    public function montarDatas()
    {
        // Desenvolver depois...
        // Montar o array com o dia, nome do dia e se é feriado com a descrição do mesmo
        $dia = date_create($this->data_inicial->format('Y-m-d'));
        $dia->modify('+1 day'); // Para pegar a segunda-feira

        $this->datas = array();

        while ($dia <= $this->data_final)
        {
            $dia_espec = $dia->format('Y-m-d');
            $nroDia = $dia->format('d');
            $nroMes = $dia->format('m');

            $params = http_build_query(['dia' => $nroDia, 'mes' => $nroMes]);
            $feriado = (new Feriado())->find('dia = :dia AND mes = :mes', $params)->fetch();

            if ($feriado){
                $descricao = ' - ' . $feriado->descricao;
            } else {
                $descricao = '';
            }

            $this->datas[$dia_espec] = array(
                'nome' => DIA[date('w', strtotime($dia_espec))],
                'feriado' => $descricao
            );

            $dia->modify('+1 day');
        }
    }
}