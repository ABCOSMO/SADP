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
		
		
        $novoUsuario = new cadastroUsuario();
        $novoUsuario->setNomeUsuario($newUsuario);
        $novoUsuario->setMatricula($newMatricula);
        $novoUsuario->setEmail($newEmail);
        $novoUsuario->setTelefone($newTelefone);
        $novoUsuario->setUnidade($newUnidade);
        $novoUsuario->setPerfil($newPerfil);
        $novoUsuario->setSenha($newSenha);
        $novoUsuario->createUsuario();
    }
?>