<?php
    session_start();
    require 'autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Relatorios\GerarRelatorioUnidade;

		$unidade = 'CDIP BRASÍLIA ';
        $matricula = '8.134.249-7';
      
        /*
        $conteudo = $dataCadastrada . " " . $unidade . " " . $matricula . " " . $cargaAnterior . " " . $cargaRecebida . " " . 
        $cargaImpossibilitada . " " . $cargaDigitalizada . " " . $cargaResto;
		
		file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);
        */
        $gerarRelatorioDigitalizacao = new GerarRelatorioUnidade(
            $matricula,
            $unidade,
        );
    
        $gerarRelatorioDigitalizacao->relatorioUnidade();
 
?>