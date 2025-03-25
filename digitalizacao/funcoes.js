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

function relatorioDigitalizacao() {
    let id = 1;
    let resultado = document.getElementById('dadosContainer'); // Obtém a referência uma vez
    resultado.innerHTML = ''; // Limpa o conteúdo existente
    fetch('../cadastro/controllerCargaDigitalizacao.php') 
    .then(response => response.json())
      .then(data => {
          // Aqui você pode trabalhar com os dados JSON recebidos
          //console.log(data);
          // Exibir os dados na tela, etc.
          
          data.forEach(item => {
              //console.log(item.data_digitalizacao);
              //console.log(item.imagens_anterior);
              resultado.innerHTML += 
                        `<section class="modal-body">
                            <div class="input-group">
                                <input type="text" id="inputData${id}" name="novaData" 
                                value=${item.data_digitalizacao} maxlength="10" disabled>
                            </div>
                            <div class="input-group">
                                <input type="text" id="inputAnterior${id}" name="cargaAnterior" 
                                value=${mascaraDigitarCarga(item.imagens_anterior.toString())} maxlength="7" disabled>
                            </div>
                            <div class="input-group">
                                <input type="text" id="inputRecebida${id}" name="cargaRecebida" 
                                value=${mascaraDigitarCarga(item.imagens_recebidas.toString())} maxlength="7" disabled>
                            </div>
                            <div class="input-group">
                                <input type="text" id="inputImpossibilitada${id}" name="cargaImpossibilitada" 
                                value=${mascaraDigitarCarga(item.imagens_impossibilitadas.toString())} maxlength="7" disabled>
                            </div>
                            <div class="input-group">
                                <input type="text" id="inputDigitalizada${id}" name="cargaDigitalizada" 
                                value=${mascaraDigitarCarga(item.imagens_incorporadas.toString())} maxlength="7" disabled>
                            </div>
                            <div class="input-group">
                                <input type="text" id="inputResto${id}" name="cargaResto" 
                                value=${mascaraDigitarCarga(item.resto.toString())} maxlength="7" disabled>
                            </div>
                            <div class="input-group">
                                <button type="button" class='open-modal botao__alterar_excluir' data-modal="modal-${id}" id="login-button-cadastro">
                                <i class='fa-solid fa-pencil'></i></button>
                            </div>
                        </section>
                             <dialog class="manter__aberto" id="modal-${id}">
                                <div class="menuAlterar" id="modal-1">
                                    <form method="post" id="myForm${id}" name="autenticar" >
                                        <div class="modal-header">
                                            <h1 class="modal-title">
                                                Alterar dados da digitalização
                                            </h1>
                                            <button class="close-modal" data-modal="modal-${id}" type="button">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                        <section class="modal-body">
                                            <div class="input-group">
                                                <label for="data">
                                                    Data
                                                </label>
                                                <input type="text" class="modal__digitalizacao" id="inputData${id}" name="novaData" 
                                                value=${item.data_digitalizacao} maxlength="10">
                                            </div>
                                            <div class="input-group">
                                                <label for="cargaAnterior">
                                                    Carga dia anterior
                                                </label>
                                                <input type="text" class="modal__digitalizacao" id="inputAnterior${id}" name="cargaAnterior" 
                                                value=${mascaraDigitarCarga(item.imagens_anterior.toString())} maxlength="7">
                                            </div>
                                            <div class="input-group">
                                                <label for="cargaRecebida">
                                                    Carga recebida
                                                </label>
                                                <input type="text" class="modal__digitalizacao" id="inputRecebida${id}" name="cargaRecebida" 
                                                value=${mascaraDigitarCarga(item.imagens_recebidas.toString())} maxlength="7">
                                            </div>
                                            <div class="input-group">
                                                <label for="cargaImpossibilitada">
                                                    Carga impossibilitada
                                                </label>
                                                <input type="text" class="modal__digitalizacao" id="inputImpossibilitada${id}" name="cargaImpossibilitada" 
                                                value=${mascaraDigitarCarga(item.imagens_impossibilitadas.toString())} maxlength="7">
                                            </div>
                                            <div class="input-group">
                                                <label for="CargaDigitalizada">
                                                    Carga digitalizada
                                                </label>
                                                <input type="text" class="modal__digitalizacao" id="inputDigitalizada${id}" name="cargaDigitalizada" 
                                                value=${mascaraDigitarCarga(item.imagens_incorporadas.toString())} maxlength="7">
                                            </div>
                                            <div class="input-group">
                                                <label for="resto">
                                                    Resto do dia
                                                </label>
                                                <input type="text" class="modal__digitalizacao" id="inputResto${id}" name="cargaResto" 
                                                value=${mascaraDigitarCarga(item.resto.toString())} maxlength="7">
                                            </div>
                                        </section>
                                        <section class="modal-body">
                                            <div class="container__cadastro__envio">
                                                <input value="Alterar dados" type="submit" id="login-button"></input>
                                            </div>
                                        </section>
                                    </form>
                                </div>        
                            </dialog>`;
                id++;               
          });
          adicionarListenersModal();          
      })
      .catch(error => {
          console.error('Erro:', error);
      });     
}

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

function validaFormularioModal(valor) {
     

        let anterior = parseInt(document.getElementById(`inputAnterior${valor}`).value.replace(/\D/g, ""));
        let recebida = parseInt(document.getElementById(`inputRecebida${valor}`).value.replace(/\D/g, ""));
        let impossibilitada = parseInt(document.getElementById(`inputImpossibilitada${valor}`).value.replace(/\D/g, ""));
        let digitalizada = parseInt(document.getElementById(`inputDigitalizada${valor}`).value.replace(/\D/g, ""));
        let resto = parseInt(document.getElementById(`inputResto${valor}`).value.replace(/\D/g, ""));

        let carga = anterior + recebida - impossibilitada - digitalizada - resto;

        console.log("Anterior:", anterior);
        console.log("Recebida:", recebida);
        console.log("Impossibilitada:", impossibilitada);
        console.log("Digitalizada:", digitalizada);
        console.log("Resto:", resto);


        if (document.getElementById(`inputData${valor}`).value === ""){
            alert("Por favor, preencha o campo Data.");
            return false; // Formulário inválido

        }
        if (document.getElementById(`inputAnterior${valor}`).value === ""){
            alert("Por favor, preencha o campo Carga do dia anterior.");
            return false; // Formulário inválido

        }
        if (document.getElementById(`inputRecebida${valor}`).value === "") {
            alert("Por favor, preencha o campo Carga Recebida.");
            return false;
        }
        if (document.getElementById(`inputImpossibilitada${valor}`).value === "") {
            alert("Por favor, preencha o campo Carga Impossibilitada.");
            return false;
        }
        if (document.getElementById(`inputDigitalizada${valor}`).value === ""){
            alert("Por favor, preencha o campo Carga Digitalizada.");
            return false; // Formulário inválido

        }
        if (document.getElementById(`inputResto${valor}`).value === ""){
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

    let anterior = document.getElementById('inputAnterior').value.replace(/\D/g, "");
    let recebida = document.getElementById('inputRecebida').value.replace(/\D/g, "");
    let impossibilitada = document.getElementById('inputImpossibilitada').value.replace(/\D/g, "");
    let digitalizada = document.getElementById('inputDigitalizada').value.replace(/\D/g, "");
    let resto = document.getElementById('inputResto').value.replace(/\D/g, "");
    let totalCarga = anterior + recebida - impossibilitada - digitalizada - resto;
    

    if (totalCarga != 0){
        alert("Preenchimento dos dados está incorreto. Por favor corrigir.");
        return false;
    }

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
    }else{
		 return true; // Formulário inválido
    }
}

