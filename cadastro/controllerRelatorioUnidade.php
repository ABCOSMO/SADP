<?php
    session_start();
    require '../autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Relatorios\GerarRelatorioUnidade;

    $unidade = $_SESSION['unidade'];
    $matricula = $_SESSION['matricula'];

    $gerarRelatorioDigitalizacao = new GerarRelatorioUnidade(
        $matricula,
        $unidade,
    );

    $gerarRelatorioDigitalizacao->relatorioUnidade();