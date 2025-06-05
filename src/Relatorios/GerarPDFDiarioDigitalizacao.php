<?php

namespace FADPD\Relatorios;

use FADPD\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class GerarPDFDiarioDigitalizacao extends ConectarBD
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
    
    //Informar data de 15 dias antrás
    public function getDataInicial()
    {
        return $this->dataInicial;
    }
   
   //Informar data de 15 dias depois
    public function getDataFinal()
    {
        return $this->dataFinal;
    }
	
	public function getPerfil()
    {
        return $this->perfil;
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

    public function relatorioDiarioDigitalizacaoPDF() {
        try{

            $unidade = $this->getUnidade();
            $dataInicial = $this->getDataInicial();
            $dataFinal = $this->getDataFinal();
			$perfil = $this->getPerfil();

            if($unidade=="" AND $perfil == "01"){
					$nomeDoArquivo = "Carga_Diaria_Digitalizacao.xls";
                    // Verifica se a carga já foi lançada
                    $sql = "SELECT
                    tb_digitalizacao.*,
                    tb_funcionarios.nome,
                    tb_funcionarios.matricula,
                    tb_unidades.nome_unidade
                    FROM
                        tb_digitalizacao
                    INNER JOIN
                        tb_funcionarios ON tb_digitalizacao.matricula = tb_funcionarios.matricula
                    INNER JOIN
                        tb_unidades ON tb_digitalizacao.mcu_unidade = tb_unidades.mcu_unidade
                    WHERE
                        tb_digitalizacao.data_digitalizacao >= :data_inicial
                        AND tb_digitalizacao.data_digitalizacao <= :data_final
                    ORDER BY
                        tb_unidades.nome_unidade, tb_digitalizacao.data_digitalizacao";
                    $dados = array(
                        ":data_inicial" => $dataInicial, 
                        ":data_final" => $dataFinal,
                    );
                    $query = parent::executarSQL($sql,$dados);
                    $resultado = $query->fetchAll(PDO::FETCH_OBJ);

                    $response = [];
                    foreach($resultado as $key => $value) {
                        $response[] = [
							'Unidade' => $value->nome_unidade,
							'Matricula' => $this->formatarMatricula($value->matricula),
							'Usuario' => $value->nome,
							'Data' => $this->alterarFormatoData($value->data_digitalizacao),
							'Carga_dia_Anterior' => $value->qtd_imagens_dia_anterior,
							'Carga_Recebidas' => $value->qtd_imagens_recebidas_dia,
							'Carga_Impossibilitadas' => $value->qtd_imagens_impossibilitadas,
							'Carga_Digitalizada' => $value->qtd_imagens_incorporadas,
							'Resto_do_dia' => $value->qtd_imagens_resto
                        ];
                    }
                    
                    $response = array_merge($response, $this->relatorioCargaTotalDigitalizacao());
                    return $this->exportarParaExcel($nomeDoArquivo, $response);
                
            }else{
				$nomeDoArquivo = $unidade . "_" . "carga_diaria.xls";
                $sqlUnidade = "SELECT * FROM tb_unidades WHERE nome_unidade = :nome_unidade";
                $dadosUnidade = array(
                    ":nome_unidade" => $unidade
                );
                $queryUnidade = parent::executarSQL($sqlUnidade,$dadosUnidade);
                $resultadoUnidade = $queryUnidade->fetchAll(PDO::FETCH_OBJ);
                foreach($resultadoUnidade as $linha){
                    $mcuUnidade = $linha->mcu_unidade; 
                }
                 // Verifica se a carga já foi lançada
                $sql = "SELECT tb_digitalizacao.*, tb_funcionarios.nome, tb_funcionarios.matricula 
                FROM tb_digitalizacao 
                INNER JOIN tb_funcionarios
                ON tb_digitalizacao.matricula = tb_funcionarios.matricula 
                AND tb_digitalizacao.data_digitalizacao >= :data_inicial AND tb_digitalizacao.data_digitalizacao <= :data_final
                AND tb_digitalizacao.mcu_unidade = :mcu_unidade 
                ORDER BY tb_digitalizacao.data_digitalizacao";
                $dados = array(
                    ":data_inicial" => $dataInicial, 
                    ":data_final" => $dataFinal,
                    ":mcu_unidade" => $mcuUnidade
                );
                $query = parent::executarSQL($sql,$dados);
                $resultado = $query->fetchAll(PDO::FETCH_OBJ);

                $response = [];
                foreach($resultado as $key => $value) {
                    $response[] = [
                        'Unidade' => $this->getUnidade(),
                        'Matricula' => $this->formatarMatricula($value->matricula),
                        'Usuario' => $value->nome,
                        'Data' => $this->alterarFormatoData($value->data_digitalizacao),
                        'Carga_dia_Anterior' => $value->qtd_imagens_dia_anterior,
                        'Carga_Recebidas' => $value->qtd_imagens_recebidas_dia,
                        'Carga_Impossibilitadas' => $value->qtd_imagens_impossibilitadas,
						'Carga_Digitalizada' => $value->qtd_imagens_incorporadas,
                        'Resto_do_dia' => $value->qtd_imagens_resto
                    ];
                }
               
                $response = array_merge($response, $this->relatorioCargaTotalDigitalizacao());
                return $this->exportarParaExcel($nomeDoArquivo, $response);
            }          

        }catch(\Exception $e) {
            $response = array('success' => false, 'error' => $e->getMessage());
            return $response;
        }
    }
	
    public function relatorioCargaTotalDigitalizacao()
    {
        try{

            $unidade = $this->getUnidade();
            $dataInicial = $this->getDataInicial();
            $dataFinal = $this->getDataFinal();
			$perfil = $this->getPerfil();
            
            
            // Verifica se a carga já foi lançada
            $sql = "SELECT
                    tb_unidades.nome_unidade,
                    SUM(tb_digitalizacao.qtd_imagens_dia_anterior) AS qtd_imagens_dia_anterior,
                    SUM(tb_digitalizacao.qtd_imagens_recebidas_dia) AS qtd_imagens_recebidas_dia,
                    SUM(tb_digitalizacao.qtd_imagens_impossibilitadas) AS qtd_imagens_impossibilitadas,
                    SUM(tb_digitalizacao.qtd_imagens_incorporadas) AS qtd_imagens_incorporadas,
                    SUM(tb_digitalizacao.qtd_imagens_resto) AS qtd_imagens_resto
                    FROM tb_digitalizacao
                    INNER JOIN tb_unidades ON tb_digitalizacao.mcu_unidade = tb_unidades.mcu_unidade
                    WHERE tb_digitalizacao.data_digitalizacao BETWEEN :data_inicial AND :data_final";
            
            // Parâmetros base
            $dados = [
                ":data_inicial" => $dataInicial, 
                ":data_final" => $dataFinal
            ];

            // Adiciona filtro por unidade se necessário
            if(!empty($unidade)) {
                $sql .= " AND tb_unidades.nome_unidade = :nome_unidade";
                $dados[":nome_unidade"] = $unidade;
            }

            $sql .= " GROUP BY tb_unidades.nome_unidade";

            $query = parent::executarSQL($sql, $dados);
            $resultado = $query->fetchAll(PDO::FETCH_OBJ);

            $responseTotal = [];
             $responseTotal = [
                'Unidade' => empty($unidade) ? "--" : $unidade,
                'Matricula' => '--',
                'Usuario' => '--',
                'Data' => 'Total',
                'Carga_dia_anterior' => 0, // Inicialize com zero
                'Carga_Recebida' => 0, // Inicialize com zero
                'Carga_Impossibilitada' => 0, // Inicialize com zero
                'Carga_Digitalizada' => 0, // Inicialize com zero
                'Resto_do_dia' => 0 // Inicialize com zero
            ];
            foreach($resultado as $value) {
                // Acumule os valores em cada chave
                $responseTotal['Carga_dia_anterior'] += (int)$value->qtd_imagens_dia_anterior;
                $responseTotal['Carga_Recebida'] += (int)$value->qtd_imagens_recebidas_dia;                
                $responseTotal['Carga_Impossibilitada'] += (int)$value->qtd_imagens_impossibilitadas;
                $responseTotal['Carga_Digitalizada'] += (int)$value->qtd_imagens_incorporadas;
                $responseTotal['Resto_do_dia'] += (int)$value->qtd_imagens_resto;
            }

            $responseTotal = [$responseTotal];
			return $responseTotal;

        }catch(\Exception $e) {
            $responseTotal = array('success' => false, 'error' => $e->getMessage());
            return $responseTotal;
        }
    }

	public function exportarParaExcel($nomeArquivo = "dados.xls", $dados = []) {
		// Define os cabeçalhos para download do arquivo Excel
		header('Content-Type: application/vnd.ms-excel; charset=utf-8');
		header('Content-Disposition: attachment; filename="' . $nomeArquivo . '"');
		echo "\xEF\xBB\xBF"; 
		
		// Inicia a tabela HTML
		echo '<table border="1">';
	
		// Define os cabeçalhos a serem usados
		$cabecalhosPadrao = [
			'Unidade', 'Matrícula', 'Usuário', 'Data',
			'Carga dia anterior', 'Carga Recebida', 'Carga impossibilitada',
			'Carga Digitalizada', 'Resto do dia'
		];
		
		// Se houver dados, gera o cabeçalho da tabela com base nas chaves do primeiro item
		if (!empty($dados)) {
			// Assume que o primeiro item do array de dados contém as chaves para os cabeçalhos
			echo '<tr>';
			foreach (array_keys($dados[0]) as $cabecalho) {
				echo '<th>' . htmlspecialchars($cabecalho) . '</th>';
			}
			echo '</tr>';
	
			// Gera as linhas da tabela com os dados
			foreach ($dados as $linha) {
				echo '<tr>';
				foreach ($linha as $valor) {
					echo '<td>' . htmlspecialchars($valor) . '</td>';
				}
				echo '</tr>';
			}
		} else {
			// Se não houver dados, usa os cabeçalhos padrão
			echo '<tr>';
			foreach ($cabecalhosPadrao as $cabecalho) {
				echo '<th class="usuario">' . htmlspecialchars($cabecalho) . '</th>';
			}
			echo '</tr>';
		}
		
		// Fecha a tabela HTML
		echo '</table>';
		exit; // É importante usar exit para garantir que nenhum outro conteúdo seja enviado após o arquivo Excel
	}
}