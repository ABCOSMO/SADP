<?php
$senha = "Gu@rani69";

$salvar = password_hash($senha, PASSWORD_DEFAULT);
echo $salvar;

?>