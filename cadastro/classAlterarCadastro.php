<?php

include_once('../classes/classConectarBD.php');

class alterarUsuario extends conectarBD
{
    function __construct()
    {
        parent::__construct();
    }

    public function formatarMatricula($matricula) 
    {
        // Remove todos os caracteres não numéricos
        $matricula = preg_replace('/[^0-9]/', '', $matricula);
    
        // Divide a matrícula em partes para facilitar a formatação
        $parte1 = substr($matricula, 0, 1);
        $parte2 = substr($matricula, 1, 3);
        $parte3 = substr($matricula, 4, 3);
        $parte4 = substr($matricula, 7, 1);
    
        // Junta as partes com os pontos e hífen
        $matriculaFormatada = $parte1 . '.' . $parte2 . '.' . $parte3 . '-' . $parte4;
    
        return $matriculaFormatada;
    }
    

    public function alterarDadosUsuario($matricula)
    {
        if($_SERVER['REQUEST_METHOD']==='GET')
        {
            $matricula = $_GET['matricula'];
            // Prepare e execute a consulta SQL usando consulta parametrizada
            $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE matricula = ?");
            $stmt->bind_param("s", $matricula);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) 
            {
                // Autenticação bem-sucedida
                while($row = $result->fetch_assoc())
                {
                    $usuario = $row['usuario'];// Assumindo que 'id' é o identificador único do usuário
                    $matricula = $row['matricula'];
                    $email = $row['email'];
                    $telefone = $row['telefone'];
                    $perfil = $row['privilegioUsuario'];
                    $stmt = $this->conn->prepare("SELECT * FROM privilegio WHERE privilegio = ?");
                    $stmt->bind_param("s", $perfil);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $idPerfil = $row['idPrivilegio'];

                    $unidade = $row['unidadeUsuario'];
                    $stmt = $this->conn->prepare("SELECT * FROM unidade WHERE unidade = ?");
                    $stmt->bind_param("s", $unidade);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $idUnidade = $row['idunidade'];

                    header('Location: ../digitalizacao/alterarUsuario.php?usuario=' . $usuario . '&matricula=' . $this->formatarMatricula($matricula) . 
                    '&email=' . $email . '&telefone=' . $telefone . '&perfil=' . $idPerfil . '&unidade=' . $idUnidade);
                }
            }
        }
    }
}