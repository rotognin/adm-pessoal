<!DOCTYPE html>
<html>
<?php include ('./html/head.php'); ?>
<body>
    <div class="container-fluid">
        <h3 class="azul">Relatório de Visitas</h3>
        
        <nav class="navbar navbar-expand-lg navbar-dark fundo-azul">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link text-white" href="index.php?action=menu">Início</a>
                </div>
            </div>
        </nav>

        <h4 style="margin-top:5px">Filtros: </h4>

        <form class="col-12" method="post" target="_blank" action="index.php?action=filtrar&control=relatorio">
            <input type="hidden" name="_token" value="<?php echo $_SESSION['csrf']; ?>">

            <div class="form-group" style="margin:0px">
                <label for="contratos">Contrato: </label>
                <select name="contrato" id="contrato">
                    <option value="0">Todos</option>
                    <?php
                        foreach($contratos as $contrato){
                            echo '<option value="' . $contrato->id . '">';
                            echo $contrato->numero . ' - ' . $contrato->nome;
                            echo '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-group" style="margin:0px">
                Período: &nbsp;&nbsp;
                <input type="date" id="data_inicio" name="data_inicio" value="<?php echo $datas['data_inicio']; ?>">&nbsp;&nbsp;até&nbsp;&nbsp;
                <input type="date" id="data_fim" name="data_fim" value="<?php echo $datas['data_fim']; ?>">
            </div>
            <div class="form-group" style="margin:5px 0px 0px 0px">
                Exibir Visitas:&nbsp;&nbsp;
                <input type="radio" id="todas" name="situacao" value="todas" checked>
                <label for="todas">Todas</label>&nbsp;&nbsp;
                <input type="radio" id="Agendadas" name="situacao" value="agendada">
                <label for="agendadas">Agendadas</label>&nbsp;&nbsp;
                <input type="radio" id="realizadas" name="situacao" value="realizada">
                <label for="realizadas">Realizadas</label>&nbsp;&nbsp;
                <input type="radio" id="canceladas" name="situacao" value="cancelada">
                <label for="canceladas">Canceladas</label>&nbsp;&nbsp;
            </div>
            <button id="filtrar" class="fundo-azul branco" style="margin:0px 0px 5px 0px" type="submit" name="submit" value="Filtrar">&nbsp;&nbsp;Filtrar&nbsp;&nbsp;</button>
        </form>

        <?php include_once ('./lib/mensagem.php'); ?>
    </div>

    <?php include ('./html/scriptsjs.php'); ?>
</body>
</html>