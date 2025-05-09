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
	
	public function formatarTelefone($telefone) 
    {    
        // Divide a matrícula em partes para facilitar a formatação
        $parte1 = substr($telefone, 0, 2);
        $parte2 = substr($telefone, 2, 4);
        $parte3 = substr($telefone, 6, 4);
    
        // Junta as partes com os pontos e hífen
        $telefoneFormatado = '(' . $parte1 . ') ' . $parte2 . '-' . $parte3;
    
        return $telefoneFormatado;
    }
	
	public function formatarCelular($celular) 
    {    
        // Divide a matrícula em partes para facilitar a formatação
        $parte1 = substr($celular, 0, 2);
        $parte2 = substr($celular, 2, 5);
        $parte3 = substr($celular, 7, 4);
    
        // Junta as partes com os pontos e hífen
        $celularFormatado = '(' . $parte1 . ') ' . $parte2 . '-' . $parte3;
    
        return $celularFormatado;
    }
    
    public function mostrarUsuario()
    {
        $sql = "SELECT tb_funcionarios.*, tb_unidades.nome_unidade FROM tb_funcionarios INNER JOIN tb_unidades ON 
            tb_funcionarios.mcu_unidade = tb_unidades.mcu_unidade GROUP BY tb_funcionarios.mcu_unidade";
        $query = parent::executarSQL($sql,[]);
        $resultado = $query->fetchAll(PDO::FETCH_OBJ);

        foreach($resultado as $key => $value) {
            $unidade = $value->nome_unidade;
            $mcuUnidade = $value->mcu_unidade;

            echo "<div class='modal-body'>
                <div class='input-group'>
                    <label for='nome'>
                        $unidade
                    </label>
                    <table class='container__usuario'>
                        <tr>
                            <th class='usuario' id='usuario'>Usuário</th>
                            <th class='usuario' id='usuario'>Matrícula</th>
                            <th class='usuario' id='usuario'>e-mail</th>
                            <th class='usuario' id='usuario'>Telefone</th>
                            <th class='usuario' id='usuario'>Celular</th>
                            <th class='usuario' id='usuario'>Perfil</th>
                            <th class='usuario' id='usuario'>Alterar</th>
                            <th class='usuario' id='usuario'>Alterar Status</th>
                        </tr>";
            $consulta = "SELECT tb_funcionarios.*, tb_perfil.perfil FROM tb_funcionarios INNER JOIN tb_perfil ON  
            tb_funcionarios.perfil = tb_perfil.id_perfil AND mcu_unidade = :mcu_unidade";
            $dados = array(":mcu_unidade" => $mcuUnidade);
            $banco = parent::executarSQL($consulta,$dados);
            $result = $banco->fetchAll(PDO::FETCH_OBJ);
                    
            foreach($result as $key => $value) {
                $usuario = $value->nome;
                $matricula = $value->matricula;
                $matriculaFormatada = $this -> formatarMatricula($matricula);
                $email = $value->email;
                $telefone = $value->telefone;
				$telefoneFormatado = $this -> formatarTelefone($telefone);
                $celular = $value->celular;
				$celularFormatado = $this -> formatarCelular($celular);
                $perfil = $value->perfil;
                $status = $value->status;
                
                if($status == 1){
                    echo "  <tr class='container__usuario'>
                                <td class='usuario' id='usuario'>$usuario</td>
                                <td class='usuario' id='usuario'>$matriculaFormatada</td>
                                <td class='usuario' id='usuario'>$email</td>
                                <td class='usuario' id='usuario'>$telefoneFormatado</td>
                                <td class='usuario' id='usuario'>$celularFormatado</td>
                                <td class='usuario' id='usuario'>$perfil</td>
                                <td class='usuario' id='usuario'><a href='../cadastro/controllerAlterarCadastro.php?matricula=$matricula'>
                                <button class='botao__alterar_excluir'><i class='fa-solid fa-pencil'></i></button></a></td>
                                <td class='usuario' id='usuario'><button data-id='$matriculaFormatada' class='botao__excluir botao__alterar_excluir'>
                                <i class='fa-solid fa-trash'></i></button></td>
                            </tr>";
                }else{
                    echo "  <tr class='container__usuario'>
                                <td class='usuarioDesabilitado' id='usuario'>$usuario</td>
                                <td class='usuarioDesabilitado' id='usuario'>$matriculaFormatada</td>
                                <td class='usuarioDesabilitado' id='usuario'>$email</td>
                                <td class='usuarioDesabilitado' id='usuario'>$telefone</td>
                                <td class='usuarioDesabilitado' id='usuario'>$celular</td>
                                <td class='usuarioDesabilitado' id='usuario'>$perfil</td>
                                <td class='usuarioDesabilitado' id='usuario'><a href='../cadastro/controllerAlterarCadastro.php?matricula=$matricula'>
                                <button class='botao__alterar_excluir'><i class='fa-solid fa-pencil'></i></button></a></td>
                                <td class='usuarioDesabilitado' id='usuario'><button data-id='$matriculaFormatada' class='botao__excluir botao__alterar_excluir'>
                                <i class='fa-solid fa-trash'></i></button></td>
                            </tr>";
                }        
            }          
            echo "</table>
                </div>
            </div>";
        }             
                 
    }
}

?>