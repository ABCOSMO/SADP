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
        try{
            $sql = "SELECT tb_funcionarios.*, tb_unidades.nome_unidade FROM tb_funcionarios INNER JOIN tb_unidades ON 
                tb_funcionarios.mcu_unidade = tb_unidades.mcu_unidade GROUP BY tb_funcionarios.mcu_unidade";
            $query = parent::executarSQL($sql,[]);
            $resultado = $query->fetchAll(PDO::FETCH_OBJ);

            foreach($resultado as $key => $value) {
                $unidade = $value->nome_unidade;
                $mcuUnidade = $value->mcu_unidade;

                $consulta = "SELECT tb_funcionarios.*, tb_perfil.perfil FROM tb_funcionarios INNER JOIN tb_perfil ON  
                tb_funcionarios.perfil = tb_perfil.id_perfil AND mcu_unidade = :mcu_unidade";
                $dados = array(":mcu_unidade" => $mcuUnidade);
                $banco = parent::executarSQL($consulta,$dados);
                $result = $banco->fetchAll(PDO::FETCH_OBJ);
                        
                foreach($result as $key => $value) {
                    $matricula = $value->matricula;
                    $telefone = $value->telefone;
                    $celular = $value->celular;
                    $status = $value->status;                    
                    
                    if($status == 1){

                        $response[] = [
                            'unidade' => $unidade,
                            'usuario' => $value->nome,
                            'matricula' => $this -> formatarMatricula($matricula),
                            'email' => $value->email,
                            'telefone' => $this -> formatarTelefone($telefone),
                            'celular' => $this -> formatarCelular($celular),
                            'perfil' => $value->perfil,
                            'status' => $value->status
                        ];
                        
                    }else{

                        $response[] = [
                            'unidade' => $unidade,
                            'usuario' => $value->nome,
                            'matricula' => $this -> formatarMatricula($matricula),
                            'email' => $value->email,
                            'telefone' => $this -> formatarTelefone($telefone),
                            'celular' => $this -> formatarCelular($celular),
                            'perfil' => $value->perfil,
                            'status' => $value->status
                        ];                      
                    
                    }        
                }            
            }
            
    
            $status = 1;
            $sql = "SELECT * FROM tb_unidades WHERE status = :status ORDER BY nome_unidade";
            $dados = array(":status" => $status);
            $query = parent::executarSQL($sql,$dados);
            $resultado = $query->fetchAll(PDO::FETCH_OBJ);
            $idUnidade = 1;// valor unidade

            $sql2 = "SELECT * FROM tb_perfil WHERE status = :status ORDER BY id_perfil";
            $dados2 = array(":status" => $status);
            $query2 = parent::executarSQL($sql2,$dados2);
            $resultado2 = $query2->fetchAll(PDO::FETCH_OBJ);
            $idPerfil = 1;// valor perfil

            foreach($resultado2 as $key => $value) {
                $perfil = $value->perfil;
                $response[] = [
                    'lista_perfil' => $perfil,
                    'id_perfil' => $idPerfil
                ];
                $idPerfil++;
            }

            foreach($resultado as $key => $value) {
                $unidade = $value->nome_unidade;
                $response[] = [
                    'lista_unidade' => $unidade,
                    'id_unidade' => $idUnidade
                ];
                $idUnidade++;
            }           

            header('Content-Type: application/json');
            echo json_encode($response);
        }catch(\Exception $e) {
            $response = array('success' => false, 'error' => $e->getMessage());
            header('Content-Type: application/json');
            echo json_encode($response);
        }                   
    }
}

?>