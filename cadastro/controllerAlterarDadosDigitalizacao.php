<?php
    session_start();
    require '../autoload.php';
    
    use SADP\ConectarUsuario\ConectarBD;
    //use SADP\Cadastrar\CadastrarUsuario;
    
    / Recebe os dados JSON
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if ($data === null) {
        // Erro ao decodificar o JSON
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'error' => 'Dados JSON inválidos']);
        exit;
    }

    // Agora você pode acessar os dados usando $data
    $cargaAnterior = $data['cargaAnterior'];
    $cargaRecebida = $data['cargaRecebida'];
    file_put_contents(__DIR__ . "/meu_arquivo.txt", $cargaRecebida);

    /*
    if(isset($_POST['novaMatricula']))
    {  
		$newUsuario = $_POST['novoNome'];
        $newMatricula = $_POST['novaMatricula'];
        $newEmail = $_POST['novoEmail'];
        $newTelefone = $_POST['novoTelefone'];
		$newCelular = $_POST['novoCelular'];
        $newUnidade = $_POST['novaUnidade'];
        $newPerfil = $_POST['novoPerfil'];
        $newSenha = '';
		
		$conteudo = $newUsuario . " " . $newMatricula . " " . $newEmail . " " . $newTelefone . " " . $newCelular . " " . 
        $newUnidade . " " . $newPerfil . " " . $newSenha;
		
		file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);

        $novoUsuario = new CadastrarUsuario(
            $newUsuario,
            $newMatricula,
            $newEmail,
            $newTelefone,
			$newCelular,
            $newUnidade,
            $newPerfil,
            $newSenha
        );
        
        $novoUsuario->editarUsuario();
    }
        */
?>