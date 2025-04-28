<?php
    session_start();
    require '../autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Lista\ListarUsuario;
    use FADPD\Lista\Selecionarunidade;

    $unidade = $_SESSION['unidade'];
    $matricula = $_SESSION['matricula'];
    
    $gerarRelatorioUsuarios = new ListarUsuario();
    $gerarLista = new SelecionarUnidade();

    $gerarRelatorioUsuarios->mostrarUsuario();
    //$gerarLista->obterUnidadeJson();