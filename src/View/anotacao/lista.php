<?php

$titulo_h3 = 'Listagem de Anotações';

include('./html/head.php');

use Lib\Anotacao\LibAnotacao;
use Lib\Componentes\Menu;
use Lib\Componentes\Tabela;
use Lib\Kernel\Saida;

$menu = new Menu();
$menu->addItem('Nova Anotação', 'novo', 'anotacao');
$menu->addVoltar();
$menu->html();

$tabela = new Tabela('tabela-anotacoes', 'table-bordered mt-2');
$tabela->addHeader('ID', ['class' => 'align-middle text-center']);
$tabela->addHeader('Texto', ['class' => 'text-center']);
$tabela->addHeader('Data', ['class' => 'text-center']);
$tabela->addHeader('Prioridade', ['class' => 'text-center']);
$tabela->addHeader('Situação', ['class' => 'text-center']);
$tabela->addHeader('Ações', ['class' => 'text-center']);

// Trazer a lista de anotações gravadas. Virá do Controller
if (!empty($anotacoes)) {
    foreach ($anotacoes as $ano) {
        $tabela->addRow([
            'row' => [
                ['value' => $ano['ano_id'], 'attrs' => ['class' => 'text-center']],
                ['value' => $ano['ano_texto'], 'attrs' => ['class' => 'text-left']],
                ['value' => LibAnotacao::extrairData($ano['ano_data']), 'attrs' => ['class' => 'text-center']],
                ['value' => LibAnotacao::getPrioridade($ano['ano_prioridade']), 'attrs' => ['class' => 'text-center']],
                ['value' => LibAnotacao::getSituacao($ano['ano_situacao']), 'attrs' => ['class' => 'text-center']],
                ['value' => 'Ações', 'attrs' => ['class' => 'text-center']]
            ]
        ]);
    }
} else {
    $tabela->addRow([
        'row' => [
            ['value' => '<i>Sem anotações</i>', 'attrs' => ['class' => 'text-center', 'colspan' => '6']]
        ]
    ]);
}

$tabela->html();

Saida::html();
