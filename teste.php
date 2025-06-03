<?php
    require 'autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Cadastrar\ExcluirCargaDigitalizacao;

    $matricula = '88888888';
    $dataDigitalizacao = '25/05/2025';


    $excluirCargaDigitalizacao = new ExcluirCargaDigitalizacao(
        $matricula,
        $dataDigitalizacao
    );
    $excluirCargaDigitalizacao->excluirSEOcorrencias();
    