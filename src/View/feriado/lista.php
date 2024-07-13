<!DOCTYPE html>
<html>
<?php include ('./html/head.php'); ?>
<body>
    <div class="container-fluid">
        <h3 class="azul">Listagem de feriados</h3>
        
        <nav class="navbar navbar-expand-lg navbar-dark fundo-azul">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link text-white" href="index.php?action=menu">Início</a>
                    <span class="nav-link text-white">|</span>
                    <a class="nav-link text-white" href="index.php?action=novo&control=feriado">Novo Feriado</a>
                </div>
            </div>
        </nav>
        <br>

        <?php include_once ('./lib/mensagem.php'); ?>

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
                if ($feriados){
                    foreach($feriados as $feriado){
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
    </div>

    <?php include ('./html/scriptsjs.php'); ?>
    <script type="application/javascript" src="html/script.js?version=2"></script>
</body>
</html>