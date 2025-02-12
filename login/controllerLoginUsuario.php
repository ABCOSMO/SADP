<?php
    session_start();

    require '../autoload.php';

    use SADP\ConectarUsuario\{
        ConectarBD, EfetuarLoginUsuario
    };
        
    if(isset($_POST['matricula']))
    {        
        $logar = new EfetuarLoginUsuario();
        $logar->logarUsuario();   
    }
?>