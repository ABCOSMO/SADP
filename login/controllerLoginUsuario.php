<?php
    session_start();
    include('classEfetuarLoginUsuario.php');
        
    if(isset($_POST['matricula']))
    {        
        $logar = new efetuarLoginUsuario();
        $logar->logarUsuario();   
    }
?>