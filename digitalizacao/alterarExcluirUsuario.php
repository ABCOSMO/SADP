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
            <a href="../digitalizacao/alterarExcluirUsuario.php">Alterar/Excluir Usuário</a>
        </div>
    </div>
    <section class="container__botao">
        <div class="container__margem">
            <a href="../digitalizacao/cadastrarUsuario.php">Cadastrar Usuário</a> 
            <a href="../digitalização/alterarExcluirUsuario.php">Alterar/Excluir Usuário</a>
            <a href="#">Lançar Dados Digitalização</a>
            <a href="#">Excluir Dados Digitalização</a>
            <a href="#">Relatório de Acesso</a>
            <a href="#">Relatório Digitalização</a>
        </div>
        <div class="container__cadastro_usuario">
            <div class="menuAlterarUsuario" id="modal-1">
               <div class="modal-header">
                    <h1 class="modal-title">
                        Alterar ou excluir usuário
                    </h1>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                         <label for="nome">
                            Administrador
                        </label>
                        <table class="container__usuario">
                            <tr>
                                <th id="usuario">Usuário</th>
                                <th id="usuario">Matrícula</th>
                                <th id="usuario">e-mail</th>
                                <th id="usuario">Telefone</th>
                                <th id="usuario">Perfil</th>
                                <th id="usuario">Alterar</th>
                                <th id="usuario">Excluir</th>
                            </tr>
                            <tr class="container__usuario">
                                <td id="usuario">Alexandre Bruno Cosmo</td>
                                <td id="usuario">8.134.249-7</td>
                                <td id="usuario">abcosmo04@gmail.com</td>
                                <td id="usuario">(61) 2141-8132</td>
                                <td id="usuario">Administrador</td>
                                <td id="usuario"><button><i class="fa-solid fa-pencil"></i></button></td>
                                <td id="usuario"><button><i class="fa-solid fa-trash"></i></button></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                         <label for="nome">
                            Gestor
                        </label>
                        <table class="container__usuario">
                            <tr>
                                <th id="usuario">Usuário</th>
                                <th id="usuario">Matrícula</th>
                                <th id="usuario">e-mail</th>
                                <th id="usuario">Telefone</th>
                                <th id="usuario">Perfil</th>
                                <th id="usuario">Alterar</th>
                                <th id="usuario">Excluir</th>
                            </tr>
                            <tr class="container__usuario">
                                <td id="usuario">Cristiane de Jesus Feitosa</td>
                                <td id="usuario">8.888.888-8</td>
                                <td id="usuario">crisjfferreira@gmail.com</td>
                                <td id="usuario">(61) 2141-9136</td>
                                <td id="usuario">Gestor</td>
                                <td id="usuario"><button><i class="fa-solid fa-pencil"></i></button></td>
                                <td id="usuario"><button><i class="fa-solid fa-trash"></i></button></td>
                            </tr>
                        </table>
                    </div>
                </div>
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
