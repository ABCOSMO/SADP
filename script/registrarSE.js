let ocorrencia = document.getElementById('ocorrencia');
ocorrencia.focus();

for(let i = 1; i <= 28; i++){
    let selecionarSE = document.getElementById(`se-${i}`);

    if(selecionarSE){
        selecionarSE.addEventListener('click', function(){
            if(selecionarSE.classList.contains('Estado__nao_recebida')){
                selecionarSE.classList.remove('Estado__nao_recebida');
                selecionarSE.classList.add('Estado__recebida');
                selecionarSE.textContent = "Recebida"; // ALTERADO AQUI
            }else{
                selecionarSE.classList.remove('Estado__recebida');
                selecionarSE.classList.add('Estado__nao_recebida');
                selecionarSE.textContent = "Não recebida"; // ALTERADO AQUI
            }
        });
    }
}

let contarSEModal = document.querySelectorAll('.contar__modal_se');

for(let i = 2; i <= contarSEModal.length; i++) {

}