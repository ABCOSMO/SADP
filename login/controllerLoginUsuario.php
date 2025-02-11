<?php
    session_start();

    require '../autoload.php';
    /*include_once('../src/ConectarUsuario/ConectarBD.php');
    include('../src/ConectarUsuario/EfetuarLoginUsuario.php');*/

    use SADP\ConectarUsuario\{
        ConectarBD, EfetuarLoginUsuario
    };
        
    if(isset($_POST['matricula']))
    {        
        $logar = new EfetuarLoginUsuario();
        $logar->logarUsuario();   
    }
?>