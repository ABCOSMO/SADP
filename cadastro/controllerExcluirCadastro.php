<?php
session_start();
require '../autoload.php';

use FADPD\ConectarUsuario\ConectarBD;
use FADPD\Cadastrar\ExcluirUsuario;

$dadosJson = file_get_contents('php://input');
$dados = json_decode($dadosJson, true);


if (json_last_error() === JSON_ERROR_NONE && is_array($dados) && !empty($dados)) {
    // Os dados são válidos e podem ser processados
    $id = $dados['id'];
    $newMatricula = $id;
    $excluirUsuario = new ExcluirUsuario($newMatricula);
    $excluirUsuario->alterarStatus();
    
} else {
    // Tratar erros de decodificação ou dados inválidos
    $errou =  'Erro ao processar os dados: ' . json_last_error_msg();
    /*file_put_contents(__DIR__ . '/matricula.txt', $errou);*/
}

?>