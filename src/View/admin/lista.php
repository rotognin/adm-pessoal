<!DOCTYPE html>
<html>
<?php include ('./html/head.php'); ?>
<body>
    <div class="container-fluid">
        <h3 class="azul">Usuários do Sistema</h3>
        
        <nav class="navbar navbar-expand-lg navbar-dark fundo-azul">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link text-white" href="index.php?action=novo&control=admin">Novo Usuário</a>
                    <span class="nav-link text-white">|</span>
                    <a class="nav-link text-white" href="index.php?action=menu">Início</a>
                </div>
            </div>
        </nav>
        <br>

        <?php
            $regra = 'info';
            include_once ('./lib/mensagem.php');
        ?>

        <table class="table table-hover table-sm">
            <thead class="fundo-azul branco">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Login</th>
                    <th>Situação</th>
                    <th>Nível</th>
                    <th>Ação</td>
                </tr>
            </thead>
            <tbody>

            <?php
                foreach($admins as $admin){
                    $acao = ($admin->status == 0) ? 'inativar' : 'ativar';

                    echo '<tr>';                    
                        echo '<td>' . $admin->id . '</td>';
                        echo '<td>' . $admin->nome . '</td>';
                        echo '<td>' . $admin->login . '</td>';
                        echo '<td>';

                        if ($admin->id != $_SESSION['usuId'] && NIVEL_ADMIN[$admin->nivel] != 'Administrador'){
                            echo '<form method="post" action="index.php?control=admin&action=' . $acao . '">';
                                echo '<input type="hidden" name="id" value="' . $admin->id . '">';
                                echo STATUS_ADMIN[$admin->status];
                                echo '<input type="submit" style="margin-left: 10px" value="' . ucfirst($acao) . '" class="btn botao btn-sm">';
                            echo '</form>';
                        } else {
                            echo STATUS_ADMIN[$admin->status];
                        }

                        echo '</td>';
                        echo '<td>' . NIVEL_ADMIN[$admin->nivel] . '</td>';
                        echo '<td>';
                            echo '<form method="post" action="index.php?control=admin&action=alterar">';
                                echo '<input type="hidden" name="id" value="' . $admin->id . '">';
                                echo '<input type="submit" style="margin-left: 10px" value="Alterar" class="btn botao btn-sm">';
                            echo '</form>';
                        echo '</td>';
                    echo '</tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

    <?php include ('./html/scriptsjs.php'); ?>
</body>
</html>