<?php

namespace SADP\Lista;

use SADP\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class SelecionarUnidade extends ConectarBD
{
    function __construct()
    {
        parent::__construct();
    }

    public function obterUnidade()
    {
        try {
            $status = 1;
            $sql = "SELECT * FROM tb_unidades WHERE status = :status ORDER BY nome_unidade";
            $dados = array(":status" => $status);
            $query = parent::executarSQL($sql,$dados);
            $resultado = $query->fetchAll(PDO::FETCH_OBJ);
            $idUnidade = 1;// valor unidade

            foreach($resultado as $key => $value) {
                $unidade = $value->nome_unidade;
                echo '<option id="selecionar__unidade" value="'. $unidade .'">'.$idUnidade." - ".$unidade.'</option>';
                $idUnidade++;
            }
        } catch(PDOException $e){
            // Registre o erro em um arquivo de log ou exiba uma mensagem amigável
            $erroLog = error_log("Erro ao obter unidades: " . $e->getMessage());
            //$json = json_encode($erroLog);
            //file_put_contents("../digitalizacao/dados.json", $erroLog);
        }         
    }

    public function obterPerfil()
    {
        try {
            $status = 1;
            $sql = "SELECT * FROM tb_perfil WHERE status = :status ORDER BY id_perfil";
            $dados = array(":status" => $status);
            $query = parent::executarSQL($sql,$dados);
            $resultado = $query->fetchAll(PDO::FETCH_OBJ);
            $idPerfil = 1;// valor unidade

            foreach($resultado as $key => $value) {
                $perfil = $value->perfil;
                echo '<option value="'. $perfil .'" id="selecionar__unidade">'.$idPerfil." - ".$perfil.'</option>';
                $idPerfil++;
            }
        } catch(PDOException $e) {
            // Registre o erro em um arquivo de log ou exiba uma mensagem amigável
            $erroLog = error_log("Erro ao obter perfil: " . $e->getMessage());
            //$json = json_encode($erroLog);
            //file_put_contents("../digitalizacao/dados.json", $erroLog);
        }
    }
}

?>