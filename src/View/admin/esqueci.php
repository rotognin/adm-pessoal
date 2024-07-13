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
            <p>Por favor, informe o login e o e-mail cadastrado. O sistema irá te enviar um 
               e-mail com um link para redefinir a sua senha.</p>
            <br>
            <form method="post" action="index.php?action=enviaremail&control=admin">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">

                <div class="form-group">
                    <label for="login" style="margin:0px"><b>Login: </b></label><br>
                    <input type="text" id="login" name="login" size="40" autofocus>
                </div>
                <div class="form-group">
                    <label for="email" style="margin:0px"><b>E-mail: </b></label><br>
                    <input type="text" id="email" name="email" size="40">
                </div>
                <button type="submit" name="submit" class="btn botao" data-toggle="modal" data-target="#modalAguarde">Enviar</button>
            </form>
            <br>
            <?php include_once ('./lib/mensagem.php'); ?>
            <br><br>
            <p><a class="acesso" href="index.php">Voltar para o início.</a></p>
        </div>
    </div>
    <?php include 'html/scriptsjs.php'; ?>
    <?php include 'html/aguarde.php'; ?>
</body>
</html>