<?php

namespace SADP\Cadastrar;

use SADP\ConectarUsuario\ConectarBD;

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

        $stmt = $this->conn->prepare("DELETE FROM usuario WHERE matricula = ?");
        $stmt->bind_param("i", $matricula);
        $stmt->execute();

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
    
        $stmt->close();
    }
}