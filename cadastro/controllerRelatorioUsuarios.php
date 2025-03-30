<?php
    session_start();
    require '../autoload.php';
    
    use SADP\ConectarUsuario\ConectarBD;
    use SADP\Lista\ListarUsuario;
    use SADP\Lista\Selecionarunidade;

    $unidade = $_SESSION['unidade'];
    $matricula = $_SESSION['matricula'];
    
    $gerarRelatorioUsuarios = new ListarUsuario();
    $gerarLista = new SelecionarUnidade();

    $gerarRelatorioUsuarios->mostrarUsuario();
    //$gerarLista->obterUnidadeJson();