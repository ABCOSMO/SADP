<?php

namespace FADPD\Lista;

use FADPD\ConectarUsuario\ConectarBD;
use PDO;
use PDOException;

class CargaAnterior extends ConectarBD
{

    private $matricula;
    private $unidade;

    public function __construct(
        $matricula,
        $unidade
    )
	{
		parent::__construct();
		$this->matricula = $matricula;
        $this->unidade = $unidade;
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

    function formatarNumeroComPonto($numero) 
    {
        return number_format($numero, 0, ',', '.');
    }
      

    //Cadastrar matricula de novo usuário
    public function getMatricula()
    {
        return $this->matricula;
    }
    
    public function getUnidade()
    {
        return $this->unidade;
    }
    
    public function mostrarCargaAnterior()
    {
        $tratarMatricula = $this->getMatricula();
        $matricula = str_replace(['.', '+', '-'], '', $tratarMatricula);
        $unidade = $this->getUnidade();

        $sql = "SELECT tb_funcionarios.*, tb_unidades.nome_unidade FROM tb_funcionarios INNER JOIN tb_unidades 
        ON tb_funcionarios.mcu_unidade = tb_unidades.mcu_unidade 
        AND tb_unidades.nome_unidade = :nome_unidade AND tb_funcionarios.matricula = :matricula";
        $dados = array(
            ":matricula" => $matricula,
            ":nome_unidade" => $unidade
        );
        $query = parent::executarSQL($sql,$dados);
        $resultado = $query->fetchAll(PDO::FETCH_OBJ);
       
        foreach($resultado as $key => $value) {
            $mcuUnidade = $value->mcu_unidade;
            // Autenticação bem-sucedida
            $sqlResto = "SELECT * FROM tb_digitalizacao WHERE mcu_unidade = :mcu_unidade ORDER BY id_digitalizacao DESC LIMIT 1";
            $dadosResto = array(":mcu_unidade" => $mcuUnidade);
            $queryResto = parent::executarSQL($sqlResto,$dadosResto);
            $resultadoResto = $queryResto->fetchAll(PDO::FETCH_OBJ);

            $resto = $this->formatarNumeroComPonto($resultadoResto[0]->qtd_imagens_resto);
            return $resto;
        }
    }
}

?>