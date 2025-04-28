<?php
    session_start();

    require '../autoload.php';

    use FADPD\ConectarUsuario\{
        ConectarBD, EfetuarLoginUsuario
    };
        
    if(isset($_POST['matricula']))
    {        
        $logar = new EfetuarLoginUsuario();
        $logar->logarUsuario();   
    }
?>