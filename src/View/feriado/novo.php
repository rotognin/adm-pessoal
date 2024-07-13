<!DOCTYPE html>
<html>
<?php include('./html/head.php'); ?>

<body>
    <div class="container-fluid">
        <h3>Novo Feriado</h3>

        <nav class="navbar navbar-expand-lg navbar-dark fundo-azul">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link text-white" href="index.php?action=menu">Início</a>
                    <span class="nav-link text-white">|</span>
                    <a class="nav-link text-white" href="index.php?action=feriados&control=feriado">Feriados</a>
                </div>
            </div>
        </nav>

        <br>
        <?php include_once('./lib/mensagem.php'); ?>
        <?php require('formulario.php'); ?>
    </div>

    <?php include('./html/scriptsjs.php'); ?>
</body>

</html>