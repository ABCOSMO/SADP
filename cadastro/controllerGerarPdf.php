<?php
session_start();
require '../autoload.php';

use FADPD\ConectarUsuario\ConectarBD;
use FADPD\Relatorios\GerarPDFDiarioDigitalizacao;

$unidade = $_GET['unidade'];
$dataFinal = $_GET['dataFinal'];
$dataInicial = $_GET['dataInicial'];
$perfil = $_SESSION['privilegio'];

$relatorioDiarioDigitalizacao = new GerarPDFDiarioDigitalizacao(
        $unidade,
        $dataInicial,
        $dataFinal,
		$perfil
    );

$relatorioDiarioDigitalizacao->relatorioDiarioDigitalizacaoPDF(); 

?>