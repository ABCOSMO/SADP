<?php

namespace FADPD\Relatorios;

use FADPD\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class GerarRelatorioMensalDigitalizacao extends ConectarBD
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

public function relatorioMensalDigitalizacao() {
    try {
        $unidade = $this->getUnidade();
        $dataInicial = $this->getDataInicial();
        $dataFinal = $this->getDataFinal();
        $perfil = $this->getPerfil();

        // Corrigindo a condição lógica
        $mostrarTodasUnidades = ($perfil == "01" || $perfil == "05") && empty($unidade);

        if($mostrarTodasUnidades) {
            $sql = "SELECT
                    tb_unidades.nome_unidade,
                    MONTH(tb_digitalizacao.data_digitalizacao) AS mes,
                    SUM(tb_digitalizacao.qtd_imagens_dia_anterior) AS qtd_imagens_dia_anterior,
                    SUM(tb_digitalizacao.qtd_imagens_recebidas_dia) AS qtd_imagens_recebidas_dia,
                    SUM(tb_digitalizacao.qtd_imagens_incorporadas) AS qtd_imagens_incorporadas,
                    SUM(tb_digitalizacao.qtd_imagens_impossibilitadas) AS qtd_imagens_impossibilitadas,
                    SUM(tb_digitalizacao.qtd_imagens_resto) AS qtd_imagens_resto
                    FROM tb_digitalizacao
                    INNER JOIN tb_unidades ON tb_digitalizacao.mcu_unidade = tb_unidades.mcu_unidade
                    WHERE tb_digitalizacao.data_digitalizacao BETWEEN :data_inicial AND :data_final
                    GROUP BY tb_unidades.nome_unidade, mes";
            $dados = [
                ":data_inicial" => $dataInicial, 
                ":data_final" => $dataFinal
            ];
        } else {
            $sql = "SELECT
                    tb_unidades.nome_unidade,
                    MONTH(tb_digitalizacao.data_digitalizacao) AS mes,
                    SUM(tb_digitalizacao.qtd_imagens_dia_anterior) AS qtd_imagens_dia_anterior,
                    SUM(tb_digitalizacao.qtd_imagens_recebidas_dia) AS qtd_imagens_recebidas_dia,
                    SUM(tb_digitalizacao.qtd_imagens_incorporadas) AS qtd_imagens_incorporadas,
                    SUM(tb_digitalizacao.qtd_imagens_impossibilitadas) AS qtd_imagens_impossibilitadas,
                    SUM(tb_digitalizacao.qtd_imagens_resto) AS qtd_imagens_resto
                    FROM tb_digitalizacao
                    INNER JOIN tb_unidades ON tb_digitalizacao.mcu_unidade = tb_unidades.mcu_unidade
                    WHERE tb_digitalizacao.data_digitalizacao BETWEEN :data_inicial AND :data_final
                    AND tb_unidades.nome_unidade = :nome_unidade
                    GROUP BY tb_unidades.nome_unidade, mes";
            $dados = [
                ":data_inicial" => $dataInicial, 
                ":data_final" => $dataFinal,
                ":nome_unidade" => $unidade
            ];
        }

        $query = parent::executarSQL($sql, $dados);
        $resultado = $query->fetchAll(PDO::FETCH_OBJ);

        $response = [];
        foreach($resultado as $value) {
            $mes = (int) $value->mes;
            $response[] = [
                'perfil' => $this->getPerfil(),
                'unidade' => $mostrarTodasUnidades ? $value->nome_unidade : $this->getUnidade(),
                'data_mes' => $this->buscarMes($mes),
                'data_ano' => $this->ano,
                'imagens_anterior' => (int)$value->qtd_imagens_dia_anterior,
                'imagens_recebidas' => (int)$value->qtd_imagens_recebidas_dia,
                'imagens_incorporadas' => (int)$value->qtd_imagens_incorporadas,
                'imagens_impossibilitadas' => (int)$value->qtd_imagens_impossibilitadas,
                'resto' => (int)$value->qtd_imagens_resto
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($response);

    } catch(\Exception $e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode([
            'success' => false, 
            'error' => $e->getMessage()
        ]);
    }
}

    public function relatorioCargaTotalDigitalizacao()
    {
        try {
            $unidade = $this->getUnidade();
            $dataInicial = $this->getDataInicial();
            $dataFinal = $this->getDataFinal();
            $perfil = $this->getPerfil();

            // Monta a consulta SQL base
            $sql = "SELECT
                    tb_unidades.nome_unidade,
                    SUM(tb_digitalizacao.qtd_imagens_dia_anterior) AS qtd_imagens_dia_anterior,
                    SUM(tb_digitalizacao.qtd_imagens_recebidas_dia) AS qtd_imagens_recebidas_dia,
                    SUM(tb_digitalizacao.qtd_imagens_incorporadas) AS qtd_imagens_incorporadas,
                    SUM(tb_digitalizacao.qtd_imagens_impossibilitadas) AS qtd_imagens_impossibilitadas,
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
                'perfil' => $perfil, // O perfil e a unidade provavelmente serão os mesmos para todos os itens
                'unidade' => empty($unidade) ? "--" : $unidade,
                'data_ano' => $this->ano,
                'imagens_anterior' => 0, // Inicialize com zero
                'imagens_recebidas' => 0, // Inicialize com zero
                'imagens_incorporadas' => 0, // Inicialize com zero
                'imagens_impossibilitadas' => 0, // Inicialize com zero
                'resto' => 0 // Inicialize com zero
            ];

            foreach($resultado as $value) {
                // Acumule os valores em cada chave
                $responseTotal['imagens_anterior'] += (int)$value->qtd_imagens_dia_anterior;
                $responseTotal['imagens_recebidas'] += (int)$value->qtd_imagens_recebidas_dia;
                $responseTotal['imagens_incorporadas'] += (int)$value->qtd_imagens_incorporadas;
                $responseTotal['imagens_impossibilitadas'] += (int)$value->qtd_imagens_impossibilitadas;
                $responseTotal['resto'] += (int)$value->qtd_imagens_resto;
            }

            $responseTotal = [$responseTotal];

            // Envia o response apenas uma vez
            header('Content-Type: application/json');
            echo json_encode($responseTotal);

        } catch(\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'error' => $e->getMessage()
            ]);
        }
    }
}