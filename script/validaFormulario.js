function validaFormularioModal(valor) {
    
        let anterior = parseInt(document.getElementById(`inputModalAnterior${valor}`).value.replace(/\D/g, ""));
        let recebida = parseInt(document.getElementById(`inputModalRecebida${valor}`).value.replace(/\D/g, ""));
        let impossibilitada = parseInt(document.getElementById(`inputModalImpossibilitada${valor}`).value.replace(/\D/g, ""));
        let digitalizada = parseInt(document.getElementById(`inputModalDigitalizada${valor}`).value.replace(/\D/g, ""));
        let resto = parseInt(document.getElementById(`inputModalResto${valor}`).value.replace(/\D/g, ""));

        let carga = anterior + recebida - impossibilitada - digitalizada - resto;


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



