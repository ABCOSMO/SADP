<?php
    require 'autoload.php';
    
    use FADPD\ConectarUsuario\ConectarBD;
    use FADPD\Cadastrar\AlterarSEOcorrencia;

    $unidade = 'CDIP CURITIBA';
    $matricula = "99999999";
	//$unidade = mb_convert_encoding($unidade, 'UTF-8', 'ISO-8859-1');
    $dataDigitalizacao = '26/05/2025';	
	$ocorrencia = 'Teste CWB 2';
$seStates = [
    [
        'se_numero' => '00003',
        'status' => 0
    ],
    [
        'se_numero' => '00004',
        'status' => 0
    ],
    [
        'se_numero' => '00005',
        'status' => 0
    ],
    [
        'se_numero' => '00006',
        'status' => 0
    ],
    [
        'se_numero' => '00008',
        'status' => 0
    ],
    [
        'se_numero' => '00012',
        'status' => 0
    ],
    [
        'se_numero' => '00010',
        'status' => 0
    ],
    [
        'se_numero' => '00012',
        'status' => 0
    ],
    [
        'se_numero' => '00016',
        'status' => 0
    ],
    [
        'se_numero' => '00018',
        'status' => 0
    ],
    [
        'se_numero' => '00024',
        'status' => 0
    ],
    [
        'se_numero' => '00022',
        'status' => 0
    ],
    [
        'se_numero' => '00020',
        'status' => 0
    ],
    [
        'se_numero' => '00028',
        'status' => 0
    ],
    [
        'se_numero' => '00030',
        'status' => 1
    ],
    [
        'se_numero' => '00036',
        'status' => 0
    ],
    [
        'se_numero' => '00032',
        'status' => 0
    ],
    [
        'se_numero' => '00034',
        'status' => 0
    ],
    [
        'se_numero' => '00050',
        'status' => 1
    ],
    [
        'se_numero' => '00060',
        'status' => 0
    ],
    [
        'se_numero' => '00064',
        'status' => 1
    ],
    [
        'se_numero' => '00026',
        'status' => 0
    ],
    [
        'se_numero' => '00065',
        'status' => 0
    ],
    [
        'se_numero' => '00068',
        'status' => 1
    ],
    [
        'se_numero' => '00074',
        'status' => 0
    ],
    [
        'se_numero' => '00072',
        'status' => 0
    ],
    [
        'se_numero' => '00070',
        'status' => 0
    ],
    [
        'se_numero' => '00075',
        'status' => 1
    ]
];

   $alterarDadosDigitalizacao = new AlterarSEOcorrencia(
            $unidade,
			$matricula,
			$dataDigitalizacao,
            $seStates,
            $ocorrencia
        );
        
        $alterarDadosDigitalizacao->alterarDadosSE();