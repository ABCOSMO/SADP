<?php
session_start();
require '../autoload.php';

use SADP\ConectarUsuario\ConectarBD;
use SADP\Cadastrar\AlterarCadastro;

$matricula = $_GET['matricula'];
$alterarUsuario = new AlterarCadastro();
$alterarUsuario->alterarDadosUsuario($matricula);
