<?php
date_default_timezone_set('America/Sao_Paulo');
$data = new DateTime('now');
echo $data->format('Y-m-d H:i:s');
$matricula = $_GET['matricula'];

require_once __DIR__ . '/classes/classConectarBD.php';

class alterarUsuario extends conectarBD
{
    function __construct()
    {
        parent::__construct();
    }

    public function alterarDadosUsuario($matricula)
    {
        if($_SERVER['REQUEST_METHOD']==='GET')
        {
            // Prepare e execute a consulta SQL usando consulta parametrizada
            $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE matricula = ?");
            $stmt->bind_param("s", $matricula);
            if (!$stmt->execute()) {
                // Tratar erro de execução da consulta
                die('Erro ao executar a consulta: ' . $stmt->error);
            }
            $result = $stmt->get_result();

            if ($result->num_rows > 0) 
            {
                // Autenticação bem-sucedida
                while($row = $result->fetch_assoc())
                {
                    echo $usuario = $row['usuario'];// Assumindo que 'id' é o identificador único do usuário
                    echo $matricula = $row['matricula'];
                    echo $email = $row['email'];
                    echo $telefone = $row['telefone'];
                    echo $perfil = $row['privilegioUsuario'];
                    echo $unidade = $row['unidadeUsuario'];
                    //header('Location: ../digitalizacao/alterarUsuario.php?usuario=$usuario, matricula=$matricula, email=$email, telefone=$telfone, perfil=$perfil, unidade=$unidade');
                }
            }
        }
    }
}

$alterarUsuario = new AlterarUsuario();
$alterarUsuario->alterarDadosUsuario($matricula);