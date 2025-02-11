<?php
session_start();
include_once('../src/ConectarUsuario/ConectarBD.php');
include('../src/Cadastar/ExcluirUsuario.php');

use SADP\Cadastar\ExcluirUsuario;

$dadosJson = file_get_contents('php://input');
$dados = json_decode($dadosJson, true);

if (json_last_error() === JSON_ERROR_NONE && is_array($dados) && !empty($dados)) {
    // Os dados são válidos e podem ser processados
    $id = $dados['id'];
    $newMatricula = $id;
    $excluirUsuario = new ExcluirUsuario($newMatricula);
    $excluirUsuario->deletarUsuario();
    
} else {
    // Tratar erros de decodificação ou dados inválidos
    echo 'Erro ao processar os dados: ' . json_last_error_msg();
}

?>