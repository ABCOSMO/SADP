relatorioDigitalizacao();

digitarFormulario();

digitarFormularioModal();
    
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

    event.preventDefault();
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
        }
    })
    .catch(error => {
        loading.style.display = 'none';
        console.error('Erro ao enviar os dados:', error);
        alert('Erro ao enviar os dados');
    });
}
    
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        const teste = document.querySelectorAll('form');        
            
            for(let i = 0; i < teste.length; i++) {
                    
                const formu = document.getElementById(`myForm${i}`);
                if(formu) {
                    formu.addEventListener('submit', (event) => {
                        console.log('teste'); // Agora você deve ter todos os formulários 
                        event.preventDefault(); // Impede o envio padrão do formulário
                        
                        if (validaFormularioModal(i)) {
                             //Se o formulário for válido, envie os dados
                        enviarDadosAlteradosDigitalizacao(i);
                        window.location.href = '../digitalizacao/lancarCarga.php';
            
                        alert('validado com sucesso');
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
    