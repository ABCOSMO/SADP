<?php
    session_start();
    require '../autoload.php';
    
    use SADP\ConectarUsuario\ConectarBD;
    use SADP\Cadastrar\CadastrarCarga;
 
    if(isset($_POST['novaData']))
    {  
		$newData = $_POST['novaData'];
        $newUnidade = $_SESSION['unidade'];
        $newMatricula = $_SESSION['matricula'];
        $newCargaAnterior = $_POST['cargaAnterior'];
        $newCargaRecebida = $_POST['cargaRecebida'];
        $newCargaDigitalizada = $_POST['cargaDigitalizada'];
        $newCargaResto = $_POST['cargaResto'];
        $testeCarga = $newData . ' ' . $newUnidade . ' ' . $newMatricula . ' ' . $newCargaAnterior . ' ' . $newCargaRecebida
        . ' ' . $newCargaDigitalizada . ' ' . $newCargaResto;
		
		
        $novaCarga = new CadastrarCarga(
            $newData,
            $newUnidade,
            $newMatricula,
            $newCargaAnterior,
            $newCargaRecebida,
            $newCargaDigitalizada,
            $newCargaResto
        );
        
        $novaCarga->lancamentoDaCarga();
    }
?>