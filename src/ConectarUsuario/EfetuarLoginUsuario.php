<?php

namespace FADPD\ConectarUsuario;

use FADPD\ConectarUsuario\ConectarBD;
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
        if($_SERVER['REQUEST_METHOD']==='POST') {
            $tratarMatricula = $_POST['matricula'];
            $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);
            $senha = $_POST['password'];
            $status = 1;
            // Prepare e execute a consulta SQL usando consulta parametrizada
            $sql = "SELECT tb_funcionarios.*, tb_unidades.nome_unidade FROM tb_funcionarios INNER JOIN tb_unidades ON 
            tb_funcionarios.mcu_unidade = tb_unidades.mcu_unidade AND tb_funcionarios.status = :status AND matricula = :matricula AND senha = :senha";
            $dados = array(":status" => $status, ":matricula" => $matricula, ":senha" => $senha);
            $query = parent::executarSQL($sql, $dados);
            $resultado = $query->fetch(PDO::FETCH_OBJ);

            if($resultado){
                $_SESSION['logado'] = true;
                $_SESSION['matricula'] = $resultado->matricula;// Assumindo que 'id' é o identificador único do usuário
                $_SESSION['nome'] = $resultado->nome;
                $_SESSION['privilegio'] = $resultado->perfil;
                $_SESSION['unidade'] = $resultado->nome_unidade;
                date_default_timezone_set('America/Sao_Paulo');
                $data = new \DateTime('now');
                $gravarData = $data->format('Y-m-d H:i:s');

                /*$sql = "INSERT INTO logacesso (usuarioLogAcesso, matriculaLogAcesso, dataHoraAcesso) VALUES (:usuario, :matricula, :dataHora)";
                $dados = array(":usuario" => $_SESSION['nome'], ":matricula" => $_SESSION['matricula'], ":dataHora" => $gravarData);
                $query = parent::executarSQL($sql, $dados);
			    $resultado = parent::lastidSQL();*/
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
