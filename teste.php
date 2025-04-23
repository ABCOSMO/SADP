<?php
    session_start();
    require 'autoload.php';
    
    use SADP\ConectarUsuario\ConectarBD;
    use SADP\Cadastrar\CadastrarCarga;
    
    // Recebe os dados JSON
  /*  
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if ($data === null) {
        // Erro ao decodificar o JSON
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'error' => 'Dados JSON inválidos']);
        exit;
    }
*/
       $dataCadastrada = '22/04/2025';
        $cargaAnterior = '1.000';
        $cargaRecebida = '65.000';
        $cargaImpossibilitada = '0';
        $cargaDigitalizada = '63.000';
        $cargaResto = '3.000';

    //if(isset($_SESSION['matricula'])) {  
		$unidade = 'CDIP BRASÍLIA ';
        $matricula = '81342497';
         // Agora você pode acessar os dados usando $data
        
    
        /*
        $conteudo = $dataCadastrada . " " . $unidade . " " . $matricula . " " . $cargaAnterior . " " . $cargaRecebida . " " . 
        $cargaImpossibilitada . " " . $cargaDigitalizada . " " . $cargaResto;
		
		file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);
        */
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
   // }
?>