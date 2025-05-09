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

function adicionarListenersModal() {
    // Impedir que eventos se propaguem para elementos pais
    document.addEventListener('click', function(e) {
        if (e.target.closest('.open-modal') || e.target.closest('.close-modal')) {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    // Abrir modal
    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            const modal = document.getElementById(modalId);
            
            if (modal) {
                modal.showModal();
                // Adiciona classe ao body para evitar scroll
                document.body.classList.add('modal-open');
                
                // Focar no primeiro elemento input do modal
                const firstInput = modal.querySelector('input, select, textarea');
                if (firstInput) {
                    firstInput.focus();
                }
            }
        });
    });

    // Fechar modal
    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            const modal = document.getElementById(modalId);
            
            if (modal) {
                modal.close();
                document.body.classList.remove('modal-open');
            }
        });
    });

    // Fechar modal ao clicar no backdrop
    /*document.querySelectorAll('dialog').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.close();
                document.body.classList.remove('modal-open');
            }
        });
    });*/
}


/*
function adicionarListenersModal() {
    let openButtons = document.querySelectorAll('.open-modal');
    openButtons.forEach(button => {
        button.addEventListener('click', () => {
            event.stopPropagation();
            let modalId = button.getAttribute('data-modal');
            let modal = document.getElementById(modalId);
            modal.showModal();
            
        });
    });

    let closeButtons = document.querySelectorAll('.close-modal');

    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            event.stopPropagation();
            let modalId = button.getAttribute('data-modal');
            let modal = document.getElementById(modalId);

            modal.close();

        });
    });    
}
*/


function validaFormularioModal(valor) {
    
        let anterior = parseInt(document.getElementById(`inputModalAnterior${valor}`).value.replace(/\D/g, ""));
        let recebida = parseInt(document.getElementById(`inputModalRecebida${valor}`).value.replace(/\D/g, ""));
        let impossibilitada = parseInt(document.getElementById(`inputModalImpossibilitada${valor}`).value.replace(/\D/g, ""));
        let digitalizada = parseInt(document.getElementById(`inputModalDigitalizada${valor}`).value.replace(/\D/g, ""));
        let resto = parseInt(document.getElementById(`inputModalResto${valor}`).value.replace(/\D/g, ""));

        let carga = anterior + recebida - impossibilitada - digitalizada - resto;

        console.log("Anterior:", anterior);
        console.log("Recebida:", recebida);
        console.log("Impossibilitada:", impossibilitada);
        console.log("Digitalizada:", digitalizada);
        console.log("Resto:", resto);


        if (document.getElementById(`inputModalData${valor}`).value === ""){
            alert("Por favor, preencha o campo Data.");
            return false; // Formulário inválido

        }
        if (document.getElementById(`inputModalAnterior${valor}`).value === ""){
            alert("Por favor, preencha o campo Carga do dia anterior.");
            return false; // Formulário inválido

        }
        if (document.getElementById(`inputModalRecebida${valor}`).value === "") {
            alert("Por favor, preencha o campo Carga Recebida.");
            return false;
        }
        if (document.getElementById(`inputModalImpossibilitada${valor}`).value === "") {
            alert("Por favor, preencha o campo Carga Impossibilitada.");
            return false;
        }
        if (document.getElementById(`inputModalDigitalizada${valor}`).value === ""){
            alert("Por favor, preencha o campo Carga Digitalizada.");
            return false; // Formulário inválido

        }
        if (document.getElementById(`inputModalResto${valor}`).value === ""){
            alert("Por favor, preencha o campo Resto.");
            return false; // Formulário inválido
        }
        if (carga != 0){
            alert("Preenchimento dos dados está incorreto. Por favor corrigir.");
            return false;
        }else{
            return true; // Formulário inválido
        } 
}

function validaFormulario(){

    let anterior = document.getElementById('inputAnterior');
    anterior.disabled = false;
    let cargaAnterior = parseInt(anterior.value.replace(/\D/g, ""));
    anterior.disabled = true;    
    let recebida = parseInt(document.getElementById('inputRecebida').value.replace(/\D/g, ""));
    let impossibilitada = document.getElementById('inputImpossibilitada').value.replace(/\D/g, "");
    let digitalizada = parseInt(document.getElementById('inputDigitalizada').value.replace(/\D/g, ""));
    let resto = parseInt(document.getElementById('inputResto').value.replace(/\D/g, ""));
    let totalCarga = cargaAnterior + recebida - impossibilitada - digitalizada - resto;
    

    if (document.getElementById('inputData').value === ""){
        alert("Por favor, preencha o campo Data.");
        return false; // Formulário inválido

    }
    if (document.getElementById('inputAnterior').value === ""){
        alert("Por favor, preencha o campo Carga do dia anterior.");
        return false; // Formulário inválido

    }
    if (document.getElementById('inputRecebida').value === "") {
        alert("Por favor, preencha o campo Carga Recebida.");
        return false;
      }
    if (document.getElementById('inputImpossibilitada').value === "") {
        alert("Por favor, preencha o campo Carga Impossibilitada.");
        return false;
    }
    if (document.getElementById('inputDigitalizada').value === ""){
        alert("Por favor, preencha o campo Carga Digitalizada.");
        return false; // Formulário inválido

    }
    if (document.getElementById('inputResto').value === ""){
        alert("Por favor, preencha o campo Resto.");
        return false; // Formulário inválido

    }
    if (totalCarga != 0){
        alert("Preenchimento dos dados está incorreto. Por favor corrigir.");
        return false;
    }else{
		 return true; // Formulário inválido
    }
}



