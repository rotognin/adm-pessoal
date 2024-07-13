<form class="col-12" method="post" action="index.php?control=contrato&action=gravar">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
    
    <div class="form-group">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label><br>
        <input type="number" id="id" name="id" readonly value="<?php echo ($contrato->id ?? '0'); ?>">
    </div>
    <div class="form-group">
        <label for="numero" style="margin:0px"><b>Número do Contrato: &nbsp;</b></label><br>
        <input type="text" id="numero" name="numero" value="<?php echo ($contrato->numero ?? ''); ?>" autofocus>
    </div>
    <div class="form-group">
        <label for="nome" style="margin:0px"><b>Nome: &nbsp;</b></label><br>
        <input type="text" id="nome" name="nome" value="<?php echo ($contrato->nome ?? ''); ?>" size="60">
    </div>
    <div class="form-group">
        <label for="data_inicio" style="margin:0px"><b>Data de Início do Contrato: &nbsp;</b></label><br>
        <input type="date" id="data_inicio" name="data_inicio" value="<?php echo ($contrato->data_inicio ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="observacoes" style="margin:0px"><b>Observações: &nbsp;</b></label><br>
        <input type="text" id="observacoes" name="observacoes" value="<?php echo ($contrato->observacoes ?? ''); ?>" size="120">
    </div>

    <input type="hidden" id="data_fim" name="data_fim" value="<?php echo ($contrato->data_fim ?? ''); ?>">
    <input type="hidden" id="status" name="status" value="<?php echo ($contrato->status ?? '0'); ?>">
    <input type="hidden" id="acao" name="acao" value="<?php echo $acao; ?>">

    <button type="submit" value="Gravar" class="btn botao">Gravar</button>
</form>