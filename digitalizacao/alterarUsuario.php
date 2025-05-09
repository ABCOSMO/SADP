<?php
session_start();
require '../autoload.php';

use FADPD\ConectarUsuario\{
    ConectarBD, SessaoUsuario
};
use FADPD\Lista\SelecionarUnidade;

$autenticandoUsuario = new SessaoUsuario();
$autenticandoUsuario->autenticarUsuario();
$autenticandoUsuario->tempoLoginUsuario();
$escolherUnidade = new SelecionarUnidade();
$separarNome = explode (" ",$_SESSION['nome']);
$nome = $separarNome[0]." ".$separarNome[1];
$unidade = $_SESSION['unidade'];
$usuario = $_GET['usuario'];
$matricula = $_GET['matricula'];
$email = $_GET['email'];
$telefone = $_GET['telefone'];
$celular = $_GET['celular'];
$idUnidade = $_GET['unidade'];
$idPerfil = $_GET['perfil'];
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
    <script src="scriptAlterarCadastro.js" defer></script>
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
                    <a class="lista-logoff__link" href="/fadpd/login/index.php?logout=logout">Fazer Logoff</a>
                </li>
            </ul>
        </nav>
        <nav class="cabecalho__links">
            <input type="checkbox" id="menu-digitalizacao" class="cabecalho__digitalizacao">
            <label for="menu-digitalizacao">
                <span class="cabecalho__menu__texto" id="digitalizacao">FADPD Digitalização</span>
            </label>
            <ul class="lista-digitalizacao" id="lista">
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="../digitalizacao/alterarExcluirUsuario.php">Cadastrar Usuário</a>
                </li>
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="../digitalizacao/lancarCarga.php">Lançar Dados Digitalização</a>
                </li>
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="#">Relatório Digitalização</a>
                </li>
            </ul>
            <a class="cabecalho__menu__texto" href="#">FADPD Produção</a>
            <a class="cabecalho__menu__texto" href="http://msc01065329:9888/ecarta/form/getMovimento_frm.ect" target="_blank">Consulta e-Carta</a>
            <a class="cabecalho__menu__texto" href="https://sgd.correios.com.br/sgd/app/" target="_blank">SGD</a>
            <a class="cabecalho__menu__texto" href="https://cas.correios.com.br/login?service=https%3A%2F%2Fapp.correiosnet.int%2Fecarta%2Fpages%2F" target="_blank">e-Carta</a>
            <a class="cabecalho__menu__texto" href="/fadpd/">Home</a>
        </nav>
    </header>
    <div class="container__caminho">
        <div class="linha">
            <a class="caminhos" href="../">Home</a>  
            <p class="seta"> > </p>
            <a class="caminhos" href="../digitalizacao/">FADPF Digitalização</a>
            <p class="seta">  > </p>
            <a class="caminhos" href="../digitalizacao/alterarExcluirUsuario.php">Cadastrar Usuário</a>
            <p class="seta">  > </p>
            <a class="caminhos" href="#">Alterar Usuário</a>
        </div>
    </div>
    <section class="container__botao">        
            <div class="menuAlterarCadastro" id="modal-1">
                <form method="post" id="myForm" name="autenticar" >
                    <div class="modal-header">
                        <h1 class="modal-title">
                            Alterar dados do Usuário
                        </h1>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <label for="nome">
                                Alterar Nome
                            </label>
                            <input type="text" id="inputNome" name="novoNome" value="<?php echo $usuario ?>" maxlength="60">
                        </div>
                        <div class="input-group">
                            <label for="matricula">
                                Alterar Matrícula
                            </label>
                            <input type="text" id="inputMatricula" name="novaMatricula" value="<?php echo $matricula ?>" maxlength="11">
                        </div>
                        <div class="input-group">
                            <label for="email">
                                Alterar e-mail
                            </label>
                            <input type="email" id="inputEmail" name="novoEmail" value="<?php echo $email ?>" maxlength="60">
                        </div>
                        <div class="input-group">
                            <label for="telefone">
                                Alterar Telefone
                            </label>
                            <input type="text" id="inputTelefone" name="novoTelefone" value="<?php echo $telefone ?>" maxlength="11">
                        </div>
                        <div class="input-group">
                            <label for="celular">
                                Alterar Celular
                            </label>
                            <input type="text" id="inputCelular" name="novoCelular" value="<?php echo $celular ?>" maxlength="11">
                        </div>
                        <div class="input-group">
                        <label for="unidade">
                                Alterar Unidade
                            </label>
                            <select class="selecionar" type="checkbox" name="novaUnidade" size="1" id="unidade">
                                <option value="" selected disabled="disabled" id="selecionar__unidade"> - Unidade - </option>
                                <?php $escolherUnidade->obterUnidade(); ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="perfil">
                                Alterar Perfil
                            </label>
                            <select class="selecionar" type="checkbox" name="novoPerfil" size="1" id="perfil">
                                <option value="" selected disabled="disabled" id="selecionar__unidade"> - Perfil - </option>
                                <?php $escolherUnidade->obterPerfil(); ?>
                            </select>
                        </div>
                        <input value="Alterar" type="submit" id="login-button">
                        </input>
                    </div>
                </form>
            </div>
            <dialog class="loading"></dialog>
        
    </section>
    <footer>
        <div>
            <h3 class="rodape"></h3>
        </div>
    </footer>
</body>
</html>
