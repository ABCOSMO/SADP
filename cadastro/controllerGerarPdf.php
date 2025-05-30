<?php
session_start();
require '../autoload.php';

use FADPD\ConectarUsuario\ConectarBD;
use FADPD\Cadastrar\CadastrarUsuario;

$unidade = $_GET['unidade'];
$dataFinal = $_GET['dataFinal'];
$dataInicial = $_GET['dataInicial'];
$perfil = $_SESSION['privilegio'];

?>