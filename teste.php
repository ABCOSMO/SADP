<?php
    require 'autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Relatorios\GerarRelatorioDiarioSE;

    $unidade = 'CDIP BRASÍLIA';
	//$unidade = mb_convert_encoding($unidade, 'UTF-8', 'ISO-8859-1');
    $dataInicial = '2025-03-01';
	$dataFinal = '2025-05-30';
	$perfil = '02';


    $relatorioDiarioDigitalizacao = new GerarRelatorioDiarioSE(
        $unidade,
        $dataInicial,
        $dataFinal,
		$perfil
    );

    $relatorioDiarioDigitalizacao->relatorioDiarioSE();  