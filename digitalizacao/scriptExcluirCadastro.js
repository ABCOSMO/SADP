function excluirUsuario()
{
    const botoesExcluir = document.querySelectorAll('.botao__excluir');

    botoesExcluir.forEach(botao => {
        botao.addEventListener('click', () => {
            const id = botao.dataset.id;
            
            // Confirmação antes de excluir
            if (confirm('Tem certeza que deseja excluir este registro?')) {
                // Envia uma requisição POST para o servidor
                fetch('../cadastro/controllerExcluirCadastro.php', {
                    method: 'POST',
                    body: JSON.stringify({ id: id })
                })
                .then(response => {
                    return response.json(); // Converter a resposta para JSON
                })
                .then(data => {
                    if (data.success) {
                        alert('Registro excluído com sucesso!');
                        // Remover a linha da tabela (implemente a lógica aqui)
                        window.location.href = '../digitalizacao/alterarExcluirUsuario.php';
                    } else {
                        alert('Erro ao excluir o registro: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
            }
        });
    });
}

excluirUsuario();   