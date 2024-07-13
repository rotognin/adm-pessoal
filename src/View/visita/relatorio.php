<!DOCTYPE html>
<html>
<?php include ('./html/head.php'); ?>
<body>
    <div class="container-fluid">
        <h3 class="azul">Relatório de Visitas</h3>

        <?php include_once ('./lib/mensagem.php'); ?>

        <table class="table table-hover table-sm">
            <thead class="fundo-azul branco">
                <tr>
                    <th>Contrato</th>
                    <th>Residente</th>
                    <th>Visitante</th>
                    <th>Parentesco</th>
                    <th>Data</th>
                    <th>Situação</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($visitas){
                foreach($visitas as $visita)
                {
                    echo '<tr>';
                        echo '<td>' . $visita->contrato->numero . '</td>';
                        echo '<td>' . $visita->contrato->nome . '</td>';
                        echo '<td>' . $visita->visitante->nome . '</td>';
                        echo '<td>' . $visita->visitante->parentesco . '</td>';
                        echo '<td>' . ajustarData($visita->data_visita) . '</td>';
                        echo '<td>' . STATUS_VISITA[$visita->status] . '</td>';
                    echo '</tr>';
                }
            }
                
            ?>
            </tbody>
        </table>
    </div>

    <?php include ('./html/scriptsjs.php'); ?>
</body>
</html>