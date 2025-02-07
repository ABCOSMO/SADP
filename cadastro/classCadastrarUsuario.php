<?php
include_once('../classes/classConectarBD.php');

class cadastroUsuario extends conectarBD
{
    public function __construct(
        private string $nomeUsuario,
        private string $matricula,
        private string $email,
        private string $telefone,
        private string $unidade,
        private string $perfil,
        private string $senha
    )
    {
        parent::__construct();
    }

    //Cadastra nome do novo usuário
    public function getNomeUsuario(): string
    {
        return $this->nomeUsuario;
    }
    
    //Cadastrar matricula de novo usuário
    public function getMatricula(): string
    {
        return $this->matricula;
    }
    
    //Cadastrar e-mail de novo usuário
    public function getEmail(): string
    {
        return $this->email;
    }
    
    //Cadastrar telefone de novo usuário
    public function getTelefone(): string
    {
        return $this->telefone;
    }
   
    //Cadastrar unidade de novo usuário
    public function getUnidade(): string
    {
        return $this->unidade;
    }
   
    //Cadastrar perfil de novo usuário
    public function getPerfil(): string
    {
        return $this->perfil;
    }
   
    //Cadastar senha de novo usuário
    public function getSenha(): string
    {
        return $this->senha;
    }
    
    public function alterarPerfil() 
    {
        $perfil = $this->getPerfil();
        
        $stmt = $this->conn->prepare("SELECT * FROM privilegio WHERE idPrivilegio= ? ");
        $stmt->bind_param("i", $perfil);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();
        return $this->perfil = $row['privilegio'];      
    }

    public function alterarUnidade() 
    {
        $unidade = $this->getUnidade();
        
        $stmt = $this->conn->prepare("SELECT * FROM unidade WHERE idunidade= ? ");
        $stmt->bind_param("i", $unidade);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $row = $result->fetch_assoc();
        return $this->unidade = $row['unidade'];
    }

    public function createUsuario() 
    {
        $nomeUsuario = $this->getNomeUsuario();
        $tratarMatricula = $this->getMatricula();
        $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);
        $email = $this->getEmail();
        $telefone = $this->getTelefone();
        $unidade = $this->alterarUnidade();
        $perfil = $this->alterarPerfil();

        $senha = $this->getSenha();
    
        // Prepare e execute a consulta SQL para verificar a existência do usuário
        $stmt = $this->conn->prepare("SELECT * FROM usuario WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        $stmt->execute();
        $result = $stmt->get_result();
		
        if ($result->num_rows > 0) 
        {
            // Usuário já existe
            $response = array('success' => false, 'error' => 'Usuário já cadastrado');
            header('Content-Type: application/json');
            echo json_encode($response);
            //echo "Erro ao cadastrar o usuário.";
            $stmt->close(); // Fecha a consulta anterior
        } else {
            // Usuário não existe, então insere          
            $stmt = $this->conn->prepare("INSERT INTO usuario (usuario, matricula, email, telefone, unidadeUsuario, privilegioUsuario, senha) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nomeUsuario, $matricula, $email, $telefone, $unidade, $perfil, $senha);
            $stmt->execute();
				
            if ($stmt->affected_rows > 0) 
            {
                $response = array('success' => true, 'message' => 'Usuário cadastrado com sucesso.');
            } else {
                $response = array('success' => false, 'error' => $conn->error);
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            $stmt->close(); // Fecha a última consulta
        }
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

    public function editarUsuario() 
    {
        $tratarMatricula = $this->getMatricula();
        $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);
        $perfil = $this->alterarPerfil();
        $unidade = $this->alterarUnidade();
        $usuario = $this->getNomeUsuario();
        $email = $this->getEmail();
        $telefone = $this->getTelefone();
    
        $stmt = $this->conn->prepare("UPDATE usuario SET privilegioUsuario = ?, unidadeUsuario = ?, usuario = ?, matricula = ?, 
        email = ?, telefone = ? WHERE matricula = ?");
    
        if (!$stmt) {
            $response = array('success' => false, 'error' => $this->conn->error);
        } else {
            $stmt->bind_param("sssissi", $perfil, $unidade, $usuario, $matricula, $email, $telefone, $matricula);
    
            if ($stmt->execute()) {
                $response = array('success' => true, 'message' => 'Usuário alterado com sucesso.');
            } else {
                $response = array('success' => false, 'error' => $stmt->error); 
            }
    
            $stmt->close();
        }
        //var_dump($response);
        //exit;
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>