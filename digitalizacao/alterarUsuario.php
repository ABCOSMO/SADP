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
$usuario = $_GET['usuario'];
$matricula = $_GET['matricula'];
$email = $_GET['email'];
$telefone = $_GET['telefone'];
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
            <a href="../">Home</a>
        </nav>
    </header>
    <div class="container__caminho">
        <div class="caminhos linha">
            <a href="../">Home</a>  
            <p class="seta"> > </p>
            <a href="../digitalizacao/">SADP Digitalização</a>
            <p class="seta">  > </p>
            <a href="../digitalizacao/alterarExcluirUsuario.php">Alterar/Excluir Usuário</a>
            <p class="seta">  > </p>
            <a href="#">Alterar Usuário</a>
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
                        <label for="unidade">
                                Alterar Unidade
                            </label>
                            <select class="selecionar" type="checkbox" name="novaUnidade" size="1" id="unidade">
                                <option value="" selected disabled="disabled" id="selecionar__unidade"> - Unidade - </option>
                                <?php $escolherUnidade->seletorUnidade(); ?>
                            </select>
                        </div>
                        <div class="input-group">
                            <label for="perfil">
                                Alterar Perfil
                            </label>
                            <select class="selecionar" type="checkbox" name="novoPerfil" size="1" id="perfil">
                                <option value="" selected disabled="disabled" id="selecionar__unidade"> - Perfil - </option>
                                <?php $escolherUnidade->seletorPerfil(); ?>
                            </select>
                        </div>
                        <input value="Alterar" type="submit" id="login-button">
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
