<?php
    session_start();
    require '../autoload.php';
    
    use SADP\ConectarUsuario\ConectarBD;
    use SADP\Lista\ListarUsuario;

    $unidade = $_SESSION['unidade'];
    $matricula = $_SESSION['matricula'];
    
    $gerarRelatorioUsuarios = new ListarUsuario();

    $gerarRelatorioUsuarios->mostrarUsuario();