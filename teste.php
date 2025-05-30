<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="dados.xls"');

echo '<table border="1">
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>E-mail</th>
        <th>Telefone</th>
        <th>Data Cadastro</th>
    </tr>
    <tr>
        <td>1</td>
        <td>João Silva</td>
        <td>joao@exemplo.com</td>
        <td>(11) 9999-8888</td>
        <td>2023-01-15</td>
    </tr>
    <tr>
        <td>2</td>
        <td>Maria Souza</td>
        <td>maria@exemplo.com</td>
        <td>(21) 8888-7777</td>
        <td>2023-02-20</td>
    </tr>
</table>';
?>