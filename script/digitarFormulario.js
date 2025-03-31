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

        if (inputModal.length > 0) { // Verifica se o modal existe
            for (let id = 0; id < inputModal.length; id++) {
                let inputAnteriorModal = document.getElementById(`inputModalAnterior${id}`);
                let inputRecebidaModal = document.getElementById(`inputModalRecebida${id}`);
                let inputImpossibilitadaModal = document.getElementById(`inputModalImpossibilitada${id}`);
                let inputDigitalizadaModal = document.getElementById(`inputModalDigitalizada${id}`);
                let inputRestoModal = document.getElementById(`inputModalResto${id}`);

                if (inputAnteriorModal) { // Verifica se o elemento existe
                    inputAnteriorModal.addEventListener('focus', () => {
                        inputAnteriorModal.value = '';
                    });
                    inputAnteriorModal.addEventListener('input', () => {
                        inputAnteriorModal.value = mascaraDigitarCarga(inputAnteriorModal.value);
                    });
                }

                if (inputRecebidaModal) {
                    inputRecebidaModal.addEventListener('focus', () => {
                        inputRecebidaModal.value = '';
                    });
                    inputRecebidaModal.addEventListener('input', () => {
                        inputRecebidaModal.value = mascaraDigitarCarga(inputRecebidaModal.value);
                    });
                }

                if (inputImpossibilitadaModal) {
                    inputImpossibilitadaModal.addEventListener('focus', () => {
                        inputImpossibilitadaModal.value = '';
                    });
                    inputImpossibilitadaModal.addEventListener('input', () => {
                        inputImpossibilitadaModal.value = mascaraDigitarCarga(inputImpossibilitadaModal.value);
                    });
                }

                if (inputDigitalizadaModal) {
                    inputDigitalizadaModal.addEventListener('focus', () => {
                        inputDigitalizadaModal.value = '';
                    });
                    inputDigitalizadaModal.addEventListener('input', () => {
                        inputDigitalizadaModal.value = mascaraDigitarCarga(inputDigitalizadaModal.value);
                    });
                }

                if (inputRestoModal) {
                    inputRestoModal.addEventListener('focus', () => {
                        inputRestoModal.value = '';
                    });
                    inputRestoModal.addEventListener('input', () => {
                        inputRestoModal.value = mascaraDigitarCarga(inputRestoModal.value);
                    });
                }
            }
        }
    }, 300);
}