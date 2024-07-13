<!DOCTYPE html>
<html>
<?php include ('./html/head.php'); ?>
<body>
    <div class="container-fluid">
        <h3 class="azul">Visitantes</h3>
        
        <nav class="navbar navbar-expand-lg navbar-dark fundo-azul">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link text-white" href="index.php?action=contratos&control=contrato">Contratos</a>
                    <span class="nav-link text-white">|</span>
                    <a class="nav-link text-white" href="index.php?action=menu">Início</a>
                </div>
            </div>
        </nav>
        <br>

        <h4>Contrato: </h4>
        <p><b>
            <?php
                echo $contrato->numero . ' - ' . $contrato->nome;
            ?>
        </b></p>

        <?php if (NIVEL_ADMIN[$_SESSION['usuNivel']] != 'Convidado'){ ?>
            <form method="post" action="index.php?action=novo&control=visitante">
                <input type="hidden" name="contrato_id" value="<?php echo $contrato->id; ?>">
                <button type="submit" class="btn botao">Novo Visitante</button>
            </form>
        <?php } ?>
        <br>

        <?php include_once ('./lib/mensagem.php'); ?>

        <table class="table table-hover table-sm">
            <thead class="fundo-azul branco">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Parentesco</th>
                    <th>Ação</th>
                    <th>Situação</th>
                </tr>
            </thead>
            <tbody>

            <?php
                if (isset($visitantes)) {
                    foreach($visitantes as $visitante){
                        echo '<tr>';
                            echo '<td>' . $visitante->id . '</td>';
                            echo '<td>' . $visitante->nome . '</td>';
                            echo '<td>' . $visitante->email . '</td>';
                            echo '<td>' . $visitante->parentesco . '</td>';

                            if (NIVEL_ADMIN[$_SESSION['usuNivel']] != 'Convidado'){
                                echo '<td>';
                                    echo '<form method="post" action="index.php?control=visitante&action=alterar">';
                                        echo '<input type="hidden" name="visitante_id" value="' . $visitante->id . '">';
                                        echo '<input type="hidden" name="contrato_id" value="' . $visitante->contrato_id . '">';
                                        echo '<input type="submit" style="margin-left: 10px" value="Alterar" class="btn botao btn-sm float-left">';
                                    echo '</form>';
                                echo '</td>';

                                if ($visitante->status == 0){
                                    echo '<td>';
                                        echo '<form method="post" action="index.php?control=visitante&action=inativar">';
                                            echo '<input type="hidden" name="visitante_id" value="' . $visitante->id . '">';
                                            echo '<input type="hidden" name="contrato_id" value="' . $visitante->contrato_id . '">';
                                            echo 'Ativo    ';
                                            echo '<input type="submit" style="margin-left: 10px" value="Inativar" class="btn botao btn-sm">';
                                        echo '</form>';
                                    echo '</td>';
                                } else {
                                    echo '<td>';
                                        echo '<form method="post" action="index.php?control=visitante&action=ativar">';
                                            echo '<input type="hidden" name="visitante_id" value="' . $visitante->id . '">';
                                            echo '<input type="hidden" name="contrato_id" value="' . $visitante->contrato_id . '">';
                                            echo 'Inativo    ';
                                            echo '<input type="submit" style="margin-left: 10px" value="Ativar" class="btn botao btn-sm">';
                                        echo '</form>';
                                    echo '</td>';
                                }
                            }
                            
                        echo '</tr>';
                    }
                } else {
                    echo '<tr>';
                        echo '<td colspan="6"><i>Nenhum visitante cadastrado para este contrato...</i></td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    <?php include ('./html/scriptsjs.php'); ?>
</body>
</html>