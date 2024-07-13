<!DOCTYPE html>
<html>
<?php include 'html/head.php'; ?>

<body>
    <div class="container-fluid">
        <h3 class="azul">Visitante</h3>

        <nav class="navbar navbar-expand-lg navbar-dark fundo-azul">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link text-white" href="index.php?action=contratos&control=contrato">Contratos</a>
                    <span class="nav-link text-white">|</span>
                    <a class="nav-link text-white" href="index.php?action=visitantes&control=visitante&contrato_id=<?php echo $contrato->id; ?>">Visitantes</a>
                    <span class="nav-link text-white">|</span>
                    <a class="nav-link text-white" href="index.php?action=menu">Início</a>
                </div>
            </div>
        </nav>

        <br>
        <?php include_once 'lib/mensagem.php'; ?>
        <?php require('formulario.php'); ?>
    </div>

    <?php include 'html/scriptsjs.php'; ?>
</body>

</html>