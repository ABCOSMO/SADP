<?php

namespace SADP\Cadastrar;

use SADP\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class ExcluirUsuario extends ConectarBD
{    
    private $matricula;
    
    public function __construct($matricula)
	{
		parent::__construct();
		$this->matricula = $matricula;
	}

    //Cadastrar matricula de novo usuário
    public function getMatricula()
    {
        return $this->matricula;
    }
    
    public function alterarStatus() 
    {
        $tratarMatricula = $this->getMatricula();
        $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);

        $sql = "SELECT * FROM tb_funcionarios WHERE matricula = :matricula";
        $dados = array(":matricula" => $matricula);
        $query = parent::executarSQL($sql,$dados);
        $resultado = $query->fetch(PDO::FETCH_OBJ);
        $status = $resultado->status;

        if($status == 1){
            $status = 0;
            $sqlUpdate = "UPDATE tb_funcionarios SET status = :status WHERE matricula = :matricula";
            $dadosUpdate = array(
                ":status" => $status, 
                ":matricula" => $matricula
            );
            $queryUpdate = parent::executarSQL($sqlUpdate,$dadosUpdate);
        }else{
            $status = 1;
            $sqlUpdate = "UPDATE tb_funcionarios SET status = :status WHERE matricula = :matricula";
            $dadosUpdate = array(
                ":status" => $status, 
                ":matricula" => $matricula
            );
            $queryUpdate = parent::executarSQL($sqlUpdate,$dadosUpdate);
        }

        if ($queryUpdate) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $resultado->error]);
        }
    }
}