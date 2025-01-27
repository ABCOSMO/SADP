<?php
session_start();
include('classAlterarCadastro.php');
$matricula = $_GET['matricula'];
$alterarUsuario = new AlterarUsuario();
$alterarUsuario->alterarDadosUsuario($matricula);
