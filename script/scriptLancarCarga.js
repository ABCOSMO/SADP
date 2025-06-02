// scriptLancarCarga.js

// 1. Função para enviar os dados da carga
function enviarDadosCarga() {
    const form = document.getElementById('myForm');
    const loading = document.querySelector('.loading');

    // Mostrar a animação de loading, se o elemento existir
    if (loading) {
        loading.style.display = 'block';
    }

    // Coleta os dados do formulário principal
    const formData = new FormData(form); 

    // --- Coletar e adicionar dados do modal manualmente ---
    // Mesmo que o modal abra via outro script, seus elementos ainda precisam ser coletados.
    const modal = document.getElementById('modal-1');
    if (modal) {
        // Adicionar os valores dos botões de superintendência (ACR, AL, etc.)
        // Seleciona botões que têm 'estados' OU 'estado__alterado' para garantir que todos sejam pegos.
        const estadosButtons = modal.querySelectorAll('.estados, .estado__alterado'); 
        estadosButtons.forEach(button => {
            // Garante que o botão tem um atributo 'name' para ser enviado
            if (button.name) {
                formData.append(button.name, button.value); // Ex: 'acr': 'Pendente' ou 'acr': 'Recebido'
            }
        });

        // Adicionar o valor da textarea de ocorrências
        const ocorrenciaTextArea = document.getElementById('ocorrencia');
        if (ocorrenciaTextArea) {
            formData.append(ocorrenciaTextArea.name, ocorrenciaTextArea.value);
        }
    }
    // --- Fim da coleta de dados do modal ---

    // Para depuração: Exibe todos os dados que serão enviados no console do navegador
    console.log("Dados do formulário a serem enviados:");
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    // Enviar os dados usando Fetch API para o seu script PHP
    fetch('../cadastro/controllerCadastrarCarga.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Lança um erro se a resposta HTTP não for OK (status 200-299)
        if (!response.ok) {
            throw new Error('Erro de rede ou servidor não respondeu. Status: ' + response.status);
        }
        return response.json(); // Espera que o PHP retorne uma resposta JSON
    })
    .then(data => {
        // Ocultar a animação de loading
        if (loading) {
            loading.style.display = 'none';
        }
        console.log("Resposta do servidor:", data); // Log da resposta completa do PHP
        
        // Processa a resposta JSON do servidor
        if (data.success) {
            alert(data.message);
            // Redireciona a página APENAS se o envio for bem-sucedido
            window.location.href = '../digitalizacao/lancarCarga.php';
        } else {
            // Exibe a mensagem de erro retornada pelo PHP, ou uma mensagem genérica
            alert('Erro ao enviar os dados: ' + (data.error || 'Erro desconhecido.'));
        }
    })
    .catch(error => {
        // Ocultar a animação em caso de qualquer erro (rede, JSON inválido, etc.)
        if (loading) {
            loading.style.display = 'none';
        }
        console.error('Erro ao enviar os dados:', error);
        alert('Erro ao enviar os dados. Verifique o console do navegador para mais detalhes.');
    });
}

// 2. Listener para o evento 'submit' do formulário principal
// O 'DOMContentLoaded' garante que o script só roda depois que o HTML estiver totalmente carregado.
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('myForm');
    if (form) {
        form.addEventListener('submit', (event) => {
            event.preventDefault(); // IMPEDE o envio padrão do formulário (que recarregaria a página)

            // Chama a função de validação do seu arquivo 'validaFormulario.js'
            // Assumimos que 'validaFormulario()' retorna 'true' se o formulário for válido, 'false' caso contrário.
            if (typeof validaFormulario === 'function' && validaFormulario()) {
                enviarDadosCarga(); // Chama a função para processar e enviar os dados via Fetch
            } else if (typeof validaFormulario !== 'function') {
                // Se a função 'validaFormulario' não for encontrada, exibe um aviso
                // e tenta enviar os dados mesmo assim (você pode ajustar este comportamento)
                console.warn("A função 'validaFormulario' não foi encontrada. Verifique se o script 'validaFormulario.js' está carregado corretamente.");
                enviarDadosCarga();
            }
        });
    }
});


//----------------------------------------------------------------------------

function enviarDadosAlteradosDigitalizacao(id) {
    const form = document.getElementById(`myForm${id}`);
    const loading = document.querySelector('.loading');

    loading.style.display = 'block';

    // Coleta os dados dos inputs que começam com "inputModal"
    const formData = {};
    form.querySelectorAll('[id^="inputModal"]').forEach(input => {
        formData[input.name] = input.value;
    });

    console.log(formData);

    fetch('../cadastro/controllerAlterarDadosDigitalizacao.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json', // Indica que o corpo da requisição é JSON
        },
        body: JSON.stringify(formData) // Converte os dados para JSON
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Rede não responde');
        }
        return response.json();
    })
    .then(data => {
        loading.style.display = 'none';
        console.log(data);
        if (data.success) {
            alert(data.message);
            window.location.href = '../digitalizacao/lancarCarga.php';
        } else {
            alert('Erro ao enviar os dados: ' + data.error);
            window.location.href = '../digitalizacao/lancarCarga.php';
        }
    })
    .catch(error => {
        loading.style.display = 'none';
        console.error('Erro ao enviar os dados:', error);
        alert('Erro ao enviar os dados');
        window.location.href = '../digitalizacao/lancarCarga.php';
    });
}
    
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        const teste = document.querySelectorAll('form');        
            
            for(let i = 2; i <= teste.length; i++) {
                    
                const formu = document.getElementById(`myForm${i}`);
                if(formu) {
                    formu.addEventListener('submit', (event) => {
                        console.log('teste'); // Agora você deve ter todos os formulários 
                        event.preventDefault(); // Impede o envio padrão do formulário
                        
                        if (validaFormularioModal(i)) {
                             //Se o formulário for válido, envie os dados
                        enviarDadosAlteradosDigitalizacao(i);
                        }else{
                            console.log('erro');
                        }
                    });
                }else{
                    console.log('erro');
                }
            }
    },300);
        
});
    