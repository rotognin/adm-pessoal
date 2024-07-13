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
     * Irá montar um array do tipo: ['value' => 'XXXXXX', 'attrs' => ['class' => 'xxxxx', 'colspan' => '8']]
     */
    public function addHeader(string $titulo, array $attrs = [])
    {
        $this->headers[] = ['value' => $titulo, 'attrs' => $attrs];
    }

    /**
     * Passar um array do tipo: 'row' => ['value' => 'XXXXXX', 'attrs' => ['class' => 'xxxxx', 'colspan' => '8']]
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
            //$classe = ($header['class'] ?? '' == '') ? '' : ' class="' . $header['class'] . '" ';

            $attrs = '';

            if (!empty($header['attrs'])) {
                foreach ($header['attrs'] as $key => $value) {
                    $attrs .= ' ' . $key . '="' . $value . '" ';
                }
            }

            $tabela .= <<<HTML
                <th {$attrs} scope="col">{$header['value']}</th>
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
                    //$classe = (isset($data['class'])) ? ' class="' . $data['class'] . '" ' : '';

                    $attrs = '';

                    if (!empty($data['attrs'])) {
                        foreach ($data['attrs'] as $key => $value) {
                            $attrs .= ' ' . $key . '="' . $value . '" ';
                        }
                    }

                    $tabela .= <<<HTML
                        <td {$attrs}>{$data['value']}</td>
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
