<?php
    session_start();
    require '../autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Cadastrar\AlterarSEOcorrencia;
    
    // Recebe os dados JSON
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if ($data === null) {
        // Erro ao decodificar o JSON
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'error' => 'Dados JSON inválidos']);
        exit;
    }
    
	$unidade = $data['unidade'];
	$matricula = $_SESSION['matricula'];
    $dataDigitalizacao = $data['data_digitalizacao'];
    $seStates = $data['se_states']; // Este é o array que queremos visualizar
    $ocorrencia = $data['ocorrencia']; 

    /*
    // Converte o array $seStates para uma string legível
    // O 'true' no segundo parâmetro faz com que a função retorne a string, em vez de imprimi-la.
    $seStatesString = print_r($seStates, true); // Você também pode usar var_export($seStates, true);
    
	$conteudo = "Unidade: " . $unidade . "\n";
    $conteudo .= "Matrícula: " . $matricula . "\n";
    $conteudo .= "Data Digitalizacao: " . $dataDigitalizacao . "\n";
    $conteudo .= "Status SE:\n" . $seStatesString . "\n"; // Adiciona a string formatada do array
    $conteudo .= "Ocorrencia: " . $ocorrencia;
    
    file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);

exit;
    */
        $alterarDadosDigitalizacao = new AlterarSEOcorrencia(
            $unidade,
			$matricula,
			$dataDigitalizacao,
            $seStates,
            $ocorrencia
        );
        
        $alterarDadosDigitalizacao->alterarDadosSE();
    
?>