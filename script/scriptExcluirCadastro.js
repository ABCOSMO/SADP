function excluirUsuario() {
    
    setTimeout(() => {
        const novoBotoesExcluir = document.querySelectorAll('.botao'); 
           
        for(let botoesExcluir = 0; botoesExcluir <= novoBotoesExcluir.length-1; botoesExcluir++) {

            const numeroBotao = novoBotoesExcluir[botoesExcluir]; 
            const bExcluir = numeroBotao.classList[1];
            const clicaBotaoExcluir =  document.querySelectorAll(`.${bExcluir}`);             
            const excluirMatricula = document.querySelectorAll(`#inputMatricula${botoesExcluir+2}`);                        
            
            clicaBotaoExcluir.forEach(botao => {
                botao.addEventListener('click', () => {                                           
                    // Confirmação antes de excluir
                    if (confirm('Tem certeza que deseja alterar este registro?')) {
                        
                        excluirMatricula.forEach(elemento => {
                            let valorMatricula = elemento.textContent.replace(/\D/g, "");
                            const id = valorMatricula;
                            
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
                                    alert('Registro alterado com sucesso!');
                                    // Remover a linha da tabela (implemente a lógica aqui)
                                    window.location.href = '../digitalizacao/alterarExcluirUsuario.php';
                                } else {
                                    alert('Erro ao alterar o registro: ' + data.error);
                                }
                            })
                            .catch(error => {
                                console.error('Erro:', error);
                            });
                        });                                    
                    }                        
                });
            });
                           
        }
    }, 500);   
}


document.addEventListener('DOMContentLoaded', excluirUsuario);