<?php
session_start();
include_once('../classSessaoUsuario.php');
$autenticandoUsuario = new sessaoUsuario();
$autenticandoUsuario->autenticarUsuario();
$autenticandoUsuario->tempoLoginUsuario();
$separarNome = explode (" ",$_SESSION['nome']);
$nome = $separarNome[0]." ".$separarNome[1];
$unidade = $_SESSION['unidade'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/sadp/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>SADP - DELOG</title>
</head>
<body>
    <header class="container__links">
        <nav class="links">
            <p><?php echo $nome." - ".$unidade;?></p>
        </nav>
        <nav class="links">
            <a href="/sadp/login/login.php?logout=logout">Fazer Logoff</a>
            <a href="/sadp/digitalizacao/">FAPI Digitalização</a>
            <a href="/sadp/producao/">FAPI Produção</a>
            <a href="#">SGD</a>
            <a href="#">e-Carta</a>
            <a href="/sadp/">Home</a>
        </nav>
    </header>
    <div class="container__caminho">
        <div class="caminhos">
            <a href="/sadp/">Home</a>  >
            <a href="/sadp/digitalizacao/">FAPI Digitalização</a>
        </div>
    </div>
    <section class="container__botao">
        <div class="container__margem">
            <a href="#">Cadastrar Usuário</a>
            <a href="#">Alterar/Excluir Usuário</a>
            <a href="#">Lançar Dados Digitalização</a>
            <a href="#">Excluir Dados Digitalização</a>
            <a href="#">Relatório Digitalização</a>
        </div>
    </section>
    <footer>
        <div>
            <h3 class="rodape"></h3>
        </div>
    </footer>
    <script src="script.js" defer></script>
</body>
</html>
