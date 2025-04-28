<?php
session_start();
require '../autoload.php';

use FADPD\ConectarUsuario\ConectarBD;
use FADPD\Cadastrar\AlterarCadastro;

$matricula = $_GET['matricula'];
$alterarUsuario = new AlterarCadastro();
$alterarUsuario->alterarDadosUsuario($matricula);
