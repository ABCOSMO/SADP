<?php

namespace SADP\Cadastrar;

use SADP\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class AlterarCadastro extends ConectarBD
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
            $sql = "SELECT * FROM usuario WHERE matricula = :matricula";
            $dados = array(":matricula" => $matricula);
            $query = parent::executarSQL($sql,$dados);
            $resultado = $query->fetch(PDO::FETCH_OBJ);

            if ($resultado) {
                // Autenticação bem-sucedida
                $usuario = $resultado->usuario;// Assumindo que 'id' é o identificador único do usuário
                $matricula = $resultado->matricula;
                $email = $resultado->email;
                $telefone = $resultado->telefone;
                $perfil = $resultado->privilegioUsuario;
                $unidade = $resultado->unidadeUsuario;

                header('Location: ../digitalizacao/alterarUsuario.php?usuario=' . $usuario . '&matricula=' . $this->formatarMatricula($matricula) . 
                '&email=' . $email . '&telefone=' . $telefone . '&perfil=' . $perfil . '&unidade=' . $unidade);
            }
        }
    }
}