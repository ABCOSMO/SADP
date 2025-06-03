<?php

namespace FADPD\Cadastrar;

use FADPD\ConectarUsuario\ConectarBD;
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
    private $superintendencia;
    private $ocorrencia;
    
	function __construct(
		$novaData, 
		$unidade, 
		$matricula, 
		$cargaAnterior, 
		$cargaRecebida,
        $cargaImpossibilitada,
		$cargaDigitalizada, 
		$resto,
        $superintendencia,
        $ocorrencia
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
        $this->superintendencia = $superintendencia;
        $this->ocorrencia = $ocorrencia;
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

     //Cadastrar laçamento das Superintendências
     public function getTodasSE()
     {
         return $this->superintendencia;
     }

     
     //Cadastrar laçamento das Ocorrencias
     public function getCadastrarOcorrencia()
     {
         return $this->ocorrencia;
     }

     //Aterar a data no formato para o banco de daddos
     public function alterarData($novaData) 
    {        
        $data = explode("-", $novaData);
        return $data[2] . "/" . $data[1] . "/" . $data[0];
              
    }
	
	 public function alterarDatas() 
    {   
		$novaData = $this->getNovaData();
        $data = explode("/", $novaData);
        return $data[2] . "-" . $data[1] . "-" . $data[0];
              
    }
    
    public function lancamentoDaCarga() 
    {
        try {
            $novaData = $this->getNovaData();
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
                

                if ($query) {
                    $dataBrasil = $this->alterarData($novaData);
                    $this->cadastrarSuperintendencia();
                    $this->cadastrarOcorrencia();
                    $this->responderJSON(true,'Carga do dia ' . $dataBrasil . ' cadastrada com sucesso.');
                } else {
					$erroInfo = $query->errorInfo();
                    $this->responderJSON(false, 'error' . $erroInfo);
                }
            }

        } catch (\Exception $e) {
            $response = array('success' => false, 'error' => $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }


    public function alterarDadosCarga() {
        try {
            $novaData = $this->alterarDatas();
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

            
                // Insere nova carga
                $sql = "UPDATE tb_digitalizacao
                            SET mcu_unidade = :mcu_unidade, 
                                matricula = :matricula, 
                                data_digitalizacao = :data_digitalizacao, 
                                qtd_imagens_dia_anterior = :qtd_imagens_dia_anterior, 
                                qtd_imagens_recebidas_dia = :qtd_imagens_recebidas_dia, 
                                qtd_imagens_incorporadas = :qtd_imagens_incorporadas, 
                                qtd_imagens_impossibilitadas = :qtd_imagens_impossibilitadas, 
                                qtd_imagens_resto = :qtd_imagens_resto
                            WHERE mcu_unidade = :mcu_unidade AND data_digitalizacao = :data_digitalizacao";
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

                if ($query) {
                    $this->responderJSON(true, 'Carga do dia ' . $novaData . ' alterada com sucesso.');
                } else {
					$erroInfo = $query->errorInfo();
                    $this->responderJSON(false, 'error' . $erroInfo);
                }

        } catch (\Exception $e) {
            $response = array('success' => false, 'error' => $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    public function responderJSON($success, $message)
    {
        header('Content-Type: application/json');
		$response = array('success' => $success, 'message' => $message);
        echo json_encode($response);
    }

    public function cadastrarSuperintendencia()
    {
        try {
            $novaData = $this->getNovaData();
            $conferirMatricula = $this->getNovaMatricula();
            $sqlConferir = "SELECT * FROM tb_digitalizacao WHERE data_digitalizacao = :data_digitalizacao AND matricula = :matricula";
                $dadosConferir = array(
                    ":data_digitalizacao" => $novaData, 
                    ":matricula" => $conferirMatricula
                );
            $queryConferir = parent::executarSQL($sqlConferir,$dadosConferir);
            $conferir = $queryConferir->fetch(PDO::FETCH_OBJ);
            $dataDigitalizacao = $conferir->data_digitalizacao;
            $matricula = $conferir->matricula;
            $idDigitalizacao = $conferir->id_digitalizacao;

            if($dataDigitalizacao){
                $superintendencia = $this->getTodasSE();
                foreach($superintendencia[0] as $chave => $valor){
                    $extrairSE = explode('_', $valor);
                    if($extrairSE[0] == "Recebida"){
                        $sql = "INSERT INTO tb_carga_origem_recebida (id_digitalizacao, matricula, data_recebimento, se) 
                        VALUES (:id_digitalizacao, :matricula, :data_recebimento, :se)";
                        $dados = array( 
                            ":id_digitalizacao" => $idDigitalizacao, 
                            ":matricula" => $matricula, 
                            ":data_recebimento" => $dataDigitalizacao,
                            ":se" => $extrairSE[1]
                        );
                        $query = parent::executarSQL($sql,$dados);
                        if (!$query || $query->rowCount() === 0) {
                            // Logar ou lidar com o erro de inserção de superintendência individual
                            error_log("Erro ao inserir superintendência $chave: " . print_r($query ? $query->errorInfo() : "Erro desconhecido", true));
                            // Opcional: throw new \Exception("Erro ao cadastrar superintendência $chave.");
                        }else {
                            error_log("Formato de array de superintendência inesperado.");
                        }
                    }else {
                        error_log("Registro de digitalização não encontrado para data: $novaData e matrícula: $conferirMatricula");
                    }
                }
                
            }
        }catch (\Exception $e) {
            error_log("Erro na função cadastrarSuperintendencia: " . $e->getMessage());
            // Você pode decidir como responder ao usuário em caso de erro na superintendência
            // Ex: $this->responderJSON(false, 'Erro ao cadastrar superintendências: ' . $e->getMessage());
        }    
    }

    public function cadastrarOcorrencia()
    {
        try {
            $novaData = $this->getNovaData();
            $conferirMatricula = $this->getNovaMatricula();

            // 1. Confere se o registro de digitalização existe
            $sqlConferir = "SELECT id_digitalizacao, data_digitalizacao, matricula FROM tb_digitalizacao WHERE data_digitalizacao = :data_digitalizacao AND matricula = :matricula";
            $dadosConferir = array(
                ":data_digitalizacao" => $novaData,
                ":matricula" => $conferirMatricula
            );
            $queryConferir = parent::executarSQL($sqlConferir, $dadosConferir);
            $conferir = $queryConferir->fetch(PDO::FETCH_OBJ);

            if ($conferir) {
                $dataDigitalizacao = $conferir->data_digitalizacao;
                $matricula = $conferir->matricula;
                $idDigitalizacao = $conferir->id_digitalizacao;

                $ocorrencia = $this->getCadastrarOcorrencia();

                // 2. Verifica se a ocorrência não está vazia antes de tentar inserir
                if (!empty($ocorrencia)) {
                    $sql = "INSERT INTO tb_ocorrencias (id_digitalizacao, matricula, data_recebimento, ocorrencia)
                            VALUES (:id_digitalizacao, :matricula, :data_recebimento, :ocorrencia)";
                    $dados = array(
                        ":id_digitalizacao" => $idDigitalizacao,
                        ":matricula" => $matricula,
                        ":data_recebimento" => $dataDigitalizacao,
                        ":ocorrencia" => $ocorrencia
                    );
                    $query = parent::executarSQL($sql, $dados);
                    
                    // 3. Verifica o resultado da inserção
                    if (!$query || $query->rowCount() === 0) {
                        // Loga erro se a inserção falhou
                        error_log("Erro ao inserir ocorrência: " . print_r($query ? $query->errorInfo() : "Erro desconhecido", true));
                        // Opcional: throw new \Exception("Erro ao cadastrar ocorrência.");
                    } else {
                        // Opcional: Loga sucesso se a inserção foi bem-sucedida
                        // error_log("Ocorrência cadastrada com sucesso para ID Digitalização: $idDigitalizacao");
                    }
                } else {
                    // Loga se a string de ocorrência estiver vazia
                    error_log("A ocorrência a ser cadastrada está vazia para o registro de digitalização [Data: $novaData, Matrícula: $conferirMatricula].");
                }
            } else {
                // Loga se o registro de digitalização não foi encontrado
                error_log("Registro de digitalização não encontrado para data: $novaData e matrícula: $conferirMatricula. Não foi possível cadastrar a ocorrência.");
            }
        } catch (\Exception $e) {
            error_log("Erro na função cadastrarOcorrencia: " . $e->getMessage());
            // Você pode decidir como responder ao usuário em caso de erro
            // Ex: $this->responderJSON(false, 'Erro ao cadastrar ocorrência: ' . $e->getMessage());
        }
    }
}