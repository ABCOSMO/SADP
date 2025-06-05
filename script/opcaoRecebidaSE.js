document.addEventListener('DOMContentLoaded', function() {
    carregarDadosAutomaticamente(); // Chama a função que faz o fetch
});

function carregarDadosAutomaticamente() {
	let perfil = document.getElementById('perfil').value; // Remove parseInt se for string
	let secaoUnidade = document.getElementById('secao_unidade').value;
	let lista = document.getElementById('diaria');
	
	// Limpa a lista antes de adicionar os itens    
	lista.innerHTML = '';
	let dadosHTML = '';
	
	fetch('../cadastro/controllerRelatorioUnidade.php')
		.then(response => response.json())
		.then(data => {
			if(perfil !== "01" && perfil !== "05") {
				dadosHTML = `
				<input type="hidden" id="unidade" name="unidade" value='${secaoUnidade}'>
				`;
			} else {
				dadosHTML = `
					<label for="unidade">Unidade:</label>
					<select class="selecionar" type="checkbox" name="unidade" size="1" id="unidade">
						<option value="" selected disabled="disabled" id="selecionar__unidade"> - Escolher Unidade - </option>`;
	
				let num = 1;
				data.forEach(item => {
					dadosHTML += `<option value="${item.unidade}">${num} - ${item.unidade}</option>`;
					num++;
				});
				
				dadosHTML += `</select>`; // Fecha o select AQUI dentro do else
			}
			
			// Restante do HTML (comum a ambos os casos)
			dadosHTML += `
				<label for="dataInicial">Data Inicial:</label>
				<input class="calendario" type="date" id="dataInicial" name="dataInicial" min="2022-01-01" max="2035-12-31" value="2025-04-25">
				<label for="dataFinal">Data Final:</label>
				<input class="calendario" type="date" id="dataFinal" name="dataFinal" min="2022-01-01" max="2035-12-31" value="2025-04-25">
				<div class="container__botao_calendario">
					<input class="botao__diario" value="Gerar Relatório" type="submit" id="login-button">
				</div>`;
			
			lista.innerHTML = dadosHTML;
			aplicarDataAtual();
	
			const botaoGerarRelatorio = document.querySelector('.botao__diario');
			if (botaoGerarRelatorio) {
				botaoGerarRelatorio.addEventListener('click', function(event) {
					event.preventDefault();
					relatorioDiarioSE();
				});
			}
		})
		.catch(error => console.error('Erro ao carregar unidades:', error)); // Adicione tratamento de erro
}