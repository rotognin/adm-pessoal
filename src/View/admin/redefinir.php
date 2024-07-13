<!DOCTYPE html>
<html>
<?php 
    include ('./html/head.php'); 
?>
<body>
    <div class="container">
        <br>
        <div class="card text-center">
            <br>
            <h2>Recuperação de senha</h2>
            <p>Olá, <?php echo $admin->nome; ?>.</p>
            <p>Por favor, redefina a sua senha de acesso ao sistema administrativo.</p>
            <br>
            <form method="post" action="index.php?action=redefinir&control=admin">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">
                <input type="hidden" name="hash" value="<?php echo $admin->hash ?>">
                <input type="hidden" id="admin_id" name="admin_id" value="<?php echo $admin->id; ?>">

                <div class="form-group">
                    <label for="senha" style="margin:0px"><b>Senha: </b></label><br>
                    <input type="password" id="senha" name="senha" size="40" autofocus>
                </div>
                <div class="form-group">
                    <label for="senharepetida" style="margin:0px"><b>Redigite a Senha: </b></label><br>
                    <input type="password" id="senharepetida" name="senharepetida" size="40">
                </div>
                <button type="submit" name="submit" class="btn botao" data-toggle="modal" data-target="#modalAguarde">Enviar</button>
            </form>
            <br>
            <?php include_once ('./lib/mensagem.php'); ?>
            <br><br>
            <p><a class="acesso" href="index.php">Voltar para o login.</a></p>
        </div>
    </div>
    <?php include 'html/scriptsjs.php'; ?>
    <?php include 'html/aguarde.php'; ?>
</body>
</html>