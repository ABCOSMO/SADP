<?php

namespace SADP\Cadastrar;

use SADP\ConectarUsuario\ConectarBD;

class CadastrarCarga extends ConectarBD
{
    function __construct(
        private string $novaData,
        private string $unidade,
        private string $matricula,
        private string $cargaAnterior,
        private string $cargaRecebida,
        private string $cargaDigitalizada,
        private string $resto
    )
    {
        parent::__construct();
    }

     //Cadastra nova data
     public function getNovaData(): string
     {
         return $this->novaData;
     }

     //Cadastrar laçamento de carga de nova unidade
     public function getNovaUnidade(): string
     {
         return $this->unidade;
     }
     
     //Cadastrar laçamento de carga de nova matricula
     public function getNovaMatricula(): string
     {
         return $this->matricula;
     }
     
     //Cadastrar laçamento de carga do dia anterior
     public function getCargaAnterior(): string
     {
         return $this->cargaAnterior;
     }
    
    //Cadastrar laçamento de carga recebida no dia
     public function getCargaRecebida(): string
     {
         return $this->cargaRecebida;
     }
    
     //Cadastrar laçamento de carga digitalizada no dia
     public function getCargaDigitalizada(): string
     {
         return $this->cargaDigitalizada;
     }

     //Cadastrar laçamento de resto no dia
     public function getCargaResto(): string
     {
         return $this->resto;
     }

     //Aterar a data no formato para o banco de daddos
     public function alterarData(): string 
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
            $cargaDigitalizada = str_replace(['.'], '', $this->getCargaDigitalizada());
            $resto = str_replace(['.'], '', $this->getCargaResto());

            // Verifica se a carga já foi lançada
            $stmt = $this->conn->prepare("SELECT * FROM cargadigitalizacao WHERE dataCarga = ? AND unidadeCarga = ?");
            $stmt->bind_param("ss", $novaData, $unidade);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Carga já existente
                $response = array('success' => false, 'error' => 'Carga desse dia já foi lançada no sistema');
            } else {
                // Insere nova carga
                $stmt = $this->conn->prepare("INSERT INTO cargadigitalizacao (dataCarga, unidadeCarga, matriculaCarga, cargaDiaAnterior, 
                cargaRecebida, cargaDigitalizada, resto) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssiiiii", $novaData, $unidade, $matricula, $cargaAnterior, $cargaRecebida, $cargaDigitalizada, $resto);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    $response = array('success' => true, 'message' => 'Carga do dia ' . $this->getNovaData() . ' cadastrada com sucesso.');
                } else {
                    $response = array('success' => false, 'error' => $stmt->error);
                }
            }

            header('Content-Type: application/json');
            echo json_encode($response);
            $stmt->close();

        } catch (\Exception $e) {
            $response = array('success' => false, 'error' => $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }
}