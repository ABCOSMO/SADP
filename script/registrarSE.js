let ocorrencia = document.getElementById('ocorrencia');
ocorrencia.focus();

for(let i = 1; i <= 28; i++){

	let selecionarSE = document.getElementById(`se-${i}`);	
	
	if(selecionarSE){
		selecionarSE.addEventListener('click', function(){
			if(selecionarSE.classList.contains('estados')){
				selecionarSE.classList.remove('estados');
				selecionarSE.classList.add('estado__alterado');
				selecionarSE.value = "Recebido";
			}else{
				selecionarSE.classList.remove('estado__alterado');
				selecionarSE.classList.add('estados');
				selecionarSE.value = "Pendente";
			}
		});
	}

}
