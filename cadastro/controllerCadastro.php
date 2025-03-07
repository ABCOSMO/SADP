<?php
    session_start();
    require '../autoload.php';
    
    use SADP\ConectarUsuario\ConectarBD;
    use SADP\Cadastrar\CadastrarUsuario;
 
    if(isset($_POST['novaMatricula']))
    {  
		$newUsuario = $_POST['novoNome'];
        $newMatricula = $_POST['novaMatricula'];
        $newEmail = $_POST['novoEmail'];
        $newTelefone = $_POST['novoTelefone'];
        $newCelular = $_POST['novoCelular'];
        $newUnidade = $_POST['novaUnidade'];
        $newPerfil = $_POST['novoPerfil'];
        $newSenha = $_POST['newPassword'];

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
            //password_hash($newSenha, PASSWORD_DEFAULT) // Criptografa a senha
        );
        
        $novoUsuario->createUsuario();
    }
?>