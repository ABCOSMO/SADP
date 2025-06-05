<?php
session_start();
require '../autoload.php';

use FADPD\ConectarUsuario\ConectarBD;
use FADPD\Relatorios\GerarPDFMensalDigitalizacao;

$unidade = $_GET['unidade'];
$ano = $_GET['ano'];
$perfil = $_SESSION['privilegio'];

$relatorioMensalDigitalizacao = new GerarPDFMensalDigitalizacao(
      $unidade,
      $ano,
      $perfil
    );

$relatorioMensalDigitalizacao->relatorioMensalDigitalizacaoPDF(); 

?>