<?php

namespace SADP\Lista;

use SADP\ConectarUsuario\ConectarBD;

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
        $stmt = $this->conn->prepare("SELECT * FROM usuario GROUP BY unidadeUsuario");
        $stmt->execute();
        $result = $stmt->get_result();
        $returnValue = array();

        if ($result->num_rows > 0) 
        {
            // Autenticação bem-sucedida
            while($row = $result->fetch_assoc())
            {
                $unidade = $row['unidadeUsuario'];

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

                $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE unidadeUsuario = ?");
                $stmt->bind_param("s", $unidade);
                $stmt->execute();
                $result2 = $stmt->get_result();
                    
                if ($result2->num_rows > 0) 
                {
                    // Autenticação bem-sucedida
                    while($row = $result2->fetch_assoc())
                    {
                        $usuario = $row['usuario'];
                        $matricula = $row['matricula'];
                        $matriculaFormatada = $this -> formatarMatricula($matricula);
                        $email = $row['email'];
                        $telefone = $row['telefone'];
                        $perfil = $row['privilegioUsuario'];
                                    
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
                echo "     </table>
                        </div>
                    </div>";
                    
                } 
            }
        }

        
        $stmt->close();
        $this->conn->close();
    }
}

?>