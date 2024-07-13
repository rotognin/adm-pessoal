<form class="col-12" method="post" action="index.php?control=feriado&action=gravar">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
    
    <div class="form-group">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label><br>
        <input type="number" id="id" name="id" readonly value="<?php echo ($feriado->id ?? '0'); ?>">
    </div>
    <div class="form-group">
        <label for="dia" style="margin:0px"><b>Dia: &nbsp;</b></label><br>
        <input type="number" id="dia" name="dia" value="<?php echo ($feriado->dia ?? ''); ?>" autofocus>
    </div>
    <?php
        $feriado_mes = ($feriado->mes ?? '1');
    ?>
    <div class="form-group">
        <label for="mes" style="margin:0px"><b>Mês: &nbsp;</b></label><br>
        <select name="mes" id="mes">
            <option value="1" <?php if ($feriado_mes == 1) { echo 'selected'; } ?>>Janeiro</option>
            <option value="2" <?php if ($feriado_mes == 2) { echo 'selected'; } ?>>Fevereiro</option>
            <option value="3" <?php if ($feriado_mes == 3) { echo 'selected'; } ?>>Março</option>
            <option value="4" <?php if ($feriado_mes == 4) { echo 'selected'; } ?>>Abril</option>
            <option value="5" <?php if ($feriado_mes == 5) { echo 'selected'; } ?>>Maio</option>
            <option value="6" <?php if ($feriado_mes == 6) { echo 'selected'; } ?>>Junho</option>
            <option value="7" <?php if ($feriado_mes == 7) { echo 'selected'; } ?>>Julho</option>
            <option value="8" <?php if ($feriado_mes == 8) { echo 'selected'; } ?>>Agosto</option>
            <option value="9" <?php if ($feriado_mes == 9) { echo 'selected'; } ?>>Setembro</option>
            <option value="10" <?php if ($feriado_mes == 10) { echo 'selected'; } ?>>Outubro</option>
            <option value="11" <?php if ($feriado_mes == 11) { echo 'selected'; } ?>>Novembro</option>
            <option value="12" <?php if ($feriado_mes == 12) { echo 'selected'; } ?>>Dezembro</option>
        </select>
    </div>
    <div class="form-group">
        <label for="descricao" style="margin:0px"><b>Descrição: &nbsp;</b></label><br>
        <input type="text" id="descricao" name="descricao" value="<?php echo ($feriado->descricao ?? ''); ?>" size="80">
    </div>

    <input type="hidden" id="acao" name="acao" value="<?php echo $acao; ?>">

    <button type="submit" value="Gravar" class="btn botao">Gravar</button>
</form>