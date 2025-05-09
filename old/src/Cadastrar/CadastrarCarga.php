<?php

namespace SADP\Cadastrar;

use SADP\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class CadastrarCarga extends ConectarBD
{
    private $novaData;
    private $unidade;
    private $matricula;
    private $cargaAnterior;
    private $cargaRecebida;
    private $cargaImpossibilitada;
    private $cargaDigitalizada;
    private $resto;
    
	function __construct(
		$novaData, 
		$unidade, 
		$matricula, 
		$cargaAnterior, 
		$cargaRecebida,
        $cargaImpossibilitada,
		$cargaDigitalizada, 
		$resto
	)
    {
        parent::__construct();
		$this->novaData = $novaData;
        $this->unidade = $unidade;
        $this->matricula = $matricula;
        $this->cargaAnterior = $cargaAnterior;
        $this->cargaRecebida = $cargaRecebida;
        $this->cargaImpossibilitada = $cargaImpossibilitada;
        $this->cargaDigitalizada = $cargaDigitalizada;
        $this->resto = $resto;
    }

     //Cadastra nova data
     public function getNovaData()
     {
         return $this->novaData;
     }

     //Cadastrar laçamento de carga de nova unidade
     public function getNovaUnidade()
     {
         return $this->unidade;
     }
     
     //Cadastrar laçamento de carga de nova matricula
     public function getNovaMatricula()
     {
         return $this->matricula;
     }
     
     //Cadastrar laçamento de carga do dia anterior
     public function getCargaAnterior()
     {
         return $this->cargaAnterior;
     }
    
    //Cadastrar laçamento de carga recebida no dia
     public function getCargaRecebida()
     {
         return $this->cargaRecebida;
     }

     //Cadastrar laçamento de carga impossibilitada no dia
     public function getCargaImpossibilitada()
     {
         return $this->cargaImpossibilitada;
     }
    
     //Cadastrar laçamento de carga digitalizada no dia
     public function getCargaDigitalizada()
     {
         return $this->cargaDigitalizada;
     }

     //Cadastrar laçamento de resto no dia
     public function getCargaResto()
     {
         return $this->resto;
     }

     //Aterar a data no formato para o banco de daddos
     public function alterarData() 
    {
        $novaData = $this->getNovaData();        
        $data = explode("/", $novaData);
        return $data[2] . "-" . $data[1] . "-" . $data[0];
              
    }
    
    public function lancamentoDaCarga() 
    {
        try {
            $novaData = $this->alterarData();
            $unidade = $this->getNovaUnidade();
            $matricula = $this->getNovaMatricula();
            $cargaAnterior = str_replace(['.'], '', $this->getCargaAnterior());
            $cargaRecebida = str_replace(['.'], '', $this->getCargaRecebida());
            $cargaImpossibilitada = str_replace(['.'], '', $this->getCargaImpossibilitada());
            $cargaDigitalizada = str_replace(['.'], '', $this->getCargaDigitalizada());
            $resto = str_replace(['.'], '', $this->getCargaResto());

            $sqlUnidade = "SELECT * FROM tb_unidades WHERE nome_unidade = :nome_unidade";
            $dadosUnidade = array(
                ":nome_unidade" => $unidade
            );
            $queryUnidade = parent::executarSQL($sqlUnidade,$dadosUnidade);
            $resultadoUnidade = $queryUnidade->fetch(PDO::FETCH_OBJ);
            $mcuUnidade = $resultadoUnidade->mcu_unidade; 

            // Verifica se a carga já foi lançada
            $sql = "SELECT * FROM tb_digitalizacao WHERE data_digitalizacao = :data_digitalizacao AND mcu_unidade = :mcu_unidade";
            $dados = array(
                ":data_digitalizacao" => $novaData, 
                ":mcu_unidade" => $mcuUnidade
            );
            $query = parent::executarSQL($sql,$dados);
            $resultado = $query->fetch(PDO::FETCH_OBJ);

            if ($resultado) {
                // Carga já existente
                $response = array('success' => false, 'error' => 'Carga desse dia já foi lançada no sistema');
            } else {
                // Insere nova carga
                $sql = "INSERT INTO tb_digitalizacao (mcu_unidade, matricula, data_digitalizacao, qtd_imagens_dia_anterior, 
                qtd_imagens_recebidas_dia, qtd_imagens_incorporadas, qtd_imagens_impossibilitadas, qtd_imagens_resto) 
                VALUES (:mcu_unidade, :matricula, :data_digitalizacao, :qtd_imagens_dia_anterior,:qtd_imagens_recebidas_dia, 
                :qtd_imagens_incorporadas, :qtd_imagens_impossibilitadas, :qtd_imagens_resto)";
                $dados = array( 
                    ":mcu_unidade" => $mcuUnidade, 
                    ":matricula" => $matricula, 
                    ":data_digitalizacao" => $novaData,
                    ":qtd_imagens_dia_anterior" => $cargaAnterior, 
                    ":qtd_imagens_recebidas_dia" => $cargaRecebida, 
                    ":qtd_imagens_incorporadas" => $cargaDigitalizada, 
                    ":qtd_imagens_impossibilitadas" => $cargaImpossibilitada,
                    ":qtd_imagens_resto" => $resto
                );
                $query = parent::executarSQL($sql,$dados);
                $resultado = parent::lastidSQL();

                if ($resultado) {
                    $response = array('success' => true, 'message' => 'Carga do dia ' . $this->getNovaData() . ' cadastrada com sucesso.');
                } else {
					$erroInfo = $query->errorInfo();
                    $response = array('success' => false, 'error' => $erroInfo);
                }
            }

            header('Content-Type: application/json');
            echo json_encode($response);

        } catch (\Exception $e) {
            $response = array('success' => false, 'error' => $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}