<?php
session_start();
require '../autoload.php';

use FADPD\ConectarUsuario\ConectarBD;
use FADPD\Cadastrar\ExcluirCargaDigitalizacao;

$dadosJson = file_get_contents('php://input');
$dados = json_decode($dadosJson, true);


if (json_last_error() === JSON_ERROR_NONE && is_array($dados) && !empty($dados)) {
    // Os dados são válidos e podem ser processados
    $newMatricula = $dados['id'];
    $newData = $dados['data'];
    $informar = $newData ." ". $newMatricula;
    $excluirCargaDigitalizacao = new ExcluirCargaDigitalizacao(
        $newMatricula,
        $newData
    );
    $excluirCargaDigitalizacao->alterarDados();

    /*file_put_contents(__DIR__ . '/matricula.txt', $informar);*/
    
} else {
    // Tratar erros de decodificação ou dados inválidos
    $errou =  'Erro ao processar os dados: ' . json_last_error_msg();
}

?>