<?php
session_start();

require 'autoload.php';

use FADPD\ConectarUsuario\SessaoUsuario;

$autenticandoUsuario = new sessaoUsuario();
$autenticandoUsuario->autenticarUsuario();
$autenticandoUsuario->tempoLoginUsuario();
$separarNome = explode (" ",$_SESSION['nome']);
if($separarNome[0] != "Visitante"){
	$nome = $separarNome[0]." ".$separarNome[1];
}else{
	$nome = $separarNome[0];
}
$unidade = $_SESSION['unidade'];
$perfil = $_SESSION['privilegio'];
$codificarPefil = hash('sha256', $perfil)
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>FADPD - DELOG</title>
</head>
<body>
    <header class="cabecalho">
        <nav class="cabecalho__links">
			<input type="hidden" id="perfilOculto" value=<?php echo $codificarPefil; ?>>
            <input type="checkbox" id="logoff" class="cabecalho__logoff">
            <label for="logoff">
                <span class="cabecalho__texto" id="menuLogoff"><?php echo $nome." - ".$unidade;?></span>
            </label>
            <ul class="lista-logoff">
                <li class="lista-logoff__item">
                    <a class="lista-logoff__link" href="./login/index.php?logout=logout">Fazer Logoff</a>
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
                    <a class="lista-digitalizacao__link" href="./digitalizacao/alterarExcluirUsuario.php">Cadastrar Usuário</a>
                </li>
                <li id="lancarDados" class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="./digitalizacao/lancarCarga.php">Lançar Dados Digitalização</a>
                </li>
                <li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="./digitalizacao/relatorioDigitalizacao.php">Relatório Digitalização</a>
                </li>
				<li class="lista-digitalizacao__item">
                    <a class="lista-digitalizacao__link" href="#">Relatório Recebido SEs</a>
                </li>
            </ul>
            <a class="cabecalho__menu__texto" href="#">Produção</a>
            <a class="cabecalho__menu__texto" href="http://msc01065329:9888/ecarta/form/getMovimento_frm.ect" target="_blank">Consulta e-Carta</a>
            <a class="cabecalho__menu__texto" href="https://sgd.correios.com.br/sgd/app/" target="_blank">SGD</a>
            <a class="cabecalho__menu__texto" href="https://cas.correios.com.br/login?service=https%3A%2F%2Fapp.correiosnet.int%2Fecarta%2Fpages%2F" target="_blank">e-Carta</a>
            <a class="cabecalho__menu__texto" href="./">Home</a>
        </nav>
    </header>
    <main class="container__corpo"></main>
    <footer class="rodape">
        <p></p>
        <div>
            <h3 class="rodape__texto">Desenvolvido pelos CDIPs</h3>
        </div>
    </footer>
    <script src="header.js" defer></script>
	<script src="script/excluirPerfil.js" defer></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.2.0/crypto-js.min.js"></script>
</body>
</html>
