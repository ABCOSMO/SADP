<?php
session_start();
require '../autoload.php';

use FADPD\ConectarUsuario\{
    ConectarBD, SessaoUsuario
};
use FADPD\Lista\{
    SelecionarUnidade, CargaAnterior
};

$unidade = $_SESSION['unidade'];
$matricula = $_SESSION['matricula'];
$autenticandoUsuario = new SessaoUsuario();
$autenticandoUsuario->autenticarUsuario();
$autenticandoUsuario->tempoLoginUsuario();
$escolherUnidade = new SelecionarUnidade();
$cargaAnterior = new CargaAnterior($matricula, $unidade);
$separarNome = explode (" ",$_SESSION['nome']);
$nome = $separarNome[0]." ".$separarNome[1];
date_default_timezone_set('America/Sao_Paulo');
$data = new DateTime('now');
$LancarData = $data->format('d/m/Y');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/styleLancamentoCarga.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <title>FADPD - DELOG</title>
</head>
<body>
<header class="cabecalho">
    <nav class="cabecalho__links">
            <input type="checkbox" id="logoff" class="cabecalho__logoff">
            <label for="logoff">
                <span class="cabecalho__texto" id="menuLogoff"><?php echo $nome . " - " . $unidade;?></span>
            </label>
            <ul class="lista-logoff">
                <li class="lista-logoff__item">
                    <a class="lista-logoff__link" href="../login/index.php?logout=logout">Fazer Logoff</a>
                </li>
            </ul>
        </nav>
        <nav class="cabecalho__links">
            <input type="checkbox" id="menu-digitalizacao" class="cabecalho__digitalizacao">
            <label for="menu-digitalizacao">
                <span class="cabecalho__menu__texto" id="digitalizacao">Digitalização</span>
            </label>
            <ul class="lista-digitalizacao" id="lista">
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="../digitalizacao/alterarExcluirUsuario.php">Cadastrar Usuário</a>
                </li>
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="../digitalizacao/lancarCarga.php">Lançar Dados Digitalização</a>
                </li>
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="../digitalizacao/relatorioDigitalizacao.php">Relatório Digitalização</a>
                </li>
            </ul>
            <a class="cabecalho__menu__texto" href="#">Produção</a>
            <a class="cabecalho__menu__texto" href="http://msc01065329:9888/ecarta/form/getMovimento_frm.ect" target="_blank">Consulta e-Carta</a>
            <a class="cabecalho__menu__texto" href="https://sgd.correios.com.br/sgd/app/" target="_blank">SGD</a>
            <a class="cabecalho__menu__texto" href="https://cas.correios.com.br/login?service=https%3A%2F%2Fapp.correiosnet.int%2Fecarta%2Fpages%2F" target="_blank">e-Carta</a>
            <a class="cabecalho__menu__texto" href="../">Home</a>
        </nav>
    </header>
    <div class="container__caminho">
        <div class="linha">
            <a class="caminhos" href="../">Home</a>  
            <p class="seta"> > </p>
            <a class="caminhos" href="../digitalizacao/lancarCarga.php">Digitalização</a>
            <p class="seta">  > </p>
            <a class="caminhos" href="../digitalizacao/lancarCarga.php">Lançar Dados Digitalização</a>
        </div>
    </div>
    <section class="container__botao">        
            <div class="menuCadastro" id="modal-1">
                <form method="post" id="myForm" name="autenticar" >
                    <div class="modal-header">
                        <h1 class="modal-title">
                            Lançar Dados Digitalização
                        </h1>
                    </div>
                    <section class="modal-body">
                        <div class="input-group">
                            <label for="data">
                                Data
                            </label>
                            <input type="text" id="inputData" name="novaData" value=<?php echo $LancarData; ?> maxlength="10">
                        </div>
                        <div class="input-group">
                            <label for="cargaAnterior">
                                Carga dia anterior
                            </label>
                            <input type="text" id="inputAnterior" name="cargaAnterior" 
                            value=<?php echo $cargaAnterior->mostrarCargaAnterior(); ?> maxlength="7" disabled>
                            <input type="hidden" id="inputAnterior" name="cargaAnterior" 
                            value="<?php echo $cargaAnterior->mostrarCargaAnterior(); ?>">
                        </div>
                        <div class="input-group">
                            <label for="cargaRecebida">
                                Carga recebida
                            </label>
                            <input type="text" id="inputRecebida" name="cargaRecebida" placeholder="" maxlength="7">
                        </div>
                        <div class="input-group">
                            <label for="cargaImpossibilitada">
                                Carga impossibilitada
                            </label>
                            <input type="text" id="inputImpossibilitada" name="cargaImpossibilitada" placeholder="" maxlength="7">
                        </div>
                        <div class="input-group">
                            <label for="CargaDigitalizada">
                                Carga digitalizada
                            </label>
                            <input type="text" id="inputDigitalizada" name="cargaDigitalizada" placeholder="" maxlength="7">
                        </div>
                        <div class="input-group">
                        <label for="resto">
                                Resto do dia
                            </label>
                            <input type="text" id="inputResto" name="cargaResto" placeholder="" maxlength="7">
                        </div>
                    </section>
                    <!--<section>
                        <div class="modal-header">
                            <p class="modal-title titulo">
                                Carga recebida por Superintendência
                            </p>
                        </div>
                    </section>
                    <section>
                        <input class="estados" type="checkbox" id="acr" name="acr">
                        <label class="caixa" for="ACR">
                            SE/ACR
                        </label>
                        <input class="estados" type="checkbox" id="al" name="al">
                        <label class="caixa" for="AL">
                            SE/AL
                        </label>
                        <input class="estados" type="checkbox" id="am" name="am">
                        <label class="caixa" for="AM">
                            SE/AM
                        </label>
                        <input class="estados" type="checkbox" id="ap" name="ap">
                        <label class="caixa" for="AP">
                            SE/AP
                        </label>
                        <input class="estados" type="checkbox" id="ba" name="ba">
                        <label class="caixa" for="BA">
                            SE/BA
                        </label>
                        <input class="estados" type="checkbox" id="bsb" name="bsb">
                        <label class="caixa" for="BSB">
                            SE/BSB
                        </label>
                        <input class="estados" type="checkbox" id="ce" name="ce">
                        <label class="caixa" for="CE">
                            SE/CE
                        </label>
                        <input class="estados" type="checkbox" id="es" name="es">
                        <label class="caixa" for="ES">
                            SE/ES
                        </label>
                        <input class="estados" type="checkbox" id="go" name="go">
                        <label class="caixa" for="GO">
                            SE/GO
                        </label>
                        <input class="estados" type="checkbox" id="ma" name="ma">
                        <label class="caixa" for="MA">
                            SE/MA
                        </label>
                        <input class="estados" type="checkbox" id="mg" name="mg">
                        <label class="caixa" for="MG">
                            SE/MG
                        </label>
                        <input class="estados" type="checkbox" id="ms" name="ms">
                        <label class="caixa" for="MS">
                            SE/MS
                        </label>
                        <input class="estados" type="checkbox" id="mt" name="mt">
                        <label class="caixa" for="MT">
                            SE/MT
                        </label>
                        <input class="estados" type="checkbox" id="pa" name="pa">
                        <label class="caixa" for="PA">
                            SE/PA
                        </label>
                        <input class="estados" type="checkbox" id="pb" name="pb">
                        <label class="caixa" for="PB">
                            SE/PB
                        </label>
                        <input class="estados" type="checkbox" id="pe" name="pe">
                        <label class="caixa" for="PE">
                            SE/PE
                        </label>
                        <input class="estados" type="checkbox" id="pi" name="pi">
                        <label class="caixa" for="PI">
                            SE/PI
                        </label>
                        <input class="estados" type="checkbox" id="pr" name="pr">
                        <label class="caixa" for="PR">
                            SE/PR
                        </label>
                        <input class="estados" type="checkbox" id="rj" name="rj">
                        <label class="caixa" for="RJ">
                            SE/RJ
                        </label>
                        <input class="estados" type="checkbox" id="rn" name="rn">
                        <label class="caixa" for="RN">
                            SE/RN
                        </label>
                        <input class="estados" type="checkbox" id="ro" name="ro">
                        <label class="caixa" for="RO">
                            SE/RO
                        </label>
                        <input class="estados" type="checkbox" id="rr" name="rr">
                        <label class="caixa" for="RR">
                            SE/RR
                        </label>
                        <input class="estados" type="checkbox" id="rs" name="rs">
                        <label class="caixa" for="RS">
                            SE/RS
                        </label>
                        <input class="estados" type="checkbox" id="sc" name="sc">
                        <label class="caixa" for="SC">
                            SE/SC
                        </label>
                        <input class="estados" type="checkbox" id="se" name="se">
                        <label class="caixa" for="SE">
                            SE/SE
                        </label>
                        <input class="estados" type="checkbox" id="spi" name="spi">
                        <label class="caixa" for="SPI">
                            SE/SPI
                        </label>
                        <input class="estados" type="checkbox" id="spm" name="spm">
                        <label class="caixa" for="SPM">
                            SE/SPM
                        </label>
                        <input class="estados" type="checkbox" id="to" name="to">
                        <label class="caixa" for="TO">
                            SE/TO
                        </label>
                    </section>-->
                    <section class="modal-body">
                        <div class="container__cadastro__envio">
                            <input value="Enviar dados" type="submit" id="login-button"></input>
                        </div>
                    </section>
                </form>
                <div id="dadosContainer"></div>
            </div>
            <dialog class="loading"></dialog>        
    </section>
    <footer>
        <div>
            <h3 class="rodape">Desenvolvido pelos CDIPs</h3>
        </div>
    </footer>
    <script src="../script/abrirFecharModal.js" defer></script>
    <script src="../script/relatorioDigitalizacao.js" defer></script>
    <script src="../script/digitarFormulario.js" defer></script>
    <script src="../script/scriptLancarCarga.js" defer></script>
    <script src="../script/validaFormulario.js" defer></script>
    <script src="../script/excluirCargaDigitalizacao.js" defer></script>
    <script src="../header.js" defer></script>
</html>
