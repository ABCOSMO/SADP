<?php
    require 'autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Relatorios\GerarPDFMensalDigitalizacao;

    $unidade = '';
    $ano = '2025';
	$perfil = '01';


    $relatorioMensalDigitalizacao = new GerarPDFMensalDigitalizacao(
        $unidade,
        $ano,
		$perfil
    );

    $relatorioMensalDigitalizacao->relatorioMensalDigitalizacaoPDF();   