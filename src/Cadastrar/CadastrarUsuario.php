<?php

namespace SADP\Cadastrar;

use SADP\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class CadastrarUsuario extends ConectarBD
{
    private $nomeUsuario;
    private $matricula;
    private $email;
    private $telefone;
    private $unidade;
    private $perfil;
    private $newSenha;
  
	
    public function __construct(
		$nomeUsuario, 
		$matricula, 
		$email, 
		$telefone, 
		$unidade, 
		$perfil, 
		$newSenha
	)
    {
        parent::__construct();
        $this->nomeUsuario = $nomeUsuario;
        $this->matricula = $matricula;
        $this->email = $email;
        $this->telefone = $telefone;
        $this->unidade = $unidade;
        $this->perfil = $perfil;
        $this->newSenha = $newSenha;
    }
    
    //Cadastra nome do novo usuário
    public function getNomeUsuario()
    {
        return $this->nomeUsuario;
    }
    
    //Cadastrar matricula de novo usuário
    public function getMatricula()
    {
        return $this->matricula;
    }
    
    //Cadastrar e-mail de novo usuário
    public function getEmail()
    {
        return $this->email;
    }
    
    //Cadastrar telefone de novo usuário
    public function getTelefone()
    {
        return $this->telefone;
    }
   
    //Cadastrar unidade de novo usuário
    public function getUnidade()
    {
        return $this->unidade;
    }
   
    //Cadastrar perfil de novo usuário
    public function getPerfil()
    {
        return $this->perfil;
    }
   
    //Cadastar senha de novo usuário
    public function getSenha()
    {
        return $this->newSenha;
    }
    
    public function alterarPerfil() 
    {
        $perfil = $this->getPerfil();
        
        $sql = "SELECT * FROM privilegio WHERE idPrivilegio = :idPrivilegio";
        $dados = array(
            ":idPrivilegio" => $perfil
        );
        $query = parent::executarSQL($sql,$dados);
        $resultado = $query->fetch(PDO::FETCH_OBJ);

        return $perfil = $resultado->privilegio;      
    }

    public function alterarUnidade() 
    {
        $unidade = $this->getUnidade();
        
        $sql = "SELECT * FROM unidade WHERE idunidade = :idunidade";
        $dados = array(
            ":idunidade" => $unidade
        );
        $query = parent::executarSQL($sql,$dados);
        $resultado = $query->fetch(PDO::FETCH_OBJ);
        
        return $unidade = $resultado->unidade;
    }

    public function createUsuario() 
    {
        $nomeUsuario = $this->getNomeUsuario();
        $tratarMatricula = $this->getMatricula();
        $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);
        $email = $this->getEmail();
        $telefone = $this->getTelefone();
        $unidade = $this->alterarUnidade();
        $perfil = $this->alterarPerfil();
        $newSenha = $this->getSenha();
    
        // Prepare e execute a consulta SQL para verificar a existência do usuário
        $sqlVerifica = "SELECT * FROM usuario WHERE matricula = :matricula";
        $dadosVerifica = array(
            ":matricula" => $matricula
        );
        $queryVerifica = parent::executarSQL($sqlVerifica, $dadosVerifica);
        $resultadoVerifica = $queryVerifica->fetch(PDO::FETCH_OBJ);

        if ($resultadoVerifica) {
            $this->responderJSON(false, 'Usuário já cadastrado.');
            return;
        }

        // Insere o novo usuário
        $sqlInsere = "INSERT INTO usuario (usuario, matricula, email, telefone, unidadeUsuario, privilegioUsuario, senha) 
        VALUES (:usuario, :matricula, :email, :telefone, :unidadeUsuario, :privilegioUsuario, :senha)";
        $dadosInsere = array(
            ":usuario" => $nomeUsuario,
            ":matricula" => $matricula,
            ":email" => $email,
            ":telefone" => $telefone,
            ":unidadeUsuario" => $unidade,
            ":privilegioUsuario" => $perfil,
            ":senha" => $newSenha
        );

        $queryInsere = parent::executarSQL($sqlInsere, $dadosInsere);

        if ($queryInsere) {
            $this->responderJSON(true, 'Usuário cadastrado com sucesso.');
        } else {
            $this->responderJSON(false, 'Erro ao cadastrar usuário: ' . $this->conn->error);
        }
    }

    public function editarUsuario() 
    {
        $tratarMatricula = $this->getMatricula();
        $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);
        $perfil = $this->alterarPerfil();
        $unidade = $this->alterarUnidade();
        $usuario = $this->getNomeUsuario();
        $email = $this->getEmail();
        $telefone = $this->getTelefone();
        
        $sql = "UPDATE usuario SET privilegioUsuario = :privilegioUsuario, unidadeUsuario = :unidadeUsuario, usuario = usuario, 
        matricula = :matricula, email = :email, telefone = :telefone WHERE matricula = :matricula";
        $dados = array(":privilegioUsuario" => $perfil, ":unidadeUsuario" => $unidade, ":usuario" => $usuario, 
        ":matricula" => $matricula, ":email" => $email, ":telefone" => $telefone);
        $query = parent::executarSQL($sql,$dados);
        $resultado = parent::lastidSQL();

        if ($query) {
            $this->responderJSON(true, 'Usuário alterado com sucesso.');
        } else {
            $this->responderJSON(false, 'Erro ao alterar usuário: ' . $query->error);
        }
    }
    
    public function responderJSON($success, $message)
    {
        header('Content-Type: application/json');
        echo json_encode(['success' => $success, 'message' => $message]);
    }
}
?>