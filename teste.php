<?php
session_start();
require 'autoload.php';

use FADPD\ConectarUsuario\ConectarBD;
use FADPD\Relatorios\GerarRelatorioMensalDigitalizacao;

//$dadosJson = file_get_contents('php://input');
//$dados = json_decode($dadosJson, true);

//if (json_last_error() === JSON_ERROR_NONE && is_array($dados) && !empty($dados)) {
    // Os dados são válidos e podem ser processados
    $unidade = "CDIP BRASÍLIA";
    $ano = "2025";
	$perfil = "01";
    /*$informar = $unidade ." ". $dataInicial ." ". $dataFinal;
    file_put_contents(__DIR__ . '/dados.txt', $informar);*/

    $relatorioMensalDigitalizacao = new GerarRelatorioMensalDigitalizacao(
        $unidade,
        $ano,
		$perfil
    );
	
    $relatorioMensalDigitalizacao->relatorioCargaTotalDigitalizacao();   
    
//} else {
    // Tratar erros de decodificação ou dados inválidos
    //$errou =  'Erro ao processar os dados: ' . json_last_error_msg();
//}


?>