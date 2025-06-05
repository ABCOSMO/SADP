<?php

namespace FADPD\ConectarUsuario;

// Se BASE_URL não foi definida em um arquivo de configuração, você pode defini-la aqui (menos ideal para reutilização)
define('BASE_URL', 'http://localhost/fadpd/'); 

class SessaoUsuario
{
    public function autenticarUsuario()
    {
        if (!isset($_SESSION['logado']) || empty($_SESSION['logado']))
        {
            header('Location: ' . BASE_URL . 'login/');
            exit();
        }
    }

    public function tempoLoginUsuario()
    {
        // Verifica o tempo limite da sessão
        $timeout_duration = 900; 
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration))
        {
            session_unset();
            session_destroy();
            header("Location: " . BASE_URL . "login/");
            exit;
        } else
        {
            $_SESSION['last_activity'] = time();
        }
    }

    public function fazerLogof()
    {
        if(isset($_GET['logout'])) {
            session_unset();
            session_destroy();
            header("Location: " . BASE_URL . "login/");
            exit;
        }
    }
}
?>