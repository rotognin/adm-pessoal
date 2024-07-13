<form class="col-12" method="post" action="index.php?control=parametro&action=gravar">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
    
    <div class="form-group">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label><br>
        <input type="number" id="id" name="id" readonly value="<?php echo ($parametro->id ?? '0'); ?>">
    </div>
    <div class="form-group">
        <label for="qtd_agendamentos" style="margin:0px"><b>Total de agendamentos em um mesmo horário de segunda a sexta: &nbsp;</b></label><br>
        <input type="number" id="qtd_agendamentos" name="qtd_agendamentos" value="<?php echo ($parametro->qtd_agendamentos ?? 2); ?>" autofocus>
    </div>
    <div class="form-group">
        <label for="qtd_agendamentos_sabados" style="margin:0px"><b>Total de agendamentos em um mesmo horário aos sábados: &nbsp;</b></label><br>
        <input type="number" id="qtd_agendamentos_sabados" name="qtd_agendamentos_sabados" value="<?php echo ($parametro->qtd_agendamentos_sabados ?? 2); ?>">
    </div>
    <div class="form-group">
        <label for="qtd_marcacoes" style="margin:0px"><b>Total de agendamentos semanais por contrato: &nbsp;</b></label><br>
        <input type="number" id="qtd_marcacoes" name="qtd_marcacoes" value="<?php echo ($parametro->qtd_marcacoes ?? 2); ?>">
    </div>
    <div class="form-group">
        <label for="qtd_pessoas" style="margin:0px"><b>Máximo de pessoas em uma visita: &nbsp;</b></label><br>
        <input type="number" id="qtd_pessoas" name="qtd_pessoas" value="<?php echo ($parametro->qtd_pessoas ?? 3); ?>">
    </div>
    <div class="form-group">
        <label for="horas_antes" style="margin:0px"><b>Horas de antecedência para agendamentos: &nbsp;</b></label><br>
        <input type="number" id="horas_antes" name="horas_antes" value="<?php echo ($parametro->horas_antes ?? 24); ?>">
    </div>
    <div class="form-group">
        <label for="horas_cancelamento" style="margin:0px"><b>Horas de antecedência para cancelamentos: &nbsp;</b></label><br>
        <input type="number" id="horas_cancelamento" name="horas_cancelamento" value="<?php echo ($parametro->horas_cancelamento ?? 1); ?>">
    </div>

    <button type="submit" value="Gravar" class="btn botao">Gravar</button>
</form>

<!-- Configurar horários disponíveis por dias -->
<br>
<h3 class="azul">Horários disponíveis para agendamento</h3>
<table class="table table-hover table-sm">
    <thead class="fundo-azul branco">
        <tr>
            <th>Dia da semana</th>
            <th>Horários</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
            if ($horarios){
                $dia = 9;

                foreach($horarios as $horario){
                    if ($dia == 9 || $dia != $horario->tipo){
                        if ($dia < 9){
                            echo '</td>';
                            echo '<td><!--input type="button" class="btn botao btn-sm" value="Excluir"--></td>';
                            echo '<td><!--input type="time">&nbsp;&nbsp;<input type="button" class="btn botao btn-sm" value="Adicionar"--></td>';
                            echo '</tr>';
                        }

                        echo '<tr><td>' . DIA[$horario->tipo] . '</td><td>';
                        $dia = $horario->tipo;
                    }

                    echo '<!--input type="checkbox"-->&nbsp;' . $horario->hora . '&nbsp;&nbsp;&nbsp;&nbsp;';
                }

                echo '</td>';
                echo '<td><!--input type="button" class="btn botao btn-sm" value="Excluir"--></td>';
                echo '<td><!--input type="time">&nbsp;&nbsp;<input type="button" class="btn botao btn-sm" value="Adicionar"--></td>';
                echo '</tr>';
            }
        ?>

    </tbody>
</table>