<?php

namespace FADPD\ConectarUsuario;

class SessaoUsuario
{
    public function autenticarUsuario()
    {
        if (!isset($_SESSION['logado']) || empty($_SESSION['logado'])) 
        {
            // Usuário não está logado, redirecionar para a página de login
            header('Location: /fadpd/login/');
            exit();
        }    
    }   

    public function tempoLoginUsuario()
    {
        // Verifica o tempo limite da sessão
        $timeout_duration = 1800; // 30 minutos
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration)) 
        {
            session_unset();
            session_destroy();
            header("Location: /fadpd/login/"); 
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
            header("Location: ../login/");
            exit;
        }
    }
}
?>