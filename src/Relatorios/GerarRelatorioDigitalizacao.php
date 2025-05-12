<?php

namespace FADPD\Relatorios;

use FADPD\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class GerarRelatorioDigitalizacao extends ConectarBD
{
    private $perfil;
    private $matricula;
    private $unidade;
    private $dataAnterior;
    private $dataPosterior;
    
	function __construct(
        $perfil,
		$matricula, 
		$unidade, 
		$dataAnterior, 
		$dataPosterior
	)
    {
        parent::__construct();
        $this->perfil = $perfil;
		$this->matricula = $matricula;
        $this->unidade = $unidade;
        $this->dataAnterior = $dataAnterior;
        $this->dataPosterior = $dataPosterior;
    }


    //Informar perfil
    public function getPerfil()
    {
        return $this->perfil;
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

    public function relatorioDiarioDigitalizacao() {
        try{

            $unidade = $this->getUnidade();
            $matricula = $this->getMatricula();
            $dataAnterior = $this->getDataAnterior();
            $dataPosterior = $this->getDataPosterior();
            $perfil = $this->getPerfil();

            $sqlUnidade = "SELECT * FROM tb_unidades WHERE nome_unidade = :nome_unidade";
            $dadosUnidade = array(
                ":nome_unidade" => $unidade
            );
            $queryUnidade = parent::executarSQL($sqlUnidade,$dadosUnidade);
            $resultadoUnidade = $queryUnidade->fetchAll(PDO::FETCH_OBJ);
            foreach($resultadoUnidade as $linha){
                $mcuUnidade = $linha->mcu_unidade; 
            }

            if($perfil != "01") {
                // Verifica se a carga já foi lançada
                $sql = "SELECT
                td.*,
                tf.nome,
                tf.matricula
                FROM
                    tb_digitalizacao td
                INNER JOIN
                    tb_funcionarios tf 
                ON 
                    td.matricula = tf.matricula
                INNER JOIN (
                    SELECT id_digitalizacao
                    FROM tb_digitalizacao
                    WHERE mcu_unidade = :mcu_unidade_sub
                    ORDER BY id_digitalizacao DESC
                    LIMIT 5
                ) AS 
                    ultimos_ids 
                ON 
                    td.id_digitalizacao = ultimos_ids.id_digitalizacao
                WHERE
                    td.data_digitalizacao >= :data_anterior
                AND 
                    td.data_digitalizacao <= :data_posterior
                AND 
                    td.mcu_unidade = :mcu_unidade_principal
                ORDER BY
                    td.data_digitalizacao ASC";
                $dados = array(
                    ":data_anterior" => $dataAnterior,
                    ":data_posterior" => $dataPosterior,
                    ":mcu_unidade_principal" => $mcuUnidade,
                    ":mcu_unidade_sub" => $mcuUnidade
                );
                $query = parent::executarSQL($sql,$dados);
                $resultado = $query->fetchAll(PDO::FETCH_OBJ);

                $response = [];
                foreach($resultado as $key => $value) {
                    $response[] = [
                        'unidade' => $this->getUnidade(),
                        'matricula_usuario' => $this->formatarMatricula($value->matricula),
                        'nome_usuario' => $value->nome,
                        'data_digitalizacao' => $this->alterarFormatoData($value->data_digitalizacao),
                        'imagens_anterior' => $value->qtd_imagens_dia_anterior,
                        'imagens_recebidas' => $value->qtd_imagens_recebidas_dia,
                        'imagens_incorporadas' => $value->qtd_imagens_incorporadas,
                        'imagens_impossibilitadas' => $value->qtd_imagens_impossibilitadas,
                        'resto' => $value->qtd_imagens_resto
                    ];
                }
            } else {
                // Verifica se a carga já foi lançada
                $sql = 
                "SELECT 
                    tb_digitalizacao.*, 
                    tb_funcionarios.nome, 
                    tb_funcionarios.matricula 
                FROM 
                    tb_digitalizacao 
                INNER JOIN 
                    tb_funcionarios
                ON 
                    tb_digitalizacao.matricula = tb_funcionarios.matricula 
                AND 
                    tb_digitalizacao.data_digitalizacao >= :data_anterior 
                AND 
                    tb_digitalizacao.data_digitalizacao <= :data_posterior                    
                ORDER BY 
                    tb_digitalizacao.data_digitalizacao";

                $dados = array(
                    ":data_anterior" => $dataAnterior, 
                    ":data_posterior" => $dataPosterior,
                );
                $query = parent::executarSQL($sql,$dados);
                $resultado = $query->fetchAll(PDO::FETCH_OBJ);

                $response = [];
                foreach($resultado as $key => $value) {
                    $novoMcuUnidade = $value->mcu_unidade;
                    $sqlUnidade = "SELECT * FROM tb_unidades WHERE mcu_unidade = :mcu_unidade";
                    $dadosUnidade = array(
                        ":mcu_unidade" => $novoMcuUnidade
                    );
                    $queryUnidade = parent::executarSQL($sqlUnidade,$dadosUnidade);
                    $resultadoUnidade = $queryUnidade->fetch(PDO::FETCH_OBJ);
                    $unidade = $resultadoUnidade->nome_unidade;

                    $response[] = [
                        'perfil' => $perfil,
                        'unidade' => $unidade,
                        'matricula_usuario' => $this->formatarMatricula($value->matricula),
                        'nome_usuario' => $value->nome,
                        'data_digitalizacao' => $this->alterarFormatoData($value->data_digitalizacao),
                        'imagens_anterior' => $value->qtd_imagens_dia_anterior,
                        'imagens_recebidas' => $value->qtd_imagens_recebidas_dia,
                        'imagens_incorporadas' => $value->qtd_imagens_incorporadas,
                        'imagens_impossibilitadas' => $value->qtd_imagens_impossibilitadas,
                        'resto' => $value->qtd_imagens_resto
                    ];
                }               
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