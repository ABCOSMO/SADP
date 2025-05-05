function aplicarDataAtual() {
    const hoje = new Date();
    const dia = hoje.getDate().toString().padStart(2, '0');
    const mes = (hoje.getMonth() + 1).toString().padStart(2, '0');
    const ano = hoje.getFullYear();
    const dataFormatadaParaInput = `${ano}-${mes}-${dia}`;

    let dataInicial = document.getElementById('dataInicial');
    let dataFinal = document.getElementById('dataFinal');

    if (dataInicial) {
        dataInicial.value = dataFormatadaParaInput;
    }

    if (dataFinal) {
        dataFinal.value = dataFormatadaParaInput;
    }

    // Você pode adicionar lógica semelhante para outros elementos, se necessário
}