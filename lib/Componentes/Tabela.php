<?php

namespace Lib\Componentes;

class Tabela
{
    private string $id;
    private string $class;
    private array $headers;
    private array $rows;

    public function __construct(string $id, string $class = '')
    {
        $this->id = $id;
        $this->class = $class;
    }

    /**
     * Irá montar um array do tipo: ['value' => 'XXXXXX', 'class' => 'XXX XXXX XXXX']
     */
    public function addHeader(string $titulo, string $classe = '')
    {
        $this->headers[] = ['value' => $titulo, 'class' => $classe];
    }

    /**
     * Passar um array do tipo: 'row' => ['value' => 'XXXXXX', 'class' => 'XXX XXXX XXXX']
     */
    public function addRow(array $row)
    {
        $this->rows[] = $row;
    }

    public function html()
    {
        $tabela = <<<HTML
            <table class="table table-hover table-sm {$this->class}" id="{$this->id}">
                <thead class="fundo-azul branco">
                    <tr>
        HTML;

        foreach ($this->headers as $header) {
            $classe = ($header['class'] ?? '' == '') ? '' : ' class="' . $header['class'] . '" ';

            $tabela .= <<<HTML
                <th {$classe} scope="col">{$header['value']}</th>
            HTML;
        }

        $tabela .= <<<HTML
                </tr>
            </thead>
            <tbody>
        HTML;

        foreach ($this->rows as $rows) {
            $tabela .= <<<HTML
                <tr>
            HTML;

            foreach ($rows as $row) {
                foreach ($row as $data) {
                    $classe = (isset($data['class'])) ? ' class="' . $data['class'] . '" ' : '';

                    $tabela .= <<<HTML
                        <td {$classe}>{$data['value']}</td>
                    HTML;
                }
            }

            $tabela .= <<<HTML
                </tr>
            HTML;
        }

        $tabela .= <<<HTML
                </tbody>
            <table>
        HTML;

        echo $tabela;
    }
}
