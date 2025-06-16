// ---
// FUNÇÃO PARA ADICIONAR LISTENERS AOS BOTÕES DE EXCLUIR
// ---

function adicionarListenersExcluir() {
    // Seleciona todos os botões de exclusão usando a classe geral
    const botoesExcluir = document.querySelectorAll('.botao__excluir');

    botoesExcluir.forEach(button => {
        // Remove qualquer listener anterior para evitar duplicação em re-renderizações
        button.removeEventListener('click', handleExcluirButtonClick);
        // Adiciona o novo listener
        button.addEventListener('click', handleExcluirButtonClick);
    });

    function handleExcluirButtonClick(event) {
        const button = event.currentTarget;
        const id = button.dataset.matricula; // Obtém a matrícula do atributo data-matricula
        const data = button.dataset.data;     // Obtém a data do atributo data-data

        // Confirmação antes de excluir
        if (confirm('Tem certeza que deseja excluir este registro?')) {
            console.log(`Excluindo registro: Matrícula ${id}, Data ${data}`);

            // Envia uma requisição POST para o servidor
            fetch('../cadastro/controllerExcluirCargaDigitalizacao.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id, data: data })
            })
            .then(response => {
                return response.json(); // Converter a resposta para JSON
            })
            .then(data => {
                if (data.success) {
                    alert('Registro excluído com sucesso!');
                    // Recarrega os dados após a exclusão para atualizar a tabela
                    relatorioDigitalizacao(); 
                } else {
                    alert('Erro ao excluir o registro: ' + (data.error || 'Erro desconhecido.'));
                }
            })
            .catch(error => {
                console.error('Erro na requisição de exclusão:', error);
                alert('Erro ao excluir o registro.');
            });
        }
    }
}

/*
function excluirCargaDigitalizacao() {
    setTimeout(() => {
        const novoBotoesExcluir = document.querySelectorAll('.botao');

        for (let botoesExcluir = 0; botoesExcluir <= novoBotoesExcluir.length-1; botoesExcluir++) {
            const numeroBotao = novoBotoesExcluir[botoesExcluir];
            const bExcluir = numeroBotao.classList[1];
            const clicaBotaoExcluir = document.querySelectorAll(`.${bExcluir}`);
            const excluirMatricula = document.querySelectorAll(`#matricula${botoesExcluir+2}`);
            const excluirData = document.querySelectorAll(`#Data${botoesExcluir+2}`);
            console.log(excluirData);

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
                                        window.location.href = '../digitalizacao/lancarCarga.php';
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

document.addEventListener('DOMContentLoaded',  adicionarListenersExcluir);
*/