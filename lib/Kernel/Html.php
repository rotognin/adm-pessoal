<?php

namespace Lib\Kernel;

class Html
{
    public static function p(string $texto, string $classe = '')
    {
        $html = <<<HTML
            <p class="{$classe}">{$texto}</p>
        HTML;

        echo $html;
    }

    public static function getSession(string $key)
    {
        return $_SESSION[$key] ?? '';
    }

    public static function showAlert(string $text, string $type = 'warning')
    {
        $html = <<<HTML
            <div class="alert alert-{$type} alert-dismissible fade show m-1" role="alert">
                {$text}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        HTML;

        echo $html;
    }
}
