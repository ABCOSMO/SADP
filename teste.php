<?php
    require 'autoload.php';
    
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Relatorios\CalcularData;
    use FADPD\Relatorios\GerarRelatorioDigitalizacao;

    $unidade = 'CDIP BRASÍLIA';
    $matricula = '81342497';
    $perfil = '01';
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