<?php
    session_start();
    include('classCadastrarUsuario.php');        
 
    if(isset($_POST['novaMatricula']))
    {  
		$newUsuario = $_POST['novoNome'];
        $newMatricula = $_POST['novaMatricula'];
        $newEmail = $_POST['novoEmail'];
        $newTelefone = $_POST['novoTelefone'];
        $newUnidade = $_POST['novaUnidade'];
        $newPerfil = $_POST['novoPerfil'];
        $newSenha = $_POST['newPassword'];
		
		
        $novoUsuario = new cadastroUsuario(
            $newUsuario,
            $newMatricula,
            $newEmail,
            $newTelefone,
            $newUnidade,
            $newPerfil,
            $newSenha
            //password_hash($newSenha, PASSWORD_DEFAULT) // Criptografa a senha
        );
        
        $novoUsuario->createUsuario();
    }
?>