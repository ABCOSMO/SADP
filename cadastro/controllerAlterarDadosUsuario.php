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
        $newUnidade = $_POST['novaUnidade'];
        $newPerfil = $_POST['novoPerfil'];
        $newSenha = '';
		
		
        $novoUsuario = new CadastrarUsuario(
            $newUsuario,
            $newMatricula,
            $newEmail,
            $newTelefone,
            $newUnidade,
            $newPerfil,
            $newSenha
        );
        
        $novoUsuario->editarUsuario();
    }
?>