<?php

namespace SADP\ConectarUsuario;

use SADP\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class EfetuarLoginUsuario extends ConectarBD
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
            $sql = "SELECT * FROM usuario WHERE matricula = :matricula AND senha = :senha";
            $dados = array(":matricula" => $matricula, ":senha" => $senha);
            $query = parent::executarSQL($sql, $dados);
            $resultado = $query->fetch(PDO::FETCH_OBJ);

            if($resultado){
                $_SESSION['logado'] = true;
                $_SESSION['id_usuario'] = $resultado->id;// Assumindo que 'id' é o identificador único do usuário
                $_SESSION['matricula'] = $resultado->matricula;
                $_SESSION['nome'] = $resultado->usuario;
                $_SESSION['privilegio'] = $resultado->privilegioUsuario;
                $_SESSION['unidade'] = $resultado->unidadeUsuario;
                date_default_timezone_set('America/Sao_Paulo');
                $data = new \DateTime('now');
                $gravarData = $data->format('Y-m-d H:i:s');

                $sql = "INSERT INTO logacesso (usuarioLogAcesso, matriculaLogAcesso, dataHoraAcesso) VALUES (:usuario, :matricula, :dataHora)";
                $dados = array(":usuario" => $_SESSION['nome'], ":matricula" => $_SESSION['matricula'], ":dataHora" => $gravarData);
                $query = parent::executarSQL($sql, $dados);
			    $resultado = parent::lastidSQL();
                header('Location: ../');
                exit;
            }else {
                // Usuário não logado, redireciona para a página de login
                header('Location: ../login/errorLogin.php');
                exit;
            }
        }
    }
}

?>
