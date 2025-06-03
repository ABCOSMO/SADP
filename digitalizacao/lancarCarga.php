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
if($separarNome[0] != "Visitante"){
	$nome = $separarNome[0]." ".$separarNome[1];
}else{
	$nome = $separarNome[0];
}
date_default_timezone_set('America/Sao_Paulo');
$data = new DateTime('now');
$LancarData = $data->format('d/m/Y');
$perfil = $_SESSION['privilegio'];
$codificarPefil = hash('sha256', $perfil)
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
			<input type="hidden" id="perfilOculto" value=<?php echo $codificarPefil; ?>>
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
                <li id="cadastrarUsuario" class="lista-digitalizacao__item">
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
            <div class="menuCadastro" id="modal-100000000">
                <form method="post" id="myForm" name="autenticar" >
                    <div class="modal-header">
                        <h1 class="modal-title">
                            Lançar Dados Digitalização
                        </h1>
                    </div>
                    <section class="modal-body" id="lancaDados">
                        <div class="input-group">
                            <label for="data">
                                Data
                            </label>
                            <input type="date" id="inputData" name="novaData" value="" maxlength="10" min="2022-01-01" max="2035-12-31" value="2025-04-25">
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
                
                    <dialog class="manter__aberto" id="modal-1">
                            <div class="modal-header">
                                <p class="modal-title titulo">Carga recebida por Superintendência</p>
                                <button class="close-modal" data-modal="modal-1" type="button">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <section class="container__se">
                                <div class="coluna__se">
                                    <label class="caixa" for="ACR">
                                        ACR
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-1" name="acr" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="AL">
                                        AL
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-2" name="al" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="AM">
                                        AM
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-3" name="am" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="AP">
                                        AP
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-4" name="ap" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="BA">
                                        BA
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-5" name="ba" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="BSB">
                                        BSB
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-6" name="bsb" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="CE">
                                        CE
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-7" name="ce" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="ES">
                                        ES
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-8" name="es" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="GO">
                                        GO
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-9" name="go" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="MA">
                                        MA
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-10" name="ma" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="MG">
                                        MG
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-11" name="mg" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="MS">
                                        MS
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-12" name="ms" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="MT">
                                        MT
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-13" name="mt" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="PA">
                                        PA
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-14" name="pa" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="PB">
                                        PB
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-15" name="pb" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="PE">
                                        PE
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-16" name="pe" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="PI">
                                        PI
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-17" name="pi" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="PR">
                                        PR
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-18" name="pr" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="RJ">
                                        RJ
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-19" name="rj" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="RN">
                                        RN
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-20" name="rn" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="RO">
                                        RO
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-21" name="ro" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="RR">
                                        RR
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-22" name="rr" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="RS">
                                        RS
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-23" name="rs" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="SC">
                                        SC
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-24" name="sc" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="SE">
                                        SE
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-25" name="se" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="SPI">
                                        SPI
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-26" name="spi" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="SPM">
                                        SPM
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-27" name="spm" value="Não recebida">
                                </div>
                                <div class="coluna__se">
                                    <label class="caixa" for="TO">
                                        TO
                                    </label>
                                    <input class="Estado__nao_recebida Estado__recebida" type="button" id="se-28" name="to" value="Não recebida">
                                </div>
                            </section>
                            <section class="container__ocorrencias">
                                <div class="coluna__ocorrencias">
									<label class="areatexto" for="texto">
										Registrar Ocorrências
									</label>
									<textarea class="ocorrencias" id="ocorrencia" name="ocorrencia"
									placeholder="Escreva a ocorrência aqui..." autofocus></textarea>
                                </div>
                            </section>
                            <section class="modal-body">
                                <div class="container__cadastro__envio">
                                    <input value="Incluir SEs" type="submit" id="login-button-modal"></input>
                                </div>
                            </section>
                    </dialog>
                    <section class="modal-body">
                        <div class="container__cadastro__envio">
                            <button class="open-modal" value="Enviar dados" type="button" id="login-button-inicial" data-modal="modal-1">
                            Enviar dados
                            </button>
                        </div>
                    </section>
                <!--       
                    <section class="modal-body">
                        <div class="container__cadastro__envio">
                            <input value="Enviar dados" type="submit" id="login-button"></input>
                        </div>
                    </section>
                -->
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
    <script src="../script/dataAtual.js" defer></script>
	<script src="../script/registrarSE.js" defer></script>
    <script src="../header.js" defer></script>
	<script src="../script/excluirPerfil.js" defer></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"></script>
</html>