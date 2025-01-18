<?php
include_once('../classConectarBD.php');

class selecionarUnidade extends conectarBD
{
    function __construct()
    {
        parent::__construct();
    }

    public function seletorUnidade()
    {
        $stmt = $this->conn->prepare("SELECT * FROM unidade");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) 
        {
            // Autenticação bem-sucedida
            while($row = $result->fetch_assoc())
            {
                $idUnidade = $row['idunidade'];// valor unidade
                $unidade = $row['unidade'];
                echo '<option id="selecionar__unidade" value="'. $idUnidade .'">'.$idUnidade." - ".$unidade.'</option>';
            }
        } 
    }

    public function seletorPerfil()
    {
        $stmt = $this->conn->prepare("SELECT * FROM privilegio");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) 
        {
            // Autenticação bem-sucedida
            while($row = $result->fetch_assoc())
            {
                $idPerfil = $row['idPrivilegio'];// valor unidade
                $perfil = $row['privilegio'];
                echo '<option value="'. $idPerfil .'" id="selecionar__unidade">'.$idPerfil." - ".$perfil.'</option>';
            }
        } 
    }
}

?>