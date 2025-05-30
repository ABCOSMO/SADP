<?php
    session_start();
    require '../autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Cadastrar\CadastrarCarga;
 
    if(isset($_POST['novaData']))
    {  
		$newData = $_POST['novaData'];
        $newUnidade = $_SESSION['unidade'];
        $newMatricula = $_SESSION['matricula'];
        $newCargaAnterior = $_POST['cargaAnterior'];
        $newCargaRecebida = $_POST['cargaRecebida'];
        $newCargaImpossibilitada = $_POST['cargaImpossibilitada'];
        $newCargaDigitalizada = $_POST['cargaDigitalizada'];
        $newCargaResto = $_POST['cargaResto'];

        /*$conteudo = $newData . " " . $newUnidade . " " . $newMatricula . " " . $newCargaAnterior . " " . $newCargaRecebida . " " . 
        $newCargaImpossibilitada . " " . $newCargaDigitalizada . " " . $newCargaResto;
		
		file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);*/
		
        $novaCarga = new CadastrarCarga(
            $newData,
            $newUnidade,
            $newMatricula,
            $newCargaAnterior,
            $newCargaRecebida,
            $newCargaImpossibilitada,
            $newCargaDigitalizada,
            $newCargaResto
        );
        
        $novaCarga->lancamentoDaCarga();
    }
?>