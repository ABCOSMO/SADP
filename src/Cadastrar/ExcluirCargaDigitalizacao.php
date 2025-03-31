<?php

namespace SADP\Cadastrar;

use SADP\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class ExcluirCargaDigitalizacao extends ConectarBD
{    
    private $matricula;
    private $data;
    
    public function __construct(
        $matricula,
        $data
    )
	{
		parent::__construct();
		$this->matricula = $matricula;
        $this->data = $data;
	}

    //Cadastrar matricula de novo usuário
    public function getMatricula()
    {
        return $this->matricula;
    }

    public function getData()
    {
        return $this->data;
    }

    //Aterar a data no formato para o banco de daddos
    public function alterarData() 
    {
        $novaData = $this->getData();        
        $data = explode("/", $novaData);
        return $data[2] . "-" . $data[1] . "-" . $data[0];
              
    }
    
    public function alterarDados() 
    {
        $data = $this->alterarData();

        $sql = "DELETE FROM tb_digitalizacao WHERE matricula = :matricula AND data_digitalizacao = :novaData";
        $dados = array(
                        ":matricula" => $this->getMatricula(),
                        ":novaData" => $data
                        );
        try {
            $query = parent::executarSQL($sql, $dados);
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
        } catch (PDOException $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}