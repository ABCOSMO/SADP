<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <title>SAuxP-CDIP</title>
</head>
<body>
    <header class="container__links">
        <nav class="links">   
            <button class="open-modal" data-modal="modal-1">
                Fazer Login
            </button>     
        </nav>
    </header> 
    <section class="container__botao">
        <div>           
            <dialog id="modal-1">
                <form method="post" action="controller.php">
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
                        <!--<div class="passaword-options">
                            <div class="remember-passaword">
                                <input type="checkbox" name="remember-passaword" id="remember-passaword">
                                <label for="remember-passaword">
                                    Remember me
                                </label>
                            </div>
                            <a href="#" class="forgot-passaword">Forgot password?</a>
                        </div>-->
                        <button type="submit" id="login-button">
                            Entrar<!--Login to your account-->
                        </button>
                        <!--<div class="register">
                            <span>Not registered?</span>
                            <a href="#">Login here</a>
                        </div>-->
                    </div>
                </form>
            </dialog>
        </div>
    </section>
    <footer>
        <h3 class="rodape"></h3>
    </footer>
    <script src="script.js" defer></script>
</body>
</html>