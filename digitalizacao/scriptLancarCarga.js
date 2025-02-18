function enviarDadosFormulario()
		{
			const form = document.getElementById('myForm');
			const loading = document.querySelector('.loading');
			
			
				event.preventDefault();
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

function mascaraDigitarData(digitaData) {
    // Remove todos os caracteres não numéricos
    digitaData = digitaData.replace(/\D/g, "");

    // Verifica se o data contém até 8 dígitos
    if (digitaData.length !== 8) {
        return digitaData;
    }
    digitaData = digitaData.replace(/(\d{2})(\d{2})(\d{4})/, "$1/$2/$3"); // Retorna a data com formatação de 10 digitos
    return digitaData;
}

let inputData = document.getElementById('inputData');

inputData.addEventListener('input', () => {
    inputData.value = mascaraDigitarData(inputData.value);
});

function mascaraDigitarCarga(carga) {
    // Remove todos os caracteres não numéricos
    carga = carga.replace(/\D/g, "");

    // Verifica se o carga contém até 6 dígitos
    if (carga.length === 6) {
        carga = carga.replace(/(\d{3})(\d{3})/, "$1.$2"); // Retorna o carga com formatação de 6 digitos
        return carga;
    }
    if (carga.length === 5) {
        carga = carga.replace(/(\d{2})(\d{3})/, "$1.$2"); // Retorna o carga com formatação de 5 digitos
        return carga;
    }
    if (carga.length === 4) {
        carga = carga.replace(/(\d{1})(\d{3})/, "$1.$2"); // Retorna o carga com formatação de 4 digitos
        return carga;
    }
    if (carga.length !== 4) {
        carga = carga; // Retorna o carga sem formatação
        return carga;
    }    
}

// Conferindo no input os dados lançados
let inputAnterior = document.getElementById('inputAnterior');
let inputRecebida = document.getElementById('inputRecebida');
let inputDigitalizada = document.getElementById('inputDigitalizada');
let inputResto = document.getElementById('inputResto');

inputAnterior.addEventListener('input', () => {
    inputAnterior.value = mascaraDigitarCarga(inputAnterior.value);
});

inputRecebida.addEventListener('input', () => {
    inputRecebida.value = mascaraDigitarCarga(inputRecebida.value);
});

inputDigitalizada.addEventListener('input', () => {
    inputDigitalizada.value = mascaraDigitarCarga(inputDigitalizada.value);
});

inputResto.addEventListener('input', () => {
    inputResto.value = mascaraDigitarCarga(inputResto.value);
});

function validaFormulario(){
    if (document.autenticar.inputData.value === "")
    {
        alert("Por favor, preencha o campo Data.");
        return false; // Formulário inválido

    }
    if (document.autenticar.inputAnterior.value === "")
    {
        alert("Por favor, preencha o campo Carga do dia anterior.");
        return false; // Formulário inválido

    }
    if (document.autenticar.inputRecebida.value === "") {
        alert("Por favor, preencha o campo Carga Recebida.");
        return false;
      }
    if (document.autenticar.inputDigitalizada.value === "")
    {
        alert("Por favor, preencha o campo Carga Digitalizada.");
        return false; // Formulário inválido

    }
    if (document.autenticar.inputResto.value === "")
    {
        alert("Por favor, preencha o campo Resto.");
        return false; // Formulário inválido
    }else
    {
		 return true; // Formulário inválido
    }
}

const form = document.getElementById('myForm');
form.addEventListener('submit', (event) => {
    event.preventDefault(); // Impede o envio padrão do formulário

    if (validaFormulario()) {
        // Se o formulário for válido, envie os dados
       enviarDadosFormulario();
    }
});