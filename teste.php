<?php
    require 'autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Relatorios\GerarRelatorioMensalDigitalizacao;

    $unidade = '';
    $ano = '2025';
	$perfil = '01';


    $relatorioMensalDigitalizacao = new GerarRelatorioMensalDigitalizacao(
        $unidade,
        $ano,
		$perfil
    );

    $relatorioMensalDigitalizacao->relatorioCargaTotalDigitalizacao();   