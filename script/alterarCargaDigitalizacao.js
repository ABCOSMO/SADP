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
            window.location.href = '../digitalizacao/relatorioDigitalizacao.php';
        } else {
            alert('Erro ao enviar os dados: ' + data.error);
            window.location.href = '../digitalizacao/relatorioDigitalizacao.php';
        }
    })
    .catch(error => {
        loading.style.display = 'none';
        console.error('Erro ao enviar os dados:', error);
        alert('Erro ao enviar os dados');
        window.location.href = '../digitalizacao/relatorioDigitalizacao.php';
    });
}

function alterarDadosDigitalizacao(data) {
    const forms = document.querySelectorAll('form[id^="myForm"]');

    forms.forEach(form => {
        const id = form.id.replace('myForm', '');
        form.addEventListener('submit', (event) => {
            event.preventDefault();

            if (validaFormularioModal(id)) {
                enviarDadosAlteradosDigitalizacao(id);
            } else {
                console.log('Erro de validação no modal ' + id);
            }
        });
    });
}