<?php

include_once('../classes/classConectarBD.php');

class efetuarLoginUsuario extends conectarBD
{
    function __construct()
    {
        parent::__construct();
    }

    public function logarUsuario()
    {
        if($_SERVER['REQUEST_METHOD']==='POST')
        {
            $tratarMatricula = $_POST['matricula'];
            $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);
            $senha = $_POST['password'];
            // Prepare e execute a consulta SQL usando consulta parametrizada
            $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE matricula = ? AND senha = ?");
            $stmt->bind_param("ss", $matricula, $senha);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) 
            {
                // Autenticação bem-sucedida
                while($row = $result->fetch_assoc())
                {
                    $_SESSION['logado'] = true;
                    $_SESSION['id_usuario'] = $row['id'];// Assumindo que 'id' é o identificador único do usuário
                    $_SESSION['matricula'] = $row['matricula'];
                    $_SESSION['nome'] = $row['usuario'];
                    $_SESSION['privilegio'] = $row['privilegioUsuario'];
                    $_SESSION['unidade'] = $row['unidadeUsuario'];
                    if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
                        // Usuário logado, redireciona para a área restrita
                        header('Location: /sadp/');
                        exit;
                    }
                }
            } 
            else 
            {
                // Usuário não logado, redireciona para a página de login
                header('Location: ../login/errorLogin.php');
                exit;
            }
            $stmt->close();
        }
    }
}

?>
