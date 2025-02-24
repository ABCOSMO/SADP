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
            $sql = "SELECT * FROM unidade";
            $query = parent::executarSQL($sql,[]);
            $resultado = $query->fetchAll(PDO::FETCH_OBJ);

            foreach($resultado as $key => $value) {
                $idUnidade = $value->idunidade;// valor unidade
                $unidade = $value->unidade;
                echo '<option id="selecionar__unidade" value="'. $idUnidade .'">'.$idUnidade." - ".$unidade.'</option>';
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
            $sql = "SELECT * FROM privilegio";
            $query = parent::executarSQL($sql,[]);
            $resultado = $query->fetchAll(PDO::FETCH_OBJ);

            foreach($resultado as $key => $value) {
                $idPerfil = $value->idPrivilegio;// valor unidade
                $perfil = $value->privilegio;
                echo '<option value="'. $idPerfil .'" id="selecionar__unidade">'.$idPerfil." - ".$perfil.'</option>';
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