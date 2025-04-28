<?php
namespace FADPD\Relatorios;

class CalcularData
{
    public function calcularDataAnterior($data) {
        
        // Clona o objeto para calcular a data anterior
        $dataAnterior = clone $data;
        $dataAnterior->modify('-15 days');        

        // Retorna um array com as datas formatadas
        return $dataAnterior->format('Y-m-d');
    }


    public function calcaularDataPosterior($data) {
        
        // Clona o objeto original para calcular a data posterior
        $dataPosterior = clone $data;
        $dataPosterior->modify('+15 days');

        return $dataPosterior->format('Y-m-d');
    }
}