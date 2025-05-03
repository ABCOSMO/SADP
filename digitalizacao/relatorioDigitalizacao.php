<?php
session_start();
require '../autoload.php';

use FADPD\ConectarUsuario\{
    ConectarBD, SessaoUsuario
};
use FADPD\Lista\{
    SelecionarData, SelecionarUnidade
};

$autenticandoUsuario = new SessaoUsuario();
$autenticandoUsuario->autenticarUsuario();
$autenticandoUsuario->tempoLoginUsuario();
$escolherUnidade = new SelecionarUnidade();
$escolherData = new SelecionarData();
$separarNome = explode (" ",$_SESSION['nome']);
$nome = $separarNome[0]." ".$separarNome[1];
$unidade = $_SESSION['unidade'];
date_default_timezone_set('America/Sao_Paulo');
$data = new DateTime('now');
$LancarData = $data->format('d/m/Y');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleCadastro.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="scriptExcluirCadastro.js" defer></script>
    <script src="../header.js" defer></script>
    <title>FADPD - DELOG</title>
</head>
<body>
<header class="cabecalho">
    <nav class="cabecalho__links">
            <input type="checkbox" id="logoff" class="cabecalho__logoff">
            <label for="logoff">
                <span class="cabecalho__texto" id="menuLogoff"><?php echo $nome." - ".$unidade;?></span>
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
            <a class="caminhos" href="../digitalizacao/relatorioDigitalizacao.php">Digitalização</a>
            <p class="seta">  > </p>
            <a class="caminhos" href="../digitalizacao/relatorioDigitalizacao.php">Relatório Digitalização</a>
        </div>
    </div>
    <section class="container__botao">
        <div class="container__cadastro_usuario">
            <div class="menuAlterarUsuario" id="modal-1">
               <div class="modal-header">
                    <h1 class="modal-title">
                        Relatório Digitalização
                    </h1>
                </div>
                <div class="botao__apertar">
                    <button id="botaoCarga-1" onclick="abrirOpcaoMensal(1)" class="botao__carga botao__selecionado">Carga Diária</button>
                    <button id="botaoCarga-2" onclick="abrirOpcaoMensal(2)" class="botao__carga botao__selecionado" name="mensal">Carga Mensal</button>
                </div>                
                <div class="container__calendario" id="diaria" name="diaria"></div>
                 
            </div>            
            <dialog class="loading"></dialog>
        </div>  
    </section>
    <footer>
        <div>
            <h3 class="rodape">Desenvolvido pelos CDIPs</h3>
        </div>
    </footer>
    <script src="../script/dataAtual.js" defer></script>
    <script src="../script/relatorioDiarioDigitalizacao.js" defer></script>
    <script src="../script/opcaoCargaMensalAnual.js" defer></script>
</body>
</html>
