<?php
    session_start();
    require '../autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Cadastrar\CadastrarCarga;
    
    // Recebe os dados JSON
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if ($data === null) {
        // Erro ao decodificar o JSON
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'error' => 'Dados JSON inválidos']);
        exit;
    }
		$unidade  = $data['unidade'];
        $dataCadastrada = $data['novaData'];
        $cargaAnterior = $data['cargaAnterior'];
        $cargaRecebida = $data['cargaRecebida'];
        $cargaImpossibilitada = $data['cargaImpossibilitada'];
        $cargaDigitalizada = $data['cargaDigitalizada'];
        $cargaResto = $data['cargaResto'];

    if(isset($_SESSION['matricula'])) {  
        $matricula = $_SESSION['matricula'];
         // Agora você pode acessar os dados usando $data
        
        $conteudo = $dataCadastrada . " " . $unidade . " " . $matricula . " " . $cargaAnterior . " " . $cargaRecebida . " " . 
        $cargaImpossibilitada . " " . $cargaDigitalizada . " " . $cargaResto;
		
		/*file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);*/
        
        $alterarDadosDigitalizacao = new CadastrarCarga(
            $dataCadastrada,
            $unidade,
            $matricula,
            $cargaAnterior,
			$cargaRecebida,
            $cargaImpossibilitada,
            $cargaDigitalizada,
            $cargaResto
        );
        
        $alterarDadosDigitalizacao->alterarDadosCarga();
    }
?>