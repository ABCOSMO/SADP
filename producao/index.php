<?php
session_start();
include_once('../classSessaoUsuario.php');
include_once('classSeletorUnidade.php');
$autenticandoUsuario = new sessaoUsuario();
$autenticandoUsuario->autenticarUsuario();
$autenticandoUsuario->tempoLoginUsuario();
$escolherUnidade = new selecionarUnidade();
$separarNome = explode (" ",$_SESSION['nome']);
$nome = $separarNome[0]." ".$separarNome[1];
$unidade = $_SESSION['unidade'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/fapi/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <title>FAPI - DELOG</title>
    <script src="../script.js" defer></script>
</head>
<body>
    <header class="container__links">
        <nav class="links">
            <p><?php echo $nome." - ".$unidade;?></p>
        </nav>
        <nav class="links">
            <a href="/fapi/login/login.php?logout=logout">Fazer Logoff</a>
            <a href="/fapi/digitalizacao/">FAPI Digitalização</a>
            <a href="/fapi/producao/">FAPI Produção</a>
            <a href="#">SGD</a>
            <a href="#">e-Carta</a>
            <a href="/fapi/">Home</a>
        </nav>
    </header>
    <div class="container__caminho">
        <div class="caminhos">
            <a href="/fapi/">Home</a>  >
            <a href="/fapi/producao/">FAPI Produção</a>
        </div>
    </div>
    <section class="container__botao">
        <div class="container__margem">
            <button class="open-modal" data-modal="modal-1">Cadastrar Usuário</button> 
            <a href="#">Alterar/Excluir Usuário</a>
            <a href="#">Lançar Dados Produção</a>
            <a href="#">Excluir Dados Produção</a>
            <a href="#">Relatório Produção</a>
        </div>
        <div>
        <dialog id="modal-1"><!--action="/fapi/cadastro/controllerCadastro.php" -->
                <form method="post" id="myForm" name="autenticar" onSubmit="return validaFormulario()">
                    <div class="modal-header">
                        <h1 class="modal-title">
                            Cadastrar novo usuário<!--Sign in to our plataform-->
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
                        <label for="unidade">
                                Cadastrar Unidade
                            </label>
                            <select class="selecionar" type="checkbox" name="novaUnidade" size="1" id="unidade">
                                <option value="" selected disabled="disabled" id="selecionar__unidade"> - Unidade - </option>
                                <?php $escolherUnidade->seletorUnidade(); ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="perfil">
                                Cadastrar Perfil
                            </label>
                            <select class="selecionar" type="checkbox" name="novoPerfil" size="1" id="perfil">
                                <option value="" selected disabled="disabled" id="selecionar__unidade"> - Perfil - </option>
                                <?php $escolherUnidade->seletorPerfil(); ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="password">
                                Criar Senha
                            </label>
                            <input type="text" id="password" name="newPassword" placeholder="••••••••" maxlength="9">
                        </div>
                        <!--<div class="passaword-options">
                            <div class="remember-passaword">
                                <input type="checkbox" name="remember-passaword" id="remember-passaword">
                                <label for="remember-passaword">
                                    Remember me
                                </label>
                            </div>
                            <a href="#" class="forgot-passaword">Forgot password?</a>
                        </div>-->
                        <input value="Cadastrar" type="submit" id="login-button">
                            <!--Login to your account-->
                        </input>
                        <!--<div class="register">
                            <span>Not registered?</span>
                            <a href="#">Login here</a>
                        </div>-->
                    </div>
                </form>
            </dialog>
            <p></p>
                <!--<div class="menuCadastro">
                    <div class="modal-header">
                        <p class="modal-title"></p>
                    </div>
                </div>-->
             <div class="loading"></div>
    </section>
    <footer>
        <div>
            <h3 class="rodape"></h3>
        </div>
    </footer>
</body>
</html>
