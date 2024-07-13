<!DOCTYPE html>
<html>
<?php include ('./html/head.php'); ?>
<body>
    <div class="container-fluid">
        <h3 class="azul">Contratos</h3>
        
        <nav class="navbar navbar-expand-lg navbar-dark fundo-azul">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                <?php if (NIVEL_ADMIN[$_SESSION['usuNivel']] != 'Convidado'){ ?>
                    <a class="nav-link text-white" href="index.php?action=novo&control=contrato">Novo Contrato</a>
                    <span class="nav-link text-white">|</span>
                <?php } ?>
                    <a class="nav-link text-white" href="index.php?action=menu">Início</a>
                </div>
            </div>
        </nav>
        <br>

        <div id="aguarde" class="card text-center d-none">
            <h1>Aguarde...</h1>
            <br>
        </div>

        <?php include_once ('./lib/mensagem.php'); ?>

        <table class="table table-hover table-sm">
            <thead class="fundo-azul branco">
                <tr>
                    <th>ID</th>
                    <th>Número</th>
                    <th>Data Início</th>
                    <th>Nome</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            <?php
                foreach($contratos as $contrato){
                    echo '<tr>';
                        echo '<td>' . $contrato->id . '</td>';
                        echo '<td>' . $contrato->numero . '</td>';
                        echo '<td>' . ajustarData($contrato->data_inicio) . '</td>';
                        echo '<td>' . $contrato->nome . '</td>';
                        echo '<td>';
                            echo '<form method="post" action="index.php?control=visitante&action=visitantes">';
                                echo '<input type="hidden" name="contrato_id" value="' . $contrato->id . '">';
                                echo '<input type="submit" style="margin-left: 10px" value="Visitantes" class="btn botao btn-sm float-left">';
                            echo '</form>';
                        echo '</td>';

                        if (NIVEL_ADMIN[$_SESSION['usuNivel']] != 'Convidado'){
                            echo '<td>';
                                echo '<form method="post" action="index.php?control=contrato&action=alterar">';
                                    echo '<input type="hidden" name="contrato_id" value="' . $contrato->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Alterar" class="btn botao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';
                            echo '<td>';
                                echo '<form method="post" action="index.php?control=contrato&action=finalizar" onsubmit="return confirmarFinalizacao();">';
                                    echo '<input type="hidden" name="contrato_id" value="' . $contrato->id . '">';
                                    echo '<input type="submit" style="margin-left: 10px" value="Finalizar" class="btn botao-atencao btn-sm float-left">';
                                echo '</form>';
                            echo '</td>';
                        }
                        
                        echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    <?php include ('./html/scriptsjs.php'); ?>
    <script type="application/javascript" src="html/script.js?version=1"></script>
</body>
</html>