<?php

namespace FADPD\Cadastrar;

use FADPD\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class AlterarSEOcorrencia extends ConectarBD
{
    private $novaUnidade;
	private $novaMatricula;
	private $novaDataDigitalizacao;
    private $novaSeStates;
    private $novaOcorrencia;
    
	function __construct(
		$novaUnidade,
		$novaMatricula,
		$novaDataDigitalizacao, 
		$novaSeStates, 
		$novaOcorrencia
	)
    {
        parent::__construct();
		$this->novaUnidade = $novaUnidade;
		$this->novaMatricula = $novaMatricula;
        $this->novaDataDigitalizacao = $novaDataDigitalizacao;
        $this->novaSeStates = $novaSeStates;
        $this->novaOcorrencia = $novaOcorrencia;
    }

     //Cadastra nova data
     public function getNovaDataDigitalizacao()
     {
         return $this->novaDataDigitalizacao;
     }
		
	 //Cadastra nova matrícula
     public function getNovaMatricula()
     {
         return $this->novaMatricula;
     }

     //Cadastrar laçamento de carga de nova unidade
     public function getNovaUnidade()
     {
         return $this->novaUnidade;
     }
 
     //Cadastrar laçamento das Superintendências
     public function getTodasSE()
     {
         return $this->novaSeStates;
     }

     
     //Cadastrar laçamento das Ocorrencias
     public function getNovaOcorrencia()
     {
         return $this->novaOcorrencia;
     }

     //Aterar a data no formato para o banco de daddos
     public function alterarData($novaData) 
    {        
        $data = explode("-", $novaData);
        return $data[2] . "/" . $data[1] . "/" . $data[0];
              
    }
	
	 public function alterarDatas() 
    {   
		$novaData = $this->getNovaDataDigitalizacao();
        $data = explode("/", $novaData);
        return $data[2] . "-" . $data[1] . "-" . $data[0];
              
    }
 
 
    public function alterarDadosSE()
    {
        try {
			$novaData = $this->alterarDatas();
            $matricula = $this->getNovaMatricula();
			$unidade = $this->getNovaUnidade();

            $sqlConferir = "
							SELECT 
								tb_digitalizacao.*,
								tb_unidades.*
							FROM 
								tb_digitalizacao 
							INNER JOIN
								tb_unidades
                            ON 
                                tb_digitalizacao.mcu_unidade = tb_unidades.mcu_unidade
							WHERE 
								tb_digitalizacao.data_digitalizacao = :data_digitalizacao 
							AND 
								tb_unidades.nome_unidade = :nome_unidade";

                $dadosConferir = array(
                    ":data_digitalizacao" => $novaData, 
                    ":nome_unidade" => $unidade
                );
            $queryConferir = parent::executarSQL($sqlConferir,$dadosConferir);
            $conferir = $queryConferir->fetch(PDO::FETCH_OBJ);
            $idDigitalizacao = $conferir->id_digitalizacao;
			
			$sqlDeletar = "DELETE FROM 
						tb_carga_origem_recebida 
					WHERE 
						id_digitalizacao = :id_digitalizacao
					AND 
						data_recebimento = :data_recebimento";
			$dadosDeletar = array(
                        ":id_digitalizacao" => $idDigitalizacao,
						":data_recebimento" => $novaData
						);
			$queryDeletar = parent::executarSQL($sqlDeletar, $dadosDeletar);

            if($idDigitalizacao){
                $superintendencia = $this->getTodasSE();
                foreach($superintendencia as $valor){
					$seNumero = $valor['se_numero'];
					$status = $valor['status'];
                    if($status == 1){
                        $sql = "INSERT INTO tb_carga_origem_recebida (id_digitalizacao, matricula, data_recebimento, se) 
                        VALUES (:id_digitalizacao, :matricula, :data_recebimento, :se)";
                        $dados = array( 
                            ":id_digitalizacao" => $idDigitalizacao, 
                            ":matricula" => $matricula, 
                            ":data_recebimento" => $novaData,
                            ":se" => $seNumero
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
                        error_log("Registro de digitalização não encontrado para data: $novaData e matrícula: $matricula");
                    }
                }

                $ocorrencias = $this->alterarDadosOcorrencia();

                if ($query) {
                    $this->responderJSON(true, 'Dados das superintendências e das ocorrências do dia ' . $novaData . ' alteradas com sucesso.');
                } else {
					$erroInfo = $query->errorInfo();
                    $this->responderJSON(false, 'error' . $erroInfo);
                }
                
            }
        }catch (\Exception $e) {
            $response = array('success' => false, 'error' => $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode($response);
        }    
    }

    public function alterarDadosOcorrencia()
    {
        try {
			$novaData = $this->alterarDatas();
            $matricula = $this->getNovaMatricula();
			$unidade = $this->getNovaUnidade();

            $sqlConferir = "
							SELECT 
								tb_digitalizacao.*,
								tb_unidades.*
							FROM 
								tb_digitalizacao 
							INNER JOIN
								tb_unidades
                            ON 
                                tb_digitalizacao.mcu_unidade = tb_unidades.mcu_unidade
							WHERE 
								tb_digitalizacao.data_digitalizacao = :data_digitalizacao 
							AND 
								tb_unidades.nome_unidade = :nome_unidade";

                $dadosConferir = array(
                    ":data_digitalizacao" => $novaData, 
                    ":nome_unidade" => $unidade
                );
            $queryConferir = parent::executarSQL($sqlConferir,$dadosConferir);
            $conferir = $queryConferir->fetch(PDO::FETCH_OBJ);
            $idDigitalizacao = $conferir->id_digitalizacao;
			
			$sqlDeletar = "DELETE FROM 
						tb_ocorrencias 
					WHERE 
						id_digitalizacao = :id_digitalizacao
					AND 
						data_recebimento = :data_recebimento";
			$dadosDeletar = array(
                        ":id_digitalizacao" => $idDigitalizacao,
						":data_recebimento" => $novaData
						);
			$queryDeletar = parent::executarSQL($sqlDeletar, $dadosDeletar);

            if($idDigitalizacao){
                $ocorrencias = $this->getNovaOcorrencia();               
                   
                $sql = "INSERT INTO tb_ocorrencias (id_digitalizacao, matricula, data_recebimento, ocorrencia) 
                VALUES (:id_digitalizacao, :matricula, :data_recebimento, :ocorrencia)";
                $dados = array( 
                    ":id_digitalizacao" => $idDigitalizacao, 
                    ":matricula" => $matricula, 
                    ":data_recebimento" => $novaData,
                    ":ocorrencia" => $ocorrencias
                );
                $query = parent::executarSQL($sql,$dados);
                if (!$query || $query->rowCount() === 0) {
                    // Logar ou lidar com o erro de inserção de superintendência individual
                    error_log("Erro ao inserir ocorrências $chave: " . print_r($query ? $query->errorInfo() : "Erro desconhecido", true));
                    // Opcional: throw new \Exception("Erro ao cadastrar superintendência $chave.");
                }else {
                    error_log("Formato de array de superintendência inesperado.");
                }
                
            }
        }catch (\Exception $e) {
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
        exit;
    }
    
}