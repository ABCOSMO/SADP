<?php

namespace FADPD\Cadastrar;

use FADPD\ConectarUsuario\ConectarBD;
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

    public function excluirSEOcorrencias()
    {
        $dataDigitalizacao = $this->alterarData();
        $tratarMatricula = $this->getMatricula();
        $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);
        
        $sqlMcu = 
                    "SELECT 
                        tb_digitalizacao.*,
                        tb_funcionarios.*
                    FROM 
                        tb_digitalizacao 
                    INNER JOIN
                        tb_funcionarios
                    ON
                        tb_digitalizacao.mcu_unidade = tb_funcionarios.mcu_unidade
                    WHERE 
                        tb_digitalizacao.matricula = :matricula 
                    AND 
                        tb_digitalizacao.data_digitalizacao = :data_digitalizacao";

                $dadosMcu = array(
                    ":data_digitalizacao" => $dataDigitalizacao, 
                    ":matricula" => $matricula
                );
            $queryMcu = parent::executarSQL($sqlMcu,$dadosMcu);
            $conferir = $queryMcu->fetch(PDO::FETCH_OBJ);
            $idDigitalizacao = $conferir->id_digitalizacao;

        $sqlSE = "DELETE FROM tb_carga_origem_recebida WHERE id_digitalizacao = :id_digitalizacao AND data_recebimento = :dataDigitalizacao";
        $dadosSE =    array(
                        ":id_digitalizacao" => $idDigitalizacao,
                        ":dataDigitalizacao" => $dataDigitalizacao
                    );
        $querySE = parent::executarSQL($sqlSE, $dadosSE);

        $sqlOcorrencia = "DELETE FROM tb_ocorrencias WHERE id_digitalizacao = :id_digitalizacao AND data_recebimento = :dataDigitalizacao";
        $dadosOcorrencia =    array(
                        ":id_digitalizacao" => $idDigitalizacao,
                        ":dataDigitalizacao" => $dataDigitalizacao
                    );
        $queryOcorrencia = parent::executarSQL($sqlOcorrencia, $dadosOcorrencia);

        if($querySE && $queryOcorrencia){
            $this->alterarDados();
        }else{
            echo "erro";
        }         
    }
    
    public function alterarDados() 
    {
        $dataDigitalizacao = $this->alterarData();
        $tratarMatricula = $this->getMatricula();
        $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);

        $sql = "DELETE FROM tb_digitalizacao WHERE matricula = :matricula AND data_digitalizacao = :novaData";
        $dados = array(
                        ":matricula" => $matricula,
                        ":novaData" => $dataDigitalizacao
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