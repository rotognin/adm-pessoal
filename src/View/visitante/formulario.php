<form class="col-12" method="post" action="index.php?control=visitante&action=gravar">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
    
    <div class="form-group">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label><br>
        <input type="number" id="id" name="id" readonly value="<?php echo ($visitante->id ?? '0'); ?>">
    </div>
    <div class="form-group">
        <label for="nome" style="margin:0px"><b>Nome: &nbsp;</b></label><br>
        <input type="text" id="nome" name="nome" value="<?php echo ($visitante->nome ?? ''); ?>" size="80" autofocus>
    </div>
    <div class="form-group">
        <label for="email" style="margin:0px"><b>E-mail: &nbsp;</b></label><br>
        <input type="text" id="email" name="email" value="<?php echo ($visitante->email ?? ''); ?>" size="80">
    </div>
    <div class="form-group">
        <label for="contato" style="margin:0px"><b>Contato: &nbsp;</b></label><br>
        <input type="text" id="contato" name="contato" value="<?php echo ($visitante->contato ?? ''); ?>" size="80">
    </div>
    <div class="form-group">
        <label for="parentesco" style="margin:0px"><b>Parentesco: &nbsp;</b></label><br>
        <input type="text" id="parentesco" name="parentesco" value="<?php echo ($visitante->parentesco ?? ''); ?>">
    </div>
    <div class="form-group">
        <label for="observacoes" style="margin:0px"><b>Observações: &nbsp;</b></label><br>
        <input type="text" id="observacoes" name="observacoes" value="<?php echo ($visitante->observacoes ?? ''); ?>" size="120">
    </div>

    <input type="hidden" id="status" name="status" value="<?php echo ($visitante->status ?? '0'); ?>">
    <input type="hidden" id="contrato_id" name="contrato_id" value="<?php echo ($visitante->contrato_id ?? $contrato->id) ?>">
    <input type="hidden" id="acao" name="acao" value="<?php echo $acao; ?>">

    <button type="submit" value="Gravar" data-toggle="modal" data-target="#modalAguarde" class="btn botao">Gravar</button>
</form>

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