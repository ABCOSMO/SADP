<?php

namespace FADPD\Relatorios;

use FADPD\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class GerarRelatorioUnidade extends ConectarBD
{
    private $matricula;
    private $unidade;
    
	function __construct(
		$matricula, 
		$unidade
    )
    {
        parent::__construct();
		$this->matricula = $matricula;
        $this->unidade = $unidade;
    }

    //Informar unidade
    public function getUnidade()
    {
        return $this->unidade;
    }
    
    //Informar matricula
    public function getMatricula()
    {
        return $this->matricula;
    }
    

    public function formatarMatricula($matricula) 
    {
        // Remove todos os caracteres não numéricos
        $matricula = preg_replace('/[^0-9]/', '', $matricula);
    
        // Divide a matrícula em partes para facilitar a formatação
        $parte1 = substr($matricula, 0, 1);
        $parte2 = substr($matricula, 1, 3);
        $parte3 = substr($matricula, 4, 3);
        $parte4 = substr($matricula, 7, 1);
    
        // Junta as partes com os pontos e hífen
        $matriculaFormatada = $parte1 . '.' . $parte2 . '.' . $parte3 . '-' . $parte4;
    
        return $matriculaFormatada;
    }

    public function relatorioUnidade() {
        try{

            $unidade = $this->getUnidade();
            $matricula = $this->getMatricula();

            $sqlUnidade = "SELECT * FROM tb_unidades WHERE nome_unidade LIKE 'CDIP%'";
            $dadosUnidade = array();
            $queryUnidade = parent::executarSQL($sqlUnidade,$dadosUnidade);
            $resultadoUnidade = $queryUnidade->fetchAll(PDO::FETCH_OBJ);
            $response = [];
            foreach($resultadoUnidade as $key => $value){ 
                $response[] = ['unidade' => $value->nome_unidade];
            }
            
            header('Content-Type: application/json');
            echo json_encode($response);

        }catch(\Exception $e) {
            $response = array('success' => false, 'error' => $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}