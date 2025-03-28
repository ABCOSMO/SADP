function digitarFormulario() {
    // Conferindo no input os dados lançados
    let inputData = document.getElementById('inputData');
    let inputAnterior = document.getElementById('inputAnterior');
    let inputRecebida = document.getElementById('inputRecebida');
    let inputImpossibilitada = document.getElementById('inputImpossibilitada');
    let inputDigitalizada = document.getElementById('inputDigitalizada');
    let inputResto = document.getElementById('inputResto');

    inputData.addEventListener('input', () => {
        inputData.value = mascaraDigitarData(inputData.value);
    });

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

}

function digitarFormularioModal() {
    setTimeout(() => {

        const inputModal = document.querySelectorAll('form');
    
        for (let id = 0; id < inputModal.length; id++) {
            let inputAnteriorModal = document.getElementById(`inputModalAnterior${id}`);
            let inputRecebidaModal = document.getElementById(`inputModalRecebida${id}`);
            let inputImpossibilitadaModal = document.getElementById(`inputModalImpossibilitada${id}`);
            let inputDigitalizadaModal = document.getElementById(`inputModalDigitalizada${id}`);
            let inputRestoModal = document.getElementById(`inputModalResto${id}`);
        
            inputAnteriorModal.addEventListener('focus', () => {
                inputAnteriorModal.value = '';
            });

            inputRecebidaModal.addEventListener('focus', () => {
                inputRecebidaModal.value = '';
            });

            inputImpossibilitadaModal.addEventListener('focus', () => {
                inputImpossibilitadaModal.value = '';
            });

            inputDigitalizadaModal.addEventListener('focus', () => {
                inputDigitalizadaModal.value = '';
            });

            inputRestoModal.addEventListener('focus', () => {
                inputRestoModal.value = '';
            });

            inputAnteriorModal.addEventListener('input', () => {
                inputAnteriorModal.value = mascaraDigitarCarga(inputAnteriorModal.value);
            });
        
            inputRecebidaModal.addEventListener('input', () => {
                inputRecebidaModal.value = mascaraDigitarCarga(inputRecebidaModal.value);
            });
        
            inputImpossibilitadaModal.addEventListener('input', () => {
                inputImpossibilitadaModal.value = mascaraDigitarCarga(inputImpossibilitadaModal.value);
            });
        
            inputDigitalizadaModal.addEventListener('input', () => {
                inputDigitalizadaModal.value = mascaraDigitarCarga(inputDigitalizadaModal.value);
            });
        
            inputRestoModal.addEventListener('input', () => {
                inputRestoModal.value = mascaraDigitarCarga(inputRestoModal.value);
            });
        }
    }, 300);
}