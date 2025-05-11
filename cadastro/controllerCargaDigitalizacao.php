<?php
    session_start();
    require '../autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Relatorios\CalcularData;
    use FADPD\Relatorios\GerarRelatorioDigitalizacao;

    $unidade = $_SESSION['unidade'];
    $matricula = $_SESSION['matricula'];
    $perfil = $_SESSION['privilegio'];
    date_default_timezone_set('America/Sao_Paulo');
    $data = new DateTime('now');
    
    $selecionarData = new CalcularData;

    $dataAnterior = $selecionarData->calcularDataAnterior($data);
    $dataPosterior = $selecionarData->calcaularDataPosterior($data);

    $gerarRelatorioDigitalizacao = new GerarRelatorioDigitalizacao(
        $perfil,
        $matricula,
        $unidade,
        $dataAnterior,
        $dataPosterior
    );

    $gerarRelatorioDigitalizacao->relatorioDiarioDigitalizacao();