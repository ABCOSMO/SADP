<?php

namespace FADPD\Relatorios;

use FADPD\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class GerarRelatorioDiarioSE extends ConectarBD
{
    private $unidade;
    private $dataInicial;
    private $dataFinal;
    private $perfil;
	
	function __construct(
        $unidade, 
		$dataInicial, 
		$dataFinal,
		$perfil
	)
    {
        parent::__construct();
        $this->unidade = $unidade;
        $this->dataInicial = $dataInicial;
        $this->dataFinal = $dataFinal;
		$this->perfil = $perfil;
    }

   //Informar unidade
    public function getUnidade()
    {
        return $this->unidade;
    } 
    
    //Informar data inicial
    public function getDataInicial()
    {
        return $this->dataInicial;
    }
   
   //Informar data final
    public function getDataFinal()
    {
        return $this->dataFinal;
    }

	//Informar perfil
    public function getPerfil()
    {
        return $this->perfil;
    }

     //Aterar a data no formato brasileiro
    public function alterarFormatoData($dataDia) 
    {
        $datai = explode("-", $dataDia);
        return $datai[2] . "/" . $datai[1] . "/" . $datai[0];
              
    }

  
    public function relatorioDiarioSE()
    {
        $unidade = $this->getUnidade();
        $dataInicial = $this->getDataInicial();
        $dataFinal = $this->getDataFinal();
        $perfil = $this->getPerfil();

        // 1. Obter mcu_unidade da tabela tb_unidades
        $sqlUnidade = "SELECT mcu_unidade FROM tb_unidades WHERE nome_unidade = :nome_unidade";
        $dadosUnidade = [
            ":nome_unidade" => $unidade
        ];
        $queryUnidade = parent::executarSQL($sqlUnidade, $dadosUnidade);
        $resultadoUnidade = $queryUnidade->fetch(PDO::FETCH_OBJ); // Use fetch para um único resultado

        if (!$resultadoUnidade) {
            // Lidar com o caso onde a unidade não é encontrada
            echo "Unidade não encontrada.";
            exit;
        }

        $mcuUnidade = $resultadoUnidade->mcu_unidade;

        if ($perfil != "01") {
            // 2. Obter as últimas 5 id_digitalizacao distintas para a mcu_unidade específica
            $sqlUltimosIds = "
                SELECT id_digitalizacao
				FROM tb_digitalizacao
				WHERE mcu_unidade = :mcu_unidade
				AND data_digitalizacao BETWEEN :data_inicial AND :data_final
				ORDER BY id_digitalizacao DESC
            ";
            $dadosUltimosIds = [
                ":mcu_unidade" => $mcuUnidade,
				":data_inicial" => $dataInicial,
				":data_final" => $dataFinal
            ];
            $queryUltimosIds = parent::executarSQL($sqlUltimosIds, $dadosUltimosIds);
            $ultimosIdsDigitalizacao = $queryUltimosIds->fetchAll(PDO::FETCH_COLUMN); // Pega apenas a coluna id_digitalizacao

             //$placeholders = implode(',', array_fill(0, count($ultimosIdsDigitalizacao), '?'));
            
            if (empty($ultimosIdsDigitalizacao)) {
                echo "Nenhum registro de digitalização encontrado para a unidade e período.";
                exit;
            }

            $cleanIds = array_map('intval', $ultimosIdsDigitalizacao);
            $idsString = implode(',', $cleanIds); // Ex: "48,47,46,45,44"
			
            // 4. Montar a query principal para buscar os dados completos
            $sql = "
                SELECT * FROM tb_carga_origem_recebida 
                WHERE
                    id_digitalizacao IN ($idsString)
                AND 
                    data_recebimento 
                BETWEEN 
                    :data_inicial AND :data_final
                ORDER BY
                    data_recebimento ASC
            ";

            // Os valores para os placeholders dos IDs são adicionados diretamente aos dados,
            // junto com os outros parâmetros nomeados.
             $dados = [
                        ":data_inicial" => $dataInicial,
                        ":data_final" => $dataFinal,
                    ];

            $query = parent::executarSQL($sql, $dados);
            $resultado = $query->fetchAll(PDO::FETCH_OBJ);

            $response = [];
            foreach ($resultado as $value) {
                $response[] = [
                    'unidade' => $this->getUnidade(), // Ou $unidade, se você quiser usar a variável já obtida
                    'data_recebimento' => $this->alterarFormatoData($value->data_recebimento),
                    'se_recebida' => $value->se, // Ou 'se' se for o nome original
					'matricula' => $value->matricula
                ];
            }

            header('Content-Type: application/json; charset=utf-8');
			echo json_encode($response, JSON_UNESCAPED_UNICODE);;
			
        }else {
            $sql = 
                "SELECT 
                    tb_digitalizacao.*, 
                    tb_carga_origem_recebida.*
                FROM 
                    tb_digitalizacao 
                INNER JOIN 
                    tb_carga_origem_recebida
                ON 
                    tb_digitalizacao.data_digitalizacao = tb_carga_origem_recebida.data_recebimento
                AND 
                    tb_digitalizacao.data_digitalizacao >= :data_inicial 
                AND 
                    tb_digitalizacao.data_digitalizacao <= :data_final                     
                ORDER BY 
                    tb_digitalizacao.data_digitalizacao";

                $dados = array(
                    ":data_inicial" => $dataInicial, 
                    ":data_final" => $dataFinal,
                );
                $query = parent::executarSQL($sql,$dados);
                $resultado = $query->fetchAll(PDO::FETCH_OBJ);

                $response = [];
                foreach ($resultado as $value) {
                    $response[] = [
                    'unidade' => $this->getUnidade(), // Ou $unidade, se você quiser usar a variável já obtida
                        'data_recebimento' => $this->alterarFormatoData($value->data_recebimento),
                        'se_recebida' => $value->se, // Ou 'se' se for o nome original
						'matricula' => $value->matricula
                    ];
                }
                header('Content-Type: application/json; charset=utf-8');
				echo json_encode($response, JSON_UNESCAPED_UNICODE);;
        }
    }

    public function relatorioOcorrencias()
    {
        $unidade = $this->getUnidade();
        $dataAnterior = $this->getDataAnterior();
        $dataPosterior = $this->getDataPosterior();
        $perfil = $this->getPerfil();

        // 1. Obter mcu_unidade da tabela tb_unidades
        $sqlUnidade = "SELECT mcu_unidade FROM tb_unidades WHERE nome_unidade = :nome_unidade";
        $dadosUnidade = [
            ":nome_unidade" => $unidade
        ];
        $queryUnidade = parent::executarSQL($sqlUnidade, $dadosUnidade);
        $resultadoUnidade = $queryUnidade->fetch(PDO::FETCH_OBJ); // Use fetch para um único resultado

        if (!$resultadoUnidade) {
            // Lidar com o caso onde a unidade não é encontrada
            echo "Unidade não encontrada.";
            exit;
        }

        $mcuUnidade = $resultadoUnidade->mcu_unidade;

        if ($perfil != "01") {
            // 2. Obter as últimas 5 id_digitalizacao distintas para a mcu_unidade específica
            $sqlUltimosIds = "
                SELECT DISTINCT id_digitalizacao
                FROM tb_digitalizacao
                WHERE mcu_unidade = :mcu_unidade
                ORDER BY id_digitalizacao DESC
                LIMIT 5
            ";
            $dadosUltimosIds = [
                ":mcu_unidade" => $mcuUnidade
            ];
            $queryUltimosIds = parent::executarSQL($sqlUltimosIds, $dadosUltimosIds);
            $ultimosIdsDigitalizacao = $queryUltimosIds->fetchAll(PDO::FETCH_COLUMN); // Pega apenas a coluna id_digitalizacao

             //$placeholders = implode(',', array_fill(0, count($ultimosIdsDigitalizacao), '?'));
            
            if (empty($ultimosIdsDigitalizacao)) {
                echo "Nenhum registro de digitalização encontrado para a unidade e período.";
                exit;
            }

            $cleanIds = array_map('intval', $ultimosIdsDigitalizacao);
            $idsString = implode(',', $cleanIds); // Ex: "48,47,46,45,44"

            // 4. Montar a query principal para buscar os dados completos
            $sql = "
                SELECT * FROM tb_ocorrencias 
                WHERE
                    id_digitalizacao IN ($idsString)
                AND 
                    data_recebimento 
                BETWEEN 
                    :data_anterior AND :data_posterior
                ORDER BY
                    data_recebimento ASC
            ";

            // Os valores para os placeholders dos IDs são adicionados diretamente aos dados,
            // junto com os outros parâmetros nomeados.
             $dados = [
                        ":data_anterior" => $dataAnterior,
                        ":data_posterior" => $dataPosterior,
                    ];

            $query = parent::executarSQL($sql, $dados);
            $resultado = $query->fetchAll(PDO::FETCH_OBJ);

            $response = [];
            foreach ($resultado as $value) {
                $response[] = [
                   //'unidade' => $this->getUnidade(), // Ou $unidade, se você quiser usar a variável já obtida
                    'data_recebimento_ocorrencia' => $this->alterarFormatoData($value->data_recebimento),
                    'ocorrencia' => $value->ocorrencia, // Ou 'se' se for o nome original
                ];
            }

            return $response;
        }else {
            $sql = 
                "SELECT 
                    tb_digitalizacao.*, 
                    tb_ocorrencias.*
                FROM 
                    tb_digitalizacao 
                INNER JOIN 
                    tb_ocorrencias
                ON 
                    tb_digitalizacao.data_digitalizacao = tb_ocorrencias.data_recebimento
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
                foreach ($resultado as $value) {
                    $response[] = [
                    //'unidade' => $this->getUnidade(), // Ou $unidade, se você quiser usar a variável já obtida
                        'data_recebimento_ocorrencia' => $this->alterarFormatoData($value->data_recebimento),
                        'ocorrencia' => $value->ocorrencia, // Ou 'se' se for o nome original
                    ];
                }
                return $response;
        }
    }

}