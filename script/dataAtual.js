const hoje = new Date();
// Obtém o dia, mês e ano
const dia = hoje.getDate().toString().padStart(2, '0');
const mes = (hoje.getMonth() + 1).toString().padStart(2, '0'); // Mês começa em 0
const ano = hoje.getFullYear();

// Formata a data para "yyyy-MM-dd"
const dataFormatadaParaInput = `${ano}-${mes}-${dia}`;


let dataIncial = document.getElementById('dataInicial');
dataIncial.value = dataFormatadaParaInput;

let dataFinal = document.getElementById('dataFinal');
dataFinal.value = dataFormatadaParaInput;

let unidade = document.getElementById('unidade');
