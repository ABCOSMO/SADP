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
    <script src="scriptCadastro.js" defer></script>
    <title>SADP - DELOG</title>
</head>
<body>
    <header class="container__links">
        <nav class="links">
            <p><?php echo $nome." - ".$unidade;?></p>
        </nav>
        <nav class="links">
            <a href="../login/index.php?logout=logout">Fazer Logoff</a>
            <a href="../digitalizacao/">SADP Digitalização</a>
            <a href="../producao/">SADP Produção</a>
            <a href="http://msc01065329:9888/ecarta/form/getMovimento_frm.ect" target="_blank">Consulta e-Carta</a>
			<a href="https://sgd.correios.com.br/sgd/app/" target="_blank">SGD</a>
			<a href="https://cas.correios.com.br/login?service=https%3A%2F%2Fapp.correiosnet.int%2Fecarta%2Fpages%2F" target="_blank">e-Carta</a>
            <a href="../sadp/">Home</a>
        </nav>
    </header>
    <div class="container__caminho">
        <div class="caminhos linha">
            <a href="../">Home</a>  
            <p class="seta"> > </p>
            <a href="../digitalizacao/">SADP Digitalização</a>
            <p class="seta">  > </p>
            <a href="../digitalizacao/cadastrarUsuario.php">Lançar Dados Digitalização</a>
        </div>
    </div>
    <section class="container__botao">
        <div class="container__margem">
            <a href="../digitalizacao/cadastrarUsuario.php">Cadastrar Usuário</a> 
            <a href="../digitalizacao/alterarExcluirUsuario.php">Alterar/Excluir Usuário</a>
            <a href="../digitalizacao/lancarCarga.php">Lançar Dados Digitalização</a>
            <a href="#">Excluir Dados Digitalização</a>
            <a href="#">Relatório de Acesso</a>
            <a href="#">Relatório Digitalização</a>
        </div>
        <section class="container__cadastro">
            <div class="menuCadastro" id="modal-1">
                <form method="post" id="myForm" name="autenticar" >
                    <div class="modal-header">
                        <h1 class="modal-title">
                            Lançar Carga do Dia
                        </h1>
                    </div>
                    <section class="modal-body">
                        <div class="input-group">
                            <label for="nome">
                                Data
                            </label>
                            <input type="text" id="inputNome" name="data" value=<?php echo $LancarData; ?> maxlength="60">
                        </div>
                        <div class="input-group">
                            <label for="matricula">
                                Carga dia anterior
                            </label>
                            <input type="text" id="inputMatricula" name="cargaAnterior" placeholder="" maxlength="11">
                        </div>
                        <div class="input-group">
                            <label for="email">
                                Carga recebida
                            </label>
                            <input type="email" id="inputEmail" name="cargaRecebida" placeholder="" maxlength="60">
                        </div>
                        <div class="input-group">
                            <label for="telefone">
                                Carga digitalizada
                            </label>
                            <input type="text" id="inputTelefone" name="cargaDigitalizada" placeholder="" maxlength="11">
                        </div>
                        <div class="input-group">
                        <label for="unidade">
                                Resto do dia
                            </label>
                            <input type="text" id="inputTelefone" name="resto" placeholder="" maxlength="11">
                        </div>
                    </section>
                    <div class="container__cadastro__envio">
                        <input value="Enviar dados" type="submit" id="login-button"></input>
                    </div>
                </form>
            </div>
            <dialog class="loading"></dialog>
        </section>
    </section>
    <footer>
        <div>
        </div>
    </footer>
</body>
</html>
