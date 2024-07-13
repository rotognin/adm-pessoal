<?php

$titulo_h3 = 'Listagem de Anotações';

include('./html/head.php');

use Lib\Anotacao\LibAnotacao;
use Lib\Componentes\Menu;
use Lib\Kernel\Saida;

$menu = new Menu();
$menu->addItem('Nova Anotação', 'novo', 'anotacao');
$menu->addVoltar();
$menu->html();

Saida::html();


/*

    <nav class="navbar navbar-expand-lg navbar-dark fundo-azul">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link text-white" href="index.php?action=menu">Voltar</a>
                <span class="nav-link text-white">|</span>
                <a class="nav-link text-white" href="index.php?action=novo&control=anotacao">Nova Anotação</a>
            </div>
        </div>
    </nav>
    <br>

    <?php include_once('./lib/mensagem.php'); ?>

    <table class="table table-hover table-sm">
        <thead class="fundo-azul branco">
            <tr>
                <th>ID</th>
                <th>Dia</th>
                <th>Mês</th>
                <th>Descrição</th>
                <th></th>
                <th></th>

            </tr>
        </thead>
        <tbody>

            <?php
            if ($feriados) {
                foreach ($feriados as $feriado) {
                    echo '<tr>';
                    echo '<td>' . $feriado->id . '</td>';
                    echo '<td>' . $feriado->dia . '</td>';
                    echo '<td>' . MES[$feriado->mes] . '</td>';
                    echo '<td>' . $feriado->descricao . '</td>';

                    echo '<td>';
                    echo '<form method="post" action="index.php?control=feriado&action=alterar">';
                    echo '<input type="hidden" name="feriado_id" value="' . $feriado->id . '">';
                    echo '<input type="submit" style="margin-left: 10px" value="Alterar" class="btn botao btn-sm float-left">';
                    echo '</form>';
                    echo '</td>';
                    echo '<td>';
                    echo '<form method="post" action="index.php?control=feriado&action=excluir" onsubmit="return confirmarExclusao();">';
                    echo '<input type="hidden" name="feriado_id" value="' . $feriado->id . '">';
                    echo '<input type="submit" style="margin-left: 10px" value="Excluir" class="btn botao-atencao btn-sm float-left">';
                    echo '</form>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>

*/