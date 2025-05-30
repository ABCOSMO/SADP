<?php

namespace FADPD\Relatorios;

use FADPD\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class GerarPDFMensalDigitalizacao extends ConectarBD
{
    private $unidade;
    private $ano;
	private $perfil;
    
	function __construct(
		$unidade, 
		$ano, 
		$perfil
	)
    {
        parent::__construct();
        $this->unidade = $unidade;
        $this->ano = $ano;
		$this->perfil = $perfil;
    }

    //Informar unidade
    public function getUnidade()
    {
        return $this->unidade;
    }
    
    //Informar data de 15 dias antr�s
    public function getAno()
    {
        return $this->ano;
    }
   
	public function getDataInicial()
	{
		return $this->getAno() . "-01-01";
	}
   
    public function getDataFinal()
	{
		return $this->getAno() . "-12-31";
	}
	
	public function getPerfil()
    {
        return $this->perfil;
    }

    public function buscarMes($mesDoDB)
    {
        $nomeMes = '';
        switch ($mesDoDB) {
            case 1: $nomeMes = 'Janeiro'; break;
            case 2: $nomeMes = 'Fevereiro'; break;
            case 3: $nomeMes = 'Março'; break;
            case 4: $nomeMes = 'Abril'; break;
            case 5: $nomeMes = 'Maio'; break;
            case 6: $nomeMes = 'Junho'; break;
            case 7: $nomeMes = 'Julho'; break;
            case 8: $nomeMes = 'Agosto'; break;
            case 9: $nomeMes = 'Setembro'; break;
            case 10: $nomeMes = 'Outubro'; break;
            case 11: $nomeMes = 'Novembro'; break;
            case 12: $nomeMes = 'Dezembro'; break;
            default: $nomeMes = 'Mês Desconhecido'; break;
        }
        return $nomeMes;
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

    public function relatorioMensalDigitalizacaoPDF() {
        try{

            $unidade = $this->getUnidade();
            $dataInicial = $this->getDataInicial();
            $dataFinal = $this->getDataFinal();
			$perfil = $this->getPerfil();

            if($perfil == "01" AND $unidade == ""){ 
					$nomeDoArquivo = "Carga_Mensal_Digitalizacao.xls";
                    // Verifica se a carga já foi lançada
                    $sql = "SELECT
                    tb_unidades.nome_unidade,
					MONTH(tb_digitalizacao.data_digitalizacao) AS mes,
					SUM(tb_digitalizacao.qtd_imagens_dia_anterior) AS qtd_imagens_dia_anterior,
					SUM(tb_digitalizacao.qtd_imagens_recebidas_dia) AS qtd_imagens_recebidas_dia,
					SUM(tb_digitalizacao.qtd_imagens_incorporadas) AS qtd_imagens_incorporadas,
					SUM(tb_digitalizacao.qtd_imagens_impossibilitadas) AS qtd_imagens_impossibilitadas,
					SUM(tb_digitalizacao.qtd_imagens_resto) AS qtd_imagens_resto
                    FROM
                        tb_digitalizacao
                    INNER JOIN
                        tb_unidades ON tb_digitalizacao.mcu_unidade = tb_unidades.mcu_unidade
                    WHERE
                        tb_digitalizacao.data_digitalizacao >= :data_inicial                        
					AND 
						tb_digitalizacao.data_digitalizacao <= :data_final
                    GROUP BY
                        tb_unidades.nome_unidade, mes";
                    $dados = array(
                        ":data_inicial" => $dataInicial, 
                        ":data_final" => $dataFinal,
                    );
                    $query = parent::executarSQL($sql,$dados);
                    $resultado = $query->fetchAll(PDO::FETCH_OBJ);

                    $response = [];
                    foreach($resultado as $key => $value) {
						$mes = (int) $value->mes;
                                                
                        $response[] = [
                            'Unidade' => $value->nome_unidade,
                            'Mes' => $this->buscarMes($mes) . ' - ' . $this->ano,
                            'Carga_dia_anterior' => $value->qtd_imagens_dia_anterior,
                            'Carga_Recebidas' => $value->qtd_imagens_recebidas_dia,
							'Carga_Impossibilitada' => $value->qtd_imagens_impossibilitadas,
                            'Carga_Digitalizada' => $value->qtd_imagens_incorporadas,
                            'Resto_do_dia' => $value->qtd_imagens_resto
                        ];
                    }
                    			
                    return $this->exportarParaExcel($nomeDoArquivo, $response);
                
            }else{
				$nomeDoArquivo = $unidade . "_Carga_Mensal_Digitalizacao.xls";
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
                 $sql = "SELECT
                 tb_unidades.nome_unidade,
                 MONTH(tb_digitalizacao.data_digitalizacao) AS mes,
                 SUM(tb_digitalizacao.qtd_imagens_dia_anterior) AS qtd_imagens_dia_anterior,
                 SUM(tb_digitalizacao.qtd_imagens_recebidas_dia) AS qtd_imagens_recebidas_dia,
                 SUM(tb_digitalizacao.qtd_imagens_incorporadas) AS qtd_imagens_incorporadas,
                 SUM(tb_digitalizacao.qtd_imagens_impossibilitadas) AS qtd_imagens_impossibilitadas,
                 SUM(tb_digitalizacao.qtd_imagens_resto) AS qtd_imagens_resto
                 FROM
                     tb_digitalizacao
                 INNER JOIN
                     tb_unidades ON tb_digitalizacao.mcu_unidade = tb_unidades.mcu_unidade
                 WHERE
                     tb_digitalizacao.data_digitalizacao >= :data_inicial                        
                 AND 
                     tb_digitalizacao.data_digitalizacao <= :data_final
                 AND 
                    tb_unidades.nome_unidade = :nome_unidade
                 GROUP BY
                      tb_unidades.nome_unidade, mes";
                 $dados = array(
                     ":data_inicial" => $dataInicial, 
                     ":data_final" => $dataFinal,
                     ":nome_unidade" =>$unidade
                 );
                 $query = parent::executarSQL($sql,$dados);
                 $resultado = $query->fetchAll(PDO::FETCH_OBJ);

                $response = [];
                foreach($resultado as $key => $value) {
                    $mes = (int) $value->mes;
                    $response[] = [
                        'Unidade' => $this->getUnidade(),
                        'Mes' => $this->buscarMes($mes) . " _ " . $this->ano,
                        'Carga_dia_anterior' => $value->qtd_imagens_dia_anterior,
                        'Carga_Recebida' => $value->qtd_imagens_recebidas_dia,
						'Carga_Impossibilitada' => $value->qtd_imagens_impossibilitadas,
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
            $sql = "SELECT
            tb_unidades.nome_unidade,
            SUM(tb_digitalizacao.qtd_imagens_dia_anterior) AS qtd_imagens_dia_anterior,
            SUM(tb_digitalizacao.qtd_imagens_recebidas_dia) AS qtd_imagens_recebidas_dia,
            SUM(tb_digitalizacao.qtd_imagens_incorporadas) AS qtd_imagens_incorporadas,
            SUM(tb_digitalizacao.qtd_imagens_impossibilitadas) AS qtd_imagens_impossibilitadas,
            SUM(tb_digitalizacao.qtd_imagens_resto) AS qtd_imagens_resto
            FROM
                tb_digitalizacao
            INNER JOIN
                tb_unidades ON tb_digitalizacao.mcu_unidade = tb_unidades.mcu_unidade
            WHERE
                tb_digitalizacao.data_digitalizacao >= :data_inicial                        
            AND 
                tb_digitalizacao.data_digitalizacao <= :data_final
            AND 
            tb_unidades.nome_unidade = :nome_unidade
            GROUP BY
                tb_unidades.nome_unidade";
            $dados = array(
                ":data_inicial" => $dataInicial, 
                ":data_final" => $dataFinal,
                ":nome_unidade" =>$unidade
            );
            $query = parent::executarSQL($sql,$dados);
            $resultado = $query->fetchAll(PDO::FETCH_OBJ);

            $responseTotal = [];
            foreach($resultado as $key => $value) {
                $responseTotal[] = [
					'Unidade' => $this->getUnidade(),
					'Mes' => "Total",
					'Carga_dia_anterior' => $value->qtd_imagens_dia_anterior,
					'Carga_Recebida' => $value->qtd_imagens_recebidas_dia,
					'Carga_Impossibilitada' => $value->qtd_imagens_impossibilitadas,
					'Carga_Digitalizada' => $value->qtd_imagens_incorporadas,                        
					'Resto_do_dia' => $value->qtd_imagens_resto
                ];                        
            }          
			return $responseTotal;
        }catch(\Exception $e) {
            $responseTotal = array('success' => false, 'error' => $e->getMessage());
            return $responseTotal;
        }
    }
	public function exportarParaExcel($nomeArquivo = "dados.xls", $dados = []) {
		// Define os cabeçalhos para download do arquivo Excel
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="' . $nomeArquivo . '"');
		
		// Inicia a tabela HTML
		echo '<table border="1">';
	
		// Define os cabeçalhos a serem usados
		$cabecalhosPadrao = [
			'Unidade', 'Mês', 'Carga dia anterior', 'Carga recebida',
			'Carga impossibilitada','Carga Digitalizada', 'Resto do dia'
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