function enviarDadosFormulario()
		{
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
let inputImpossibilitada = document.getElementById('inputImpossibilitada');
let inputDigitalizada = document.getElementById('inputDigitalizada');
let inputResto = document.getElementById('inputResto');

inputAnterior.addEventListener('input', () => {
    inputAnterior.value = mascaraDigitarCarga(inputAnterior.value);
});

inputRecebida.addEventListener('input', () => {
    inputRecebida.value = mascaraDigitarCarga(inputRecebida.value);
});

inputImpossibilitada.addEventListener('input', () => {
    inputImpossibilitada.value = mascaraDigitarCarga(inputImpossibilitada.value);
});

inputDigitalizada.addEventListener('input', () => {
    inputDigitalizada.value = mascaraDigitarCarga(inputDigitalizada.value);
});

inputResto.addEventListener('input', () => {
    inputResto.value = mascaraDigitarCarga(inputResto.value);
});

function relatorioDigitalizacao() {
    let id = 0;
    let resultado = document.getElementById('dadosContainer'); // Obtém a referência uma vez
    resultado.innerHTML = ''; // Limpa o conteúdo existente
    fetch('../cadastro/controllerCargaDigitalizacao.php') 
    .then(response => response.json())
      .then(data => {
          // Aqui você pode trabalhar com os dados JSON recebidos
          //console.log(data);
          // Exibir os dados na tela, etc.
          
          data.forEach(item => {
              console.log(item.data_digitalizacao);
              console.log(item.imagens_anterior);
              resultado.innerHTML += 
                    `<form method="post" id="myForm${id}" name="autenticar${id}" >
                        <section class="modal-body">
                            <div class="input-group">
                                <input type="text" id="inputData${id}" name="novaData" value=${item.data_digitalizacao} maxlength="10">
                            </div>
                            <div class="input-group">
                                <input type="text" id="inputAnterior${id}" name="cargaAnterior" 
                                value=${item.imagens_anterior} maxlength="7">
                            </div>
                            <div class="input-group">
                                <input type="text" id="inputRecebida${id}" name="cargaRecebida" value=${item.imagens_recebidas} maxlength="7">
                            </div>
                            <div class="input-group">
                                <input type="text" id="inputImpossibilitada${id}" name="cargaImpossibilitada" value=${item.imagens_impossibilitadas} maxlength="7">
                            </div>
                            <div class="input-group">
                                <input type="text" id="inputDigitalizada${id}" name="cargaDigitalizada" value=${item.imagens_incorporadas} maxlength="7">
                            </div>
                            <div class="input-group">
                                <input type="text" id="inputResto${id}" name="cargaResto" value=${item.resto} maxlength="7">
                            </div>
                        </section>
                    </form>`;
                    id++;
          });
      })
      .catch(error => {
          console.error('Erro:', error);
      });
}

relatorioDigitalizacao();

function validaFormulario(){
    if (document.autenticar.inputData.value === ""){
        alert("Por favor, preencha o campo Data.");
        return false; // Formulário inválido

    }
    if (document.autenticar.inputAnterior.value === ""){
        alert("Por favor, preencha o campo Carga do dia anterior.");
        return false; // Formulário inválido

    }
    if (document.autenticar.inputRecebida.value === "") {
        alert("Por favor, preencha o campo Carga Recebida.");
        return false;
      }
    if (document.autenticar.inputImpossibilitada.value === "") {
        alert("Por favor, preencha o campo Carga Impossibilitada.");
        return false;
    }
    if (document.autenticar.inputDigitalizada.value === ""){
        alert("Por favor, preencha o campo Carga Digitalizada.");
        return false; // Formulário inválido

    }
    if (document.autenticar.inputResto.value === ""){
        alert("Por favor, preencha o campo Resto.");
        return false; // Formulário inválido
    }else{
		 return true; // Formulário inválido
    }
}

const form = document.getElementById('myForm');
form.addEventListener('submit', (event) => {
    event.preventDefault(); // Impede o envio padrão do formulário

    if (validaFormulario()) {
        // Se o formulário for válido, envie os dados
       enviarDadosFormulario();
       window.location.href = '../digitalizacao/lancarCarga.php';
    }
});