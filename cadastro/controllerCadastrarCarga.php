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
        $acr = $_POST['acr'] . '_' . '00061';
        $al = $_POST['al'] . '_' . '00062';
        $am = $_POST['am'] . '_' . '00064';
        $ap = $_POST['ap'] . '_' . '00063';
        $ba = $_POST['ba'] . '_' . '00055';
        $bsb = $_POST['bsb'] . '_' . '00010';
        $ce = $_POST['ce'] . '_' . '00065';
        $es = $_POST['es'] . '_' . '00066';
        $go = $_POST['go'] . '_' . '00060';
        $ma = $_POST['ma'] . '_' . '00068';
        $mg = $_POST['mg'] . '_' . '00030';
        $ms = $_POST['ms'] . '_' . '00070';
        $mt = $_POST['mt'] . '_' . '00069';
        $pa = $_POST['pa'] . '_' . '00071';
        $pb = $_POST['pb'] . '_' . '00072';
        $pe = $_POST['pe'] . '_' . '00050';
        $pi = $_POST['pi'] . '_' . '00073';
        $pr = $_POST['pr'] . '_' . '00035';
        $rj = $_POST['rj'] . '_' . '00074';
        $rn = $_POST['rn'] . '_' . '00075';
        $ro = $_POST['ro'] . '_' . '00078';
        $rr = $_POST['rr'] . '_' . '00079';
        $rs = $_POST['rs'] . '_' . '00076';
        $sc = $_POST['sc'] . '_' . '00045';
        $se = $_POST['se'] . '_' . '00080';
        $spi = $_POST['spi'] . '_' . '00020';
        $spm = $_POST['spm'] . '_' . '00015';
        $to = $_POST['to'] . '_' . '00081';
        $ocorrencia = $_POST['ocorrencia'];

        $superintendencia[] = [
            'ACR' => $acr, 'AL' => $al, 'AM' => $am, 'AP' => $ap, 'BA' => $ba, 'BSB' => $bsb,
            'CE' => $ce, 'ES' => $es, 'GO' => $go, 'MA' => $ma, 'MG' => $mg, 'MS' => $ms,
            'MT' => $mt, 'PA' => $pa, 'PB' => $pb, 'PE' => $pe, 'PI' => $pi, 'PR' => $pr,
            'RJ' => $rj, 'RN' => $rn, 'RO' => $ro, 'RR' => $rr, 'RS' => $rs, 'SC' => $sc,
            'SE' => $se, 'SPI' => $spi, 'SPM' => $spm, 'TO' => $to
        ];
        /*
        $conteudo = $newData . " " . $newUnidade . " " . $newMatricula . " " . $newCargaAnterior . " " . $newCargaRecebida . " " . 
        $newCargaImpossibilitada . " " . $newCargaDigitalizada . " " . $newCargaResto . " " . $ocorrencia;
    
		file_put_contents(__DIR__ . "/meu_arquivo.txt", $conteudo);
        */
		
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