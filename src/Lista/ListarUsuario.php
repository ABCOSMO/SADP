<?php

namespace SADP\Lista;

use SADP\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class ListarUsuario extends ConectarBD
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
    
    public function mostrarUsuario()
    {
        $sql = "SELECT * FROM usuario GROUP BY unidadeUsuario";
        $query = parent::executarSQL($sql,[]);
        $resultado = $query->fetchAll(PDO::FETCH_OBJ);

        foreach($resultado as $key => $value) {
            $unidade = $value->unidadeUsuario;

            echo "<div class='modal-body'>
                <div class='input-group'>
                    <label for='nome'>
                        $unidade
                    </label>
                    <table class='container__usuario'>
                        <tr>
                            <th id='usuario'>Usuário</th>
                            <th id='usuario'>Matrícula</th>
                            <th id='usuario'>e-mail</th>
                            <th id='usuario'>Telefone</th>
                            <th id='usuario'>Perfil</th>
                            <th id='usuario'>Alterar</th>
                            <th id='usuario'>Excluir</th>
                        </tr>";
            $consulta = "SELECT * FROM usuario WHERE unidadeUsuario = :unidadeUsuario";
            $dados = array(":unidadeUsuario" => $unidade);
            $banco = parent::executarSQL($consulta,$dados);
            $result = $banco->fetchAll(PDO::FETCH_OBJ);
                    
            foreach($result as $key => $value) {
                $usuario = $value->usuario;
                $matricula = $value->matricula;
                $matriculaFormatada = $this -> formatarMatricula($matricula);
                $email = $value->email;
                $telefone = $value->telefone;
                $perfil = $value->privilegioUsuario;
                                    
                echo "  <tr class='container__usuario'>
                            <td id='usuario'>$usuario</td>
                            <td id='usuario'>$matriculaFormatada</td>
                            <td id='usuario'>$email</td>
                            <td id='usuario'>$telefone</td>
                            <td id='usuario'>$perfil</td>
                            <td id='usuario'><a href='../cadastro/controllerAlterarCadastro.php?matricula=$matricula'><button class='botao__alterar_excluir'><i class='fa-solid fa-pencil'></i></button></a></td>
                            <td id='usuario'><button data-id='$matriculaFormatada' class='botao__excluir botao__alterar_excluir'>
                            <i class='fa-solid fa-trash'></i></button></td>
                        </tr>";
            }          
            echo "</table>
                </div>
            </div>";
        }             
                 
    }
}

?>