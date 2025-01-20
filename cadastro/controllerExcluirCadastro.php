<?php
session_start();
include('classCadastrarUsuario.php');

$dadosJson = file_get_contents('php://input');
$dados = json_decode($dadosJson, true);

if (json_last_error() === JSON_ERROR_NONE && is_array($dados) && !empty($dados)) {
    // Os dados são válidos e podem ser processados
    $id = $dados['id'];
    $newMatricula = $id;
    $novoUsuario = new cadastroUsuario();
    $novoUsuario->setMatricula($newMatricula);
    $novoUsuario->deletarUsuario();
    
} else {
    // Tratar erros de decodificação ou dados inválidos
    echo 'Erro ao processar os dados: ' . json_last_error_msg();
}

?>