<!DOCTYPE html>
<html>
<?php
include('./html/head.php');
?>

<body>
    <div class="container">
        <br>

        <div class="card text-center borda-redonda p-2 pt-4" style="border:1px solid black">
            <!--img class="align-self-center mr-3" src="img/logo_png_menor.png" alt="Logo do Lar"-->
            <h3><span style="color:#333399">Acesso ao Sistema Administrativo</span></h3>
            <br>
            <form method="post" action="index.php?action=login">
                <div class="form-group">
                    <label for="login">&nbsp;<b>Login:</b> &nbsp;</label>
                    <input type="text" id="login" name="login" size="30px" autofocus>
                </div>
                <div class="form-group">
                    <label for="senha"><b>Senha:</b> &nbsp;</label>
                    <input type="password" id="senha" name="senha" size="30px">
                </div>
                <input type="submit" value="Entrar" class="btn botao">
            </form>
            <br>
            <p>Esqueceu a senha? <a class="acesso" href="index.php?action=esqueci&control=admin">Clique aqui.</a></p>
            <?php
            $regra = 'danger';
            include_once('./lib/mensagem.php');
            ?>
            <br>
        </div>
    </div>
    <?php include('./html/scriptsjs.php'); ?>
</body>

</html>