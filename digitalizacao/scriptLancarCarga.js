let inputData = document.getElementById('inputData');

inputData.addEventListener('input', () => {
    inputData.value = mascaraDigitarData(inputData.value);
});

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


setTimeout(() => {
const conferindoModal = document.querySelectorAll('form');

    for(let a = 1; a < conferindoModal.length; a++) {

        let inputAnterior = document.getElementById(`inputAnterior${a}`);
        let inputRecebida = document.getElementById(`inputRecebida${a}`);
        let inputImpossibilitada = document.getElementById(`inputImpossibilitada${a}`);
        let inputDigitalizada = document.getElementById(`inputDigitalizada${a}`);
        let inputResto = document.getElementById(`inputResto${a}`);
        //console.log(inputRecebida.value);


        let input = document.getElementById(`inputRecebida${a}`);
        console.log(input.value);
    
        // Adiciona um ouvinte de evento input ao input
        input.addEventListener('input', (event) => {
            // Obtém o novo valor do input
            const novoValor = event.target.value;

            // Atualiza o valor do input (opcional)
            console.log('Novo valor:', novoValor);
        });


        inputAnterior.addEventListener('input', () => {
            inputAnterior.value += mascaraDigitarCarga(inputAnterior.value);
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

    }
}, 100);

relatorioDigitalizacao();


const form = document.getElementById('myForm');
form.addEventListener('submit', (event) => {
    event.preventDefault(); // Impede o envio padrão do formulário

    if (validaFormulario()) {
        // Se o formulário for válido, envie os dados
       enviarDadosFormulario();
       window.location.href = '../digitalizacao/lancarCarga.php';
    }
});


setTimeout(() => {
const teste = document.querySelectorAll('form');

    for(let i = 1; i < teste.length; i++) {

        const formu = document.getElementById(`myForm${i}`);
    
        formu.addEventListener('submit', (event) => {
            event.preventDefault(); // Impede o envio padrão do formulário

            if (validaFormularioModal(i)) {
                // Se o formulário for válido, envie os dados
            //enviarDadosFormulario();
            //window.location.href = '../digitalizacao/lancarCarga.php';

            alert('validado com sucesso');
            }
        });
    }
}, 250);




