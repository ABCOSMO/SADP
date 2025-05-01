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
            for (let id = 0; id <= inputModal.length; id++) {
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

digitarFormulario();

digitarFormularioModal();
    