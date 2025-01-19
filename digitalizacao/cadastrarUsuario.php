<?php
session_start();
include_once('../classes/classSessaoUsuario.php');
include_once('../classes/classSeletorUnidade.php');
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
    <link rel="stylesheet" href="../css/styleCadastro.css">
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
            <a href="#">Consulta e-Carta</a>
            <a href="#">SGD</a>
            <a href="#">e-Carta</a>
            <a href="/sadp/">Home</a>
        </nav>
    </header>
    <div class="container__caminho">
        <div class="caminhos linha">
            <a href="../">Home</a>  
            <p class="seta"> > </p>
            <a href="../digitalizacao/">SADP Digitalização</a>
            <p class="seta">  > </p>
            <a href="../digitalizacao/cadastrarUsuario.php">Cadastrar Usuário</a>
        </div>
    </div>
    <section class="container__botao">
        <div class="container__margem">
            <a href="../digitalizacao/cadastrarUsuario.php">Cadastrar Usuário</a> 
            <a href="../digitalizacao/alterarExcluirUsuario.php">Alterar/Excluir Usuário</a>
            <a href="#">Lançar Dados Digitalização</a>
            <a href="#">Excluir Dados Digitalização</a>
            <a href="#">Relatório de Acesso</a>
            <a href="#">Relatório Digitalização</a>
        </div>
        <div class="container__cadastro">
            <div class="menuCadastro" id="modal-1">
                <form method="post" id="myForm" name="autenticar" onSubmit="return validaFormulario()">
                    <div class="modal-header">
                        <h1 class="modal-title">
                            Cadastrar novo usuário
                        </h1>
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
                        <input value="Cadastrar" type="submit" id="login-button">
                        </input>
                    </div>
                </form>
            </div>
            <dialog class="loading"></dialog>
        </div>
    </section>
    <footer>
        <div>
        </div>
    </footer>
</body>
</html>
