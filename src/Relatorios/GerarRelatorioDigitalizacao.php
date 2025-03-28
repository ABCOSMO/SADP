<?php

namespace SADP\Relatorios;

use SADP\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class GerarRelatorioDigitalizacao extends ConectarBD
{
    private $matricula;
    private $unidade;
    private $dataAnterior;
    private $dataPosterior;
    
	function __construct(
		$matricula, 
		$unidade, 
		$dataAnterior, 
		$dataPosterior
	)
    {
        parent::__construct();
		$this->matricula = $matricula;
        $this->unidade = $unidade;
        $this->dataAnterior = $dataAnterior;
        $this->dataPosterior = $dataPosterior;
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
    
    //Informar data de 15 dias antrás
    public function getDataAnterior()
    {
        return $this->dataAnterior;
    }
   
   //Informar data de 15 dias depois
    public function getDataPosterior()
    {
        return $this->dataPosterior;
    }

     //Aterar a data no formato brasileiro
    public function alterarFormatoData($dataDia) 
    {
        $data = explode("-", $dataDia);
        return $data[2] . "/" . $data[1] . "/" . $data[0];
              
    }

    public function relatorioDiarioDigitalizacao() {
        try{

            $unidade = $this->getUnidade();
            $matricula = $this->getMatricula();
            $dataAnterior = $this->getDataAnterior();
            $dataPosterior = $this->getDataPosterior();

            $sqlUnidade = "SELECT tb_unidades.mcu_unidade, tb_funcionarios.nome FROM tb_unidades INNER JOIN tb_funcionarios
            ON tb_unidades.mcu_unidade = tb_funcionarios.mcu_unidade AND tb_unidades.nome_unidade = :nome_unidade";
            $dadosUnidade = array(
                ":nome_unidade" => $unidade
            );
            $queryUnidade = parent::executarSQL($sqlUnidade,$dadosUnidade);
            $resultadoUnidade = $queryUnidade->fetchAll(PDO::FETCH_OBJ);
            foreach($resultadoUnidade as $linha){
                $mcuUnidade = $linha->mcu_unidade; 
                $nomeUsuario = $linha->nome;
            }

            // Verifica se a carga já foi lançada
            $sql = "SELECT * FROM tb_digitalizacao WHERE data_digitalizacao >= :data_anterior AND data_digitalizacao <= :data_posterior
            AND mcu_unidade = :mcu_unidade ORDER BY data_digitalizacao";
            $dados = array(
                ":data_anterior" => $dataAnterior, 
                ":data_posterior" => $dataPosterior,
                ":mcu_unidade" => $mcuUnidade
            );
            $query = parent::executarSQL($sql,$dados);
            $resultado = $query->fetchAll(PDO::FETCH_OBJ);

            $response = [];
            foreach($resultado as $key => $value) {
                $response[] = [
                    'nome_usuario' => $nomeUsuario,
                    'data_digitalizacao' => $this->alterarFormatoData($value->data_digitalizacao),
                    'imagens_anterior' => $value->qtd_imagens_dia_anterior,
                    'imagens_recebidas' => $value->qtd_imagens_recebidas_dia,
                    'imagens_incorporadas' => $value->qtd_imagens_incorporadas,
                    'imagens_impossibilitadas' => $value->qtd_imagens_impossibilitadas,
                    'resto' => $value->qtd_imagens_resto
                ];
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