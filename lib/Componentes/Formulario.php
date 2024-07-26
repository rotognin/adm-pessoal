<?php

namespace Lib\Componentes;

class Formulario
{
    private string $definitions;
    private array $fields = [];

    public function __construct(string $definitions)
    {
        $this->definitions = $definitions;
    }

    public function insertField(string $field)
    {
        $this->fields[] = $field;
    }

    public function html()
    {
        $html = <<<HTML
            <form {$this->definitions}>
                <input type="hidden" name="_token" value="{$_SESSION['csrf']}">
        HTML;

        if (!empty($this->fields)) {
            foreach ($this->fields as $field) {
                $html .= $field;
            }
        }

        echo $html;
    }
}
