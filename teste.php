<?php
require 'autoload.php';

use SADP\ConectarUsuario\ConectarBD;



        $newUsuario = 'Cristiane de Jesus Feitosa';
        $newMatricula = '8.888.888-8';
        $newEmail = 'crisjfferreira@gmail.com';
        $newTelefone = '(61) 2141-9136';
        $newCelular = '(61) 99552-0665';
        $newUnidade = 'CDIP BELO HORIZONTE';
        $newPerfil = 'Gestor';
        $newSenha = '123456';
    
    
    class CadastrarUsuario extends ConectarBD
    {
        private $nomeUsuario;
        private $matricula;
        private $email;
        private $telefone;
        private $celular;
        private $unidade;
        private $perfil;
        private $newSenha;
      
        
        public function __construct(
            $nomeUsuario, 
            $matricula, 
            $email, 
            $telefone, 
            $celular,
            $unidade, 
            $perfil, 
            $newSenha
        )
        {
            parent::__construct();
            $this->nomeUsuario = $nomeUsuario;
            $this->matricula = $matricula;
            $this->email = $email;
            $this->telefone = $telefone;
            $this->celular = $celular;
            $this->unidade = $unidade;
            $this->perfil = $perfil;
            $this->newSenha = $newSenha;
        }
        
        //Cadastra nome do novo usuário
        public function getNomeUsuario()
        {
            return $this->nomeUsuario;
        }
        
        //Cadastrar matricula de novo usuário
        public function getMatricula()
        {
            return $this->matricula;
        }
        
        //Cadastrar e-mail de novo usuário
        public function getEmail()
        {
            return $this->email;
        }
        
        //Cadastrar telefone de novo usuário
        public function getTelefone()
        {
            return $this->telefone;
        }
    
        //Cadastrar telefone de novo usuário
        public function getCelular()
        {
            return $this->celular;
        }
       
        //Cadastrar unidade de novo usuário
        public function getUnidade()
        {
            return $this->unidade;
        }
       
        //Cadastrar perfil de novo usuário
        public function getPerfil()
        {
            return $this->perfil;
        }
       
        //Cadastar senha de novo usuário
        public function getSenha()
        {
            return $this->newSenha;
        }
        
        public function alterarPerfil() 
        {
            $perfil = $this->getPerfil();
            
            $sql = "SELECT * FROM tb_perfil WHERE perfil = :perfil";
            $dados = array(
                ":perfil" => $perfil
            );
            $query = parent::executarSQL($sql,$dados);
            $resultado = $query->fetch(PDO::FETCH_OBJ);
    
            return $perfil = $resultado->perfil;      
        }
    
        public function alterarUnidade() 
        {
            $unidade = $this->getUnidade();
            
            $sql = "SELECT * FROM tb_unidades WHERE nome_unidade = :nome_unidade";
            $dados = array(
                ":nome_unidade" => $unidade
            );
            $query = parent::executarSQL($sql,$dados);
            $resultado = $query->fetch(PDO::FETCH_OBJ);
            
            return $unidade = $resultado->nome_unidade;
        }
    
        public function createUsuario() 
        {
            $nomeUsuario = $this->getNomeUsuario();
            $tratarMatricula = $this->getMatricula();
            $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);
            $email = $this->getEmail();
            $tratarTelefone = $this->getTelefone();
            $telefone = str_replace(['(', ')', ' ', '-'], '', $tratarTelefone);
            $inteiroTelefone = intval($telefone);
            $tratarCelular = $this->getCelular();
            $celular = str_replace(['(', ')', ' ', '-'], '', $tratarCelular);
            $inteiroCelular = intval($celular);
            $unidade = $this->alterarUnidade();
            $perfil = $this->alterarPerfil();
            $newSenha = $this->getSenha();
        
            // Prepare e execute a consulta SQL para verificar a existência do usuário
            $sqlVerifica = "SELECT * FROM tb_funcionarios WHERE matricula = :matricula";
            $dadosVerifica = array(
                ":matricula" => $matricula
            );
            $queryVerifica = parent::executarSQL($sqlVerifica, $dadosVerifica);
            $resultadoVerifica = $queryVerifica->fetch(PDO::FETCH_OBJ);
    
            if ($resultadoVerifica) {
                $this->responderJSON(false, 'Usuário já cadastrado.');
                return;
            }
    
            // Insere o novo usuário
            $sqlConsultarUnidades = "SELECT * FROM tb_unidades WHERE nome_unidade = :nome_unidade";
            $dadosUnidades = array(":nome_unidade" => $unidade);
            $queryUnidades = parent::executarSQL($sqlConsultarUnidades, $dadosUnidades);
            $resultadoUnidades = $queryUnidades->fetch(PDO::FETCH_OBJ);
            $mcu_unidade = $resultadoUnidades->mcu_unidade;
            $se = $resultadoUnidades->se;
    
            $sqlConsultarPerfil = "SELECT * FROM tb_perfil WHERE perfil = :perfil";
            $dadosPerfil = array(":perfil" => $perfil);
            $queryPerfil = parent::executarSQL($sqlConsultarPerfil, $dadosPerfil);
            $resultadoPerfil = $queryPerfil->fetch(PDO::FETCH_OBJ);
            $idPerfil = $resultadoPerfil->id_perfil;
    
            $status = 1;
    
            $sqlInsere = "INSERT INTO tb_funcionarios (matricula, nome, email, telefone, celular, se, mcu_unidade, perfil, senha, status) 
            VALUES (:matricula, :nome, :email, :telefone, :celular, :se, :mcu_unidade, :perfil, :senha, :status)";
            $dadosInsere = array(
                ":matricula" => $matricula,
                ":nome" => $nomeUsuario,
                ":email" => $email,
                ":telefone" => $inteiroTelefone,
                ":celular" => $inteiroCelular,
                ":se" => $se,
                ":mcu_unidade" => $mcu_unidade,
                ":perfil" => $idPerfil,
                ":senha" => $newSenha,
                ":status" => $status
            );
    
            $queryInsere = parent::executarSQL($sqlInsere, $dadosInsere);
    
            if ($queryInsere) {
                $this->responderJSON(true, 'Usuário cadastrado com sucesso.');
            } else {
                $this->responderJSON(false, 'Erro ao cadastrar usuário: ' . $this->conn->error);
            }
        }
    
        public function responderJSON($success, $message)
        {
            header('Content-Type: application/json');
            echo json_encode(['success' => $success, 'message' => $message]);
        }
    }
    

    $novoUsuario = new CadastrarUsuario(
        $newUsuario,
        $newMatricula,
        $newEmail,
        $newTelefone,
        $newCelular,
        $newUnidade,
        $newPerfil,
        $newSenha
        //password_hash($newSenha, PASSWORD_DEFAULT) // Criptografa a senha
    );
    
    $novoUsuario->createUsuario();