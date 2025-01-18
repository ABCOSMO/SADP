<?php

class conectarBD
{
    private $nomeUsuario;
    private $matricula;
    private $senha;
    public $conn;

   function __construct()
   {
       $this->connectaBD();       
   }

    private function connectaBD() 
    {
        $server = "localhost";
        $user = "root";
        $pass = "";
        $mydb = "test";
        $this->conn = new mysqli($server, $user, $pass, $mydb);
        mysqli_set_charset($this->conn, "utf8");
        if($this->conn->connect_error){
            die("Conexão Falhou:".$this->conn->connect_error);
        }else{$conexao = "conexão realizada.";}
    }
}

?>