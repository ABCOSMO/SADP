function enviarDadosFormulario() {
    const form = document.getElementById('myForm');
    const loading = document.querySelector('.loading');

    // Mostrar a animação
    loading.style.display = 'block';
    const formData = new FormData(form);
    console.log(formData);

    fetch('../cadastro/controllerCadastrarCarga.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
        throw new Error('Rede não responde');
        }
        return response.json();
    }) 
    // Recebe a resposta como JSON
    .then(data => {
        // Ocultar a animação e exibir uma mensagem
        loading.style.display = 'none';
        console.log(data);
        // Processa a resposta JSON, por exemplo, exibindo uma mensagem
        if (data.success) {
            alert(data.message);
            window.location.href = '../digitalizacao/lancarCarga.php';
        } else {
            alert('Erro ao enviar os dados: ' + data.error);
        }
    })
    .catch(error => {
        loading.style.display = 'none';
        console.error('Erro ao enviar os dados:', error);
        alert('Erro ao enviar os dados');
    });
}


//adicionarListenersFormularios();
        const form = document.getElementById('myForm');
        form.addEventListener('submit', (event) => {
            event.preventDefault(); // Impede o envio padrão do formulário
            if (validaFormulario()) {
                // Se o formulário for válido, envie os dados
            enviarDadosFormulario();
            window.location.href = '../digitalizacao/lancarCarga.php';
            }
        });


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
    