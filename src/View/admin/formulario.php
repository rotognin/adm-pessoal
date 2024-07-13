<form class="col-12" method="post" action="index.php?control=admin&action=gravar">
    <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
    
    <div class="form-group">
        <label for="id" style="margin:0px"><b>ID: &nbsp;</b></label><br>
        <input type="number" id="id" name="id" readonly value="<?php echo ($admin->id ?? '0'); ?>">
    </div>
    <div class="form-group">
        <label for="nome" style="margin:0px"><b>Nome: &nbsp;</b></label><br>
        <input type="text" id="nome" name="nome" value="<?php echo ($admin->nome ?? ''); ?>" size="60" autofocus>
    </div>
    <div class="form-group">
        <label for="email" style="margin:0px"><b>E-mail: &nbsp;</b></label><br>
        <input type="text" id="email" name="email" value="<?php echo ($admin->email ?? ''); ?>" size="60">
    </div>
    <div class="form-group">
        <label for="login" style="margin:0px"><b>Login: &nbsp;</b></label><br>
        <input type="text" id="login" name="login" value="<?php echo ($admin->login ?? ''); ?>" size="60" 
        <?php echo ($acao == 'alterar') ? 'readonly' : ''; ?> >
    </div>
    <div class="form-group">
        <label for="senha" style="margin:0px"><b>Senha: &nbsp;</b></label><br>
        <input type="password" id="senha" name="senha" value="<?php echo ($admin->senha ?? ''); ?>">
    </div>

    <div class="form-group">
        <?php 
            $nivel = ($admin->nivel ?? 1);
        ?>
        <label for="nivel" style="margin:0px"><b>Nível: &nbsp;</b></label><br>
        <select name="nivel" id="nivel">
            <option value="0" <?php echo ($nivel == 0) ? 'selected' : ''; ?>>Administrador &nbsp;&nbsp;</option>
            <option value="1" <?php echo ($nivel == 1) ? 'selected' : ''; ?>>Usuário Comum &nbsp;&nbsp;</option>
            <option value="2" <?php echo ($nivel == 2) ? 'selected' : ''; ?>>Convidado &nbsp;&nbsp;</option>
        </select>
    </div>

    <input type="hidden" id="status" name="status" value="<?php echo ($admin->status ?? '0'); ?>">
    <input type="hidden" id="acao" name="acao" value="<?php echo $acao; ?>">

    <button type="submit" value="Gravar" class="btn botao">Gravar</button>
</form>