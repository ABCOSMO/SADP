<?php
session_start();
require '../autoload.php';

use SADP\ConectarUsuario\{
    ConectarBD, SessaoUsuario
};
use SADP\Lista\SelecionarUnidade;

$autenticandoUsuario = new SessaoUsuario();
$autenticandoUsuario->autenticarUsuario();
$autenticandoUsuario->tempoLoginUsuario();
$escolherUnidade = new SelecionarUnidade();
$separarNome = explode (" ",$_SESSION['nome']);
$nome = $separarNome[0]." ".$separarNome[1];
$unidade = $_SESSION['unidade'];
$matricula = $_SESSION['matricula'];
date_default_timezone_set('America/Sao_Paulo');
$data = new DateTime('now');
$LancarData = $data->format('d/m/Y');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styleLancamentoCarga.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="scriptLancarCarga.js" defer></script>
    <script src="../header.js" defer></script>
    <title>SADP - DELOG</title>
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
                    <a class="lista-logoff__link" href="/sadp/login/index.php?logout=logout">Fazer Logoff</a>
                </li>
            </ul>
        </nav>
        <nav class="cabecalho__links">
            <input type="checkbox" id="menu-digitalizacao" class="cabecalho__digitalizacao">
            <label for="menu-digitalizacao">
                <span class="cabecalho__menu__texto" id="digitalizacao">SADP Digitalização</span>
            </label>
            <ul class="lista-digitalizacao" id="lista">
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="../digitalizacao/cadastrarUsuario.php">Cadastrar Usuário</a>
                </li>
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="../digitalizacao/alterarExcluirUsuario.php">Alterar/Excluir Usuário</a>
                </li>
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="../digitalizacao/lancarCarga.php">Lançar Dados Digitalização</a>
                </li>
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="#">Excluir Dados Digitalização</a>
                </li>
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="#">Relatório de Acesso</a>
                </li>
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="#">Relatório Digitalização</a>
                </li>
            </ul>
            <a class="cabecalho__menu__texto" href="#">SADP Produção</a>
            <a class="cabecalho__menu__texto" href="http://msc01065329:9888/ecarta/form/getMovimento_frm.ect" target="_blank">Consulta e-Carta</a>
            <a class="cabecalho__menu__texto" href="https://sgd.correios.com.br/sgd/app/" target="_blank">SGD</a>
            <a class="cabecalho__menu__texto" href="https://cas.correios.com.br/login?service=https%3A%2F%2Fapp.correiosnet.int%2Fecarta%2Fpages%2F" target="_blank">e-Carta</a>
            <a class="cabecalho__menu__texto" href="/sadp/">Home</a>
        </nav>
    </header>
    <div class="container__caminho">
        <div class="linha">
            <a class="caminhos" href="../">Home</a>  
            <p class="seta"> > </p>
            <a class="caminhos" href="../digitalizacao/">SADP Digitalização</a>
            <p class="seta">  > </p>
            <a class="caminhos" href="../digitalizacao/lancarCarga.php">Lançar Dados Digitalização</a>
        </div>
    </div>
    <section class="container__botao">        
            <div class="menuCadastro" id="modal-1">
                <form method="post" id="myForm" name="autenticar" >
                    <div class="modal-header">
                        <h1 class="modal-title">
                            Lançar Carga do Dia
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
                            <input type="text" id="inputAnterior" name="cargaAnterior" placeholder="" maxlength="7">
                        </div>
                        <div class="input-group">
                            <label for="cargaRecebida">
                                Carga recebida
                            </label>
                            <input type="text" id="inputRecebida" name="cargaRecebida" placeholder="" maxlength="7">
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
                    <div class="container__cadastro__envio">
                        <input value="Enviar dados" type="submit" id="login-button"></input>
                    </div>
                </form>
            </div>
            <dialog class="loading"></dialog>
        
    </section>
    <footer>
        <div>
            <h3 class="rodape">Desenvolvido pelos CDIPs</h3>
        </div>
    </footer>
</body>
</html>
