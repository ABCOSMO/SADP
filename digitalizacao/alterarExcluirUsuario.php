<?php
session_start();
require '../autoload.php';

use FADPD\ConectarUsuario\{
    ConectarBD, SessaoUsuario
};
use FADPD\Lista\{
    ListarUsuario, SelecionarUnidade
};

$autenticandoUsuario = new SessaoUsuario();
$autenticandoUsuario->autenticarUsuario();
$autenticandoUsuario->tempoLoginUsuario();
$escolherUnidade = new SelecionarUnidade();
$listarUsuarios = new ListarUsuario();
$separarNome = explode (" ",$_SESSION['nome']);
$nome = $separarNome[0]." ".$separarNome[1];
$unidade = $_SESSION['unidade'];
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
            <a class="caminhos" href="../digitalizacao/alterarExcluirUsuario.php">Digitalização</a>
            <p class="seta">  > </p>
            <a class="caminhos" href="../digitalizacao/alterarExcluirUsuario.php">Cadastrar Usuário</a>
        </div>
    </div>
    <section class="container__botao">
        <div class="container__cadastro_usuario">
            <div class="menuAlterarUsuario">
                <div class="menuAlterarUsuario__botao_cadastro">
                    <button class="open-modal" data-modal="modal-1" id="login-button-cadastro">
                        Cadastrar Novo Usuário
                    </button> 
                </div>
               <div class="modal-header">
                    <h1 class="modal-title">
                        Relação de usuáios cadastrados
                    </h1>                    
                </div>
                    <div id="dadosContainer"></div>
            </div>
            <div class="loading"></div>
        </div>
    </section>
    <dialog id="modal-1">
        <div class="menuCadastro" id="modal-1">
            <form method="post" id="myForm" name="autenticar" >
                <div class="modal-header">
                    <h1 class="modal-title">
                        Cadastrar novo usuário
                    </h1>
                    <button class="close-modal" data-modal="modal-1" type="button">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <label for="nome">
                            Cadastrar Nome
                        </label>
                        <input type="text" id="inputNome" name="novoNome" placeholder="Digite o nome" maxlength="60">
                    </div>
                    <div class="input-group">
                        <label for="matricula">
                            Cadastrar Matrícula
                        </label>
                        <input type="text" id="inputMatricula" name="novaMatricula" placeholder="Digite a matrícula" maxlength="11">
                    </div>
                    <div class="input-group">
                        <label for="email">
                            Cadastrar e-mail
                        </label>
                        <input type="email" id="inputEmail" name="novoEmail" placeholder="Digite o e-mail" maxlength="60">
                    </div>
                    <div class="input-group">
                        <label for="telefone">
                            Cadastrar Telefone
                        </label>
                        <input type="text" id="inputTelefone" name="novoTelefone" placeholder="Digite o telefone com DDD" maxlength="11">
                    </div>
                    <div class="input-group">
                        <label for="celular">
                            Cadastrar Celular
                        </label>
                        <input type="text" id="inputCelular" name="novoCelular" placeholder="Digite o celular com DDD" maxlength="11">
                    </div>
                    <div class="input-group">
                    <label for="unidade">
                            Cadastrar Unidade
                        </label>
                        <select class="selecionar" type="checkbox" name="novaUnidade" size="1" id="unidade">
                            <option value="" selected disabled="disabled" id="selecionar__unidade"> - Unidade - </option>
                            <?php $escolherUnidade->obterUnidade(); ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="perfil">
                            Cadastrar Perfil
                        </label>
                        <select class="selecionar" type="checkbox" name="novoPerfil" size="1" id="perfil">
                            <option value="" selected disabled="disabled" id="selecionar__unidade"> - Perfil - </option>
                            <?php $escolherUnidade->obterPerfil(); ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="password">
                            Criar Senha
                        </label>
                        <input type="text" id="password" name="newPassword" placeholder="••••••••" maxlength="9">
                    </div>
                    <input value="Cadastrar" type="submit" id="login-button">
                    </input>
                </div>
            </form>
            </div>
    </dialog>
    <footer>
    </footer>
    <script src="../script/relatorioUsuarios.js" defer></script>
    <script src="../script/scriptExcluirCadastro.js" defer></script>
    <script src="../script/scriptCadastro.js" defer></script>
    <script src="../script/scriptAlterarCadastro.js" defer></script>
    <script src="../header.js" defer></script>
</body>
</html>
