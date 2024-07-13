<?php

namespace Lib\Componentes;

class Menu
{
    private array $itens;
    private bool $primeiro;

    public function __construct()
    {
        $this->primeiro = true;
    }

    /**
     * Adicionar item de menu
     * @param string $text
     * @param string $action
     * @param string $control
     */
    public function addItem(string $text, string $action, string $control)
    {
        $this->itens[] = [
            'text' => $text,
            'action' => $action,
            'control' => $control
        ];
    }

    public function addVoltar()
    {
        $this->itens[] = [
            'text' => 'Voltar'
        ];
    }

    public function addSair()
    {
        $this->itens[] = [
            'text' => 'Sair'
        ];
    }

    public function html()
    {
        $menu = <<<HTML
            <nav class="navbar navbar-expand-lg navbar-dark fundo-azul">
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
        HTML;

        foreach ($this->itens as $item) {
            if (!$this->primeiro) {
                $menu .= <<<HTML
                    <span class="nav-link text-white">|</span>
                HTML;
            }

            if ($item['text'] == 'Voltar') {
                $menu .= <<<HTML
                    <a class="nav-link text-white" href="index.php?action=menu">Voltar</a>
                HTML;
            } elseif ($item['text'] == 'Sair') {
                $menu .= <<<HTML
                    <a class="nav-link text-white" href="index.php?action=logout">Sair</a>
                HTML;
            } else {
                $menu .= <<<HTML
                    <a class="nav-link text-white" href="index.php?action={$item['action']}&control={$item['control']}">{$item['text']}</a>
                HTML;
            }

            $this->primeiro = false;
        }

        $menu .= <<<HTML
                    </div>
                </div>
            </nav>
        HTML;

        echo $menu;
    }
}
