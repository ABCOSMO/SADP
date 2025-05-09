function excluirCargaDigitalizacao() {
    setTimeout(() => {
        const novoBotoesExcluir = document.querySelectorAll('.botao');

        for (let botoesExcluir = 0; botoesExcluir <= novoBotoesExcluir.length-1; botoesExcluir++) {
            const numeroBotao = novoBotoesExcluir[botoesExcluir];
            const bExcluir = numeroBotao.classList[1];
            const clicaBotaoExcluir = document.querySelectorAll(`.${bExcluir}`);
            const excluirMatricula = document.querySelectorAll(`#matricula${botoesExcluir+2}`);
            const excluirData = document.querySelectorAll(`#Data${botoesExcluir+2}`);

            clicaBotaoExcluir.forEach(botao => {
                botao.addEventListener('click', () => {
                    // Confirmação antes de excluir
                    if (confirm('Tem certeza que deseja alterar este registro?')) {

                        excluirMatricula.forEach(elementoMatricula => {
                            let valorMatricula = elementoMatricula.textContent.replace(/\D/g, "");
                            const id = valorMatricula;

                            excluirData.forEach(elementoData => {
                                const data = elementoData.textContent;

                                // Envia uma requisição POST para o servidor
                                fetch('../cadastro/controllerExcluirCargaDigitalizacao.php', {
                                    method: 'POST',
                                    body: JSON.stringify({ id: id, data: data }) // Inclui 'data' no objeto JSON
                                })
                                .then(response => {
                                    return response.json(); // Converter a resposta para JSON
                                })
                                .then(data => {
                                    if (data.success) {
                                        alert('Registro excluido com sucesso!');
                                        // Remover a linha da tabela (implemente a lógica aqui)
                                        window.location.href = '../digitalizacao/relatorioDigitalizacao.php';
                                    } else {
                                        alert('Erro ao alterar o registro: ' + data.error);
                                    }
                                })
                                .catch(error => {
                                    console.error('Erro:', error);
                                });
                            });
                        });
                    }
                });
            });
        }
    }, 500);
}
