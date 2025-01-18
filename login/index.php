<?php
 session_start();
 include_once('../classSessaoUsuario.php');
 $autenticandoUsuario = new sessaoUsuario();
 $autenticandoUsuario->fazerLogof();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/sadp/css/styleLogin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>SADP - DELOG</title>
</head>
<body>
    <header class="container__links">
        <nav class="links">
        <a href="#">Fazer Login</a>
        </nav>
    </header>
    <section class="container__botao">
        <!--<div>-->          
            <div class="menuLogin" id="modal-1">
                <form method="post" action="controllerLoginUsuario.php">
                    <div class="modal-header">
                        <h1 class="modal-title">
                            Informe seus dados<!--Sign in to our plataform-->
                        </h1>
                        <button class="close-modal" data-modal="modal-1" type="button">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <label for="email">
                                Matrícula
                            </label>
                            <input type="text" id="inputMatricula" name="matricula" placeholder="Digite sua matrícula" maxlength="11">
                        </div>
                        <div class="input-group">
                            <label for="password">
                                Senha
                            </label>
                            <input type="password" id="password" name="password" placeholder="••••••••" maxlength="9">
                        </div>
                        <div class="passaword-options">
                            <div class="remember-passaword">
                                <a href="#" class="remember-passaword">Não sou cadastrado</a>
                            </div>
                            <a href="#" class="remember-passaword">Esqueceu a senha?</a>
                        </div>
                        <button type="submit" id="login-button">
                            Entrar<!--Login to your account-->
                        </button>
                        <!--<div class="register">
                            <span>*Usuário ou senha incorreta</span>
                            <a href="#">Login here</a>
                        </div>-->
                    </div>
                </form>
            </div>
       <!--</div>-->
       <p></p>
    </section>
    <footer>
        <div>
            <h3 class="rodape"></h3>
        </div>
    </footer>
    <script src="/fapi/script.js" defer></script>
</body>
</html>
