<?php
include_once('../classes/classConectarBD.php');

class cadastroUsuario extends conectarBD
{
    function __construct()
    {
        parent::__construct();
    }

    //Cadastra nome do novo usuário
    public function getNomeUsuario()
    {
        return $this->nomeUsuario;
    }
    //Alterar nome do usuário
    public function setNomeUsuario($nomeUsuario)
    {
        $this->nomeUsuario=$nomeUsuario;
    }
    //Cadastrar matricula de novo usuário
    public function getMatricula()
    {
        return $this->matricula;
    }
    //Alterar matrícula de usuário
    public function setMatricula($matricula)
    {
        $this->matricula=$matricula;
    }
    //Cadastrar e-mail de novo usuário
    public function getEmail()
    {
        return $this->email;
    }
    //Alterar e-mail de usuário
    public function setEmail($email)
    {
        $this->email=$email;
    }
    //Cadastrar telefone de novo usuário
    public function getTelefone()
    {
        return $this->telefone;
    }
    //Alterar Telefone de usuário
    public function setTelefone($telefone)
    {
        $this->telefone=$telefone;
    }
    //Cadastrar unidade de novo usuário
    public function getUnidade()
    {
        return $this->unidade;
    }
    //Alterar Telefone de usuário
    public function setUnidade($unidade)
    {
        $this->unidade=$unidade;
    }
    //Cadastrar perfil de novo usuário
    public function getPerfil()
    {
        return $this->perfil;
    }
    //Alterar Telefone de usuário
    public function setPerfil($perfil)
    {
        $this->perfil=$perfil;
    }
    //Cadastar senha de novo usuário
    public function getSenha()
    {
        return $this->senha;
    }
    //Alterar senha de usuário
    public function setSenha($senha)
    {
        //$senha = password_hash($senha, PASSWORD_DEFAULT); // Hash da senha para segurança
        $this->senha=$senha;
    }

    public function createUsuario() 
    {
        $nomeUsuario = $this->getNomeUsuario();
        $tratarMatricula = $this->getMatricula();
        $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);
        $email = $this->getEmail();
        $telefone = $this->getTelefone();
        $unidade = $this->getUnidade();
        
        $stmt = $this->conn->prepare("SELECT * FROM unidade WHERE idunidade= ? ");
        $stmt->bind_param("s", $unidade);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) 
        {
            // Autenticação bem-sucedida
            while($row = $result->fetch_assoc())
            {
                $unidade = $row['unidade'];
            }
        } 

        $perfil = $this->getPerfil();
        
        $stmt = $this->conn->prepare("SELECT * FROM privilegio WHERE idPrivilegio= ? ");
        $stmt->bind_param("s", $perfil);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) 
        {
            // Autenticação bem-sucedida
            while($row = $result->fetch_assoc())
            {
                $perfil = $row['privilegio'];
            }
        } 

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
            $stmt->close(); // Fecha a consulta anterior
            $stmt = $this->conn->prepare("INSERT INTO usuario (usuario, matricula, email, telefone, unidadeUsuario, privilegioUsuario, senha) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $nomeUsuario, $matricula, $email, $telefone, $unidade, $perfil, $senha);
            $stmt->execute();
    
            if ($stmt->affected_rows > 0) 
            {
                $response = array('success' => true);
                //header("Location: /fapi/producao/index.php?cadastro=novo");
            } else {
                $response = array('success' => false, 'error' => $conn->error);
                //echo "Erro ao cadastrar o usuário.";
            }
            header('Content-Type: application/json');
            echo json_encode($response);
            $stmt->close(); // Fecha a última consulta
        }
    }
}

?>