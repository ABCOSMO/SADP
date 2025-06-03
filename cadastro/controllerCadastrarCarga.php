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
        $acr = $_POST['acr'] . '_' . '00003';
        $al = $_POST['al'] . '_' . '00004';
        $am = $_POST['am'] . '_' . '00006';
        $ap = $_POST['ap'] . '_' . '00005';
        $ba = $_POST['ba'] . '_' . '00008';
        $bsb = $_POST['bsb'] . '_' . '00010';
        $ce = $_POST['ce'] . '_' . '00012';
        $es = $_POST['es'] . '_' . '00014';
        $go = $_POST['go'] . '_' . '00016';
        $ma = $_POST['ma'] . '_' . '00018';
        $mg = $_POST['mg'] . '_' . '00020';
        $ms = $_POST['ms'] . '_' . '00022';
        $mt = $_POST['mt'] . '_' . '00024';
        $pa = $_POST['pa'] . '_' . '00028';
        $pb = $_POST['pb'] . '_' . '00030';
        $pe = $_POST['pe'] . '_' . '00032';
        $pi = $_POST['pi'] . '_' . '00034';
        $pr = $_POST['pr'] . '_' . '00036';
        $rj = $_POST['rj'] . '_' . '00050';
        $rn = $_POST['rn'] . '_' . '00060';
        $ro = $_POST['ro'] . '_' . '00026';
        $rr = $_POST['rr'] . '_' . '00065';
        $rs = $_POST['rs'] . '_' . '00064';
        $sc = $_POST['sc'] . '_' . '00068';
        $se = $_POST['se'] . '_' . '00070';
        $spi = $_POST['spi'] . '_' . '00074';
        $spm = $_POST['spm'] . '_' . '00072';
        $to = $_POST['to'] . '_' . '00075';
        $ocorrencia = $_POST['ocorrencia'];

        $superintendencia[] = [
            'ACR' => $acr, 'AL' => $al, 'AM' => $am, 'AP' => $ap, 'BA' => $ba, 'BSB' => $bsb,
            'CE' => $ce, 'ES' => $es, 'GO' => $go, 'MA' => $ma, 'MG' => $mg, 'MS' => $ms,
            'MT' => $mt, 'PA' => $pa, 'PB' => $pb, 'PE' => $pe, 'PI' => $pi, 'PR' => $pr,
            'RJ' => $rj, 'RN' => $rn, 'RO' => $ro, 'RR' => $rr, 'RS' => $rs, 'SC' => $sc,
            'SE' => $se, 'SPI' => $spi, 'SPM' => $spm, 'TO' => $to
        ];
        
        $conteudo = $newData . " " . $newUnidade . " " . $newMatricula . " " . $newCargaAnterior . " " . $newCargaRecebida . " " . 
        $newCargaImpossibilitada . " " . $newCargaDigitalizada . " " . $newCargaResto . " " . $acr;
    
		file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);
        
		
        $novaCarga = new CadastrarCarga(
            $newData,
            $newUnidade,
            $newMatricula,
            $newCargaAnterior,
            $newCargaRecebida,
            $newCargaImpossibilitada,
            $newCargaDigitalizada,
            $newCargaResto,
            $superintendencia,
            $ocorrencia
        );
        
        $novaCarga->lancamentoDaCarga();
    }
?>