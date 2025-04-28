<?php

namespace FADPD\Lista;

class SelecionarData
{
    public function obterAno()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $anoAtual = intval(date('Y')); // Obtém o ano atual como um inteiro
        $anoAnterior = $anoAtual - 5;
        $anoPosterior = $anoAtual + 5;
        $a = 1;

        for ($ano = $anoAnterior; $ano <= $anoPosterior; $ano++) {
            echo '<option id="selecionar__ano" value="'. $a .'">'.$ano.'</option>';
            $a++;
        }
    }


    public function obterMes()
    {
        $meses = [
            'Janeiro',
            'Fevereiro',
            'Março',
            'Abril',
            'Maio',
            'Junho',
            'Julho',
            'Agosto',
            'Setembro',
            'Outubro',
            'Novembro',
            'Dezembro'
        ];

        $m = 1;
        foreach ($meses as $numeroDoMes => $nomeDoMes) {
            echo '<option id="selecionar__mes" value="'. $m .'">'.$nomeDoMes.'</option>';
            $m++;
        }
    }

}