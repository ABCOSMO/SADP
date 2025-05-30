<?php
    session_start();
    require '../autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Cadastrar\AlterarSenha;
 
    if(isset($_POST['matricula']))
    {  
        $newMatricula = $_POST['matricula'];
        $newSenha = password_hash($_POST['password'], PASSWORD_DEFAULT);
		//$teste = $_POST['newPassword'];
		//file_put_contents(__DIR__ . "/meu_arquivo_login.txt", $teste);
        $alterarSenha = new AlterarSenha(
            $newMatricula,
            $newSenha
            //password_hash($newSenha, PASSWORD_DEFAULT) // Criptografa a senha
        );
        
        $alterarSenha->alterarSenha();
    }
?>