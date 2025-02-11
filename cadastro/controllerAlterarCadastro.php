<?php
session_start();
include_once('../src/ConectarUsuario/ConectarBD.php');
include('../src/Cadastrar/AlterarCadastro.php');

use SADP\Cadastrar\AlterarUsuario;

$matricula = $_GET['matricula'];
$alterarUsuario = new AlterarUsuario();
$alterarUsuario->alterarDadosUsuario($matricula);
