<?php

namespace SADP\Cadastrar;

use SADP\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class ExcluirUsuario extends ConectarBD
{
    public function __construct(
        private string $matricula
    )
    {
        parent::__construct();
    }

    //Cadastrar matricula de novo usuário
    public function getMatricula(): string
    {
        return $this->matricula;
    }
    
    public function deletarUsuario() 
    {
        $tratarMatricula = $this->getMatricula();
        $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);

        $sql = "DELETE FROM usuario WHERE matricula = :matricula";
        $dados = array(":matricula" => $matricula);
        $query = parent::executarSQL($sql,$dados);
        $resultado = parent::lastidSQL();

        if ($query) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $resultado->error]);
        }
    }
}