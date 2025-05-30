<?php

namespace FADPD\Cadastrar;

use FADPD\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class AlterarSenha extends ConectarBD
{
    private $matricula;
    private $newSenha;
  
	
    public function __construct(
		$matricula, 
		$newSenha
	)
    {
        parent::__construct();
        $this->matricula = $matricula;
        $this->newSenha = $newSenha;
    }
    
    //Confirmar matricula de novo usuário
    public function getMatricula()
    {
        return $this->matricula;
    }
    
    //Cadastar senha alterada pelo usuário
    public function getSenha()
    {
        return $this->newSenha;
    }
    
    public function alterarSenha() 
    {
        $tratarMatricula = $this->getMatricula();
        $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);
		$newSenha = trim($this->getSenha());
		
        $sql = "UPDATE tb_funcionarios SET 
		matricula = :matricula,
		senha = :senha
		WHERE matricula = :matricula";
        $dados = array(
		":matricula" => $matricula,
		":senha" => $newSenha
		);
        $query = parent::executarSQL($sql,$dados);
        $resultado = parent::lastidSQL();

        if ($query) {
            header('Location: ../login/');
			exit;
        } else {
            echo "erro ao tentar alterar";
        }
    }
}
?>