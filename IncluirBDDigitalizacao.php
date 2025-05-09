<?php
require 'autoload.php';

use FADPD\ConectarUsuario\ConectarBD;


class IncluirBDDigitalizacao extends ConectarBD
{
	public function bancoDadosDigitalizacao () {
		$nomeArquivo = __DIR__ . '\\dbDigitalizacao.csv'; // Substitua pelo nome do seu arquivo TXT
		
		if (($arquivoTXT = fopen($nomeArquivo, "r")) !== false) {
			while (($linha = fgets($arquivoTXT)) !== false) {
				// Remove espaços em branco extras e quebras de linha no final da linha
				$linha = trim($linha);
		
				// Divide a linha usando o ";" como delimitador
				$campos = explode(";", $linha);
		
				// Certifique-se de que a linha tem o número correto de campos
				if (count($campos) === 11) {
					// Atribui os valores às variáveis correspondentes				
					$id = trim($campos[0]);
					$mcu = trim($campos[1]);
					$matricula = trim($campos[2]);
					$data = trim($campos[3]);
					$diaAnterior = trim($campos[4]);
					$recibido = trim($campos[5]);
					$incorporado = trim($campos[6]);
					$impossibilitado = trim($campos[7]);
					$nada = trim($campos[8]);
					$resto = trim($campos[9]);
					$mes = trim($campos[10]);
					// O sexto campo ($campos[6]) não está sendo usado na sua query.
					// Se houver um sétimo campo, você precisará decidir o que fazer com ele.
		
					// Prepara e executa a query de inserção
					$sql = "insert into tb_digitalizacao (
					mcu_unidade, 
					matricula, 
					data_digitalizacao, 
					qtd_imagens_dia_anterior, 
					qtd_imagens_recebidas_dia, 
					qtd_imagens_incorporadas, 
					qtd_imagens_impossibilitadas,
					qtd_imagens_incorporadas_dia, 
					qtd_imagens_resto
					) values
					(
					:mcu_unidade, 
					:matricula, 
					:data_digitalizacao, 
					:qtd_imagens_dia_anterior, 
					:qtd_imagens_recebidas_dia, 
					:qtd_imagens_incorporadas, 
					:qtd_imagens_impossibilitadas,
					:qtd_imagens_incorporadas_dia,
					:qtd_imagens_resto
					)";
					$dados = array(
						":mcu_unidade" => $mcu,
						":matricula" => $matricula,
						":data_digitalizacao" => $data,
						":qtd_imagens_dia_anterior" => $diaAnterior,
						":qtd_imagens_recebidas_dia" => $recibido,
						":qtd_imagens_incorporadas" => $incorporado,
						":qtd_imagens_impossibilitadas" => $impossibilitado,
						":qtd_imagens_incorporadas_dia" => $nada,
						":qtd_imagens_resto" => $resto
					);
					$query = parent::executarSQL($sql,$dados);
		
					if ($query) {
						echo "Linha inserida com sucesso: " . $linha . "<br>";
					} else {
						echo "Erro ao inserir a linha: " . $linha . "<br>";
						// Você pode adicionar um tratamento de erro mais detalhado aqui
					}
				} else {
					echo "Erro: Número incorreto de campos na linha: " . $linha . "<br>";
				}
			}
			fclose($arquivoTXT);
		} else {
			echo "Erro ao abrir o arquivo: " . $nomeArquivo;
		}
	}
}

$incluir = new IncluirBDDigitalizacao();
$incluir->bancoDadosDigitalizacao();

?>