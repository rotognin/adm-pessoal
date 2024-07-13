<?php

namespace Lib\Kernel;

class Saida
{
    public static function html()
    {
        echo <<<HTML
                    </div>
                </body>
            </html>
        HTML;
    }
}
