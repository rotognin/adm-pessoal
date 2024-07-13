<?php

use Lib\Componentes\Menu;
use Lib\Kernel\Html;
use Lib\Kernel\Saida;

$titulo_h3 = 'Administração do sistema';
include 'html/head.php';

HTML::p('Olá, ' . HTML::getSession('usuNome'));

$menu = new Menu();
$menu->addItem('Anotações', 'anotacoes', 'anotacao');
$menu->addItem('Usuários', 'administradores', 'admin');
$menu->addSair();
$menu->html();


Saida::html();




/*

HTML::showAlert('Alerta, pessoas!', 'info');

$tabela = new Tabela('tabela-teste', 'table-bordered mt-2');
$tabela->addHeader('Carro');
$tabela->addHeader('Cor', 'text-center');

$linha = array(
    'row' => array(
        ['value' => 'Jetta', 'class' => 'text-right'],
        ['value' => 'Branco', 'class' => 'text-center']
    )
);

$tabela->addRow($linha);
$tabela->html();



<p>Olá, <?php echo $_SESSION['usuNome']; ?></p>

<nav class="navbar navbar-expand-lg navbar-dark fundo-azul">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-link text-white" href="index.php?action=anotacoes&control=anotacao">Anotações</a>
            <span class="nav-link text-white">|</span>
            <!--a class="nav-link text-white" href="index.php?action=relatorio&control=relatorio">Relatório de Visitas</a>
                    <span class="nav-link text-white">|</span-->

            <?php if (NIVEL_ADMIN[$_SESSION['usuNivel']] == 'Administrador') { ?>
                <a class="nav-link text-white" href="index.php?action=administradores&control=admin">Usuários</a>
                <span class="nav-link text-white">|</span>
                <!--a class="nav-link text-white" href="index.php?action=cadastro&control=parametro">Parâmetros</a>
                        <span class="nav-link text-white">|</span>
                        <a class="nav-link text-white" href="index.php?action=feriados&control=feriado">Feriados</a>
                        <span class="nav-link text-white">|</span-->
            <?php } ?>

            <a class="nav-link text-white" href="index.php?action=logout">Sair</a>
        </div>
    </div>
</nav>
<br>
<div id="aguarde" class="card text-center d-none">
    <h1>Aguarde...</h1>
    <br>
</div>

<form method="post" action="index.php?action=menu" class="float-right">
    <label for="dia">Filtrar dia: </label>
    <select id="dia" name="dia">
        <option value="Todos">Todos</option>
        <?php
        foreach ($data_semana->datas as $dia => $detalhe) {
            // Montar as opções...
            $selected = '';

            if ($dia == $dia_filtrar) {
                $selected = 'selected';
            }

            $option = '<option value="' . $dia . '" ' . $selected . '>' . ajustarData($dia) . ' - ' . $detalhe['nome'];
            $option .= ' ' . $detalhe['feriado'];
            $option .= '</option>';

            echo $option;
        }
        ?>
    </select>
    &nbsp;&nbsp;&nbsp;
    <button id="filtrar" type="submit" value="Filtrar Data" class="btn botao-atencao btn-sm">Filtrar</button>
</form>
<br>

<h4>Anotações</h4>
<table class="table table-hover table-sm">
    <thead class="fundo-azul-claro branco">
        <tr>
            <th>Anotação</th>
            <th>Data</th>
            <th>Hora</th>
            <th>Prioridade</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($anotacoes) {
            foreach ($anotacoes as $ano) {
                echo '<tr>';
                echo '<td>' . $ano->ano_texto . '</td>';
                echo '<td>' . LibAnotacao::extrairData($ano->ano_data) . '</td>';
                echo '<td>' . LibAnotacao::extrairHora($ano->ano_data) . '</td>';


                $nomes = '';

                foreach ($visita->pessoas as $pessoa) {
                    $nomes .= $pessoa->nome . ', ';
                }

                $nomes = substr($nomes, 0, -2);

                echo '<td>' . $nomes . '</td>';

                echo '<td>' . ajustarData($visita->data_visita) . ' (' . DIA[date('w', strtotime($visita->data_visita))] . ')' . '</td>';
                echo '<td>' . $visita->hora_visita . '</td>';
                echo '<td>' . $visita->observacoes . '</td>';

                // Só poderá "realizar" a visita caso a data atual seja igual ou maior que a data dela
                // Caso contrário o botão deverá ficar inativo (... a ser implementado ...)
                $dataAtual = date('Y-m-d');
                $disabled = '';
                $textoBotao = 'Realizar Visita';

                if ($dataAtual < $visita->data_visita) {
                    $disabled = 'disabled';
                    $textoBotao = 'Aguardando...';
                }

                echo '<td>';
                echo '<form method="post" action="index.php?control=visita&action=cancelar" onsubmit="return confirmarCancelamento();">';
                echo '<input type="hidden" name="visita_id" value="' . $visita->id . '">';
                echo '<button id="botaoCancelar" type="submit" value="Cancelar Visita" class="btn botao-atencao btn-sm">Cancelar Visita</button>';
                echo '</form>';
                echo '</td>';

                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4"><i>Nenhuma visita agendada.</i></td></tr>';
        }
        ?>
    </tbody>
</table>
</div>
<div class="modal" id="modalAguarde" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aguarde...</h5>
            </div>
            <div class="modal-body">
                <p>Estamos processando as informações</p>
            </div>
        </div>
    </div>
</div>
<?php include 'html/scriptsjs.php'; ?>
<script type="application/javascript" src="html/script.js?version=1"></script>
</body>

</html>
*/