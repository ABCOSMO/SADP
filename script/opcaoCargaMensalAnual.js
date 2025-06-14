function abrirOpcaoMensal(id) {    
    let botaoClicado = document.getElementById(`botaoCarga-${id}`);
    let perfil = parseInt(document.getElementById('perfil').value);
	let secaoUnidade = document.getElementById('secao_unidade').value;
    
    if (botaoClicado.classList.contains('botao__carga') && id === 1) {
        let botao = document.getElementById('botaoCarga-2');
        botao.classList.add('botao__carga');
        botao.classList.remove('botao__selecionado');
        botaoClicado.classList.remove('botao__carga');
        botaoClicado.classList.add('botao__selecionado');
        let lista = document.getElementById('diaria');
        let relatorio = document.getElementById('dadosContainer');
				
        // Limpa a lista antes de adicionar os itens    
        lista.innerHTML = '';
        relatorio.innerHTML = '';
		let dadosHTML = '';

        fetch('../cadastro/controllerRelatorioUnidade.php')
        .then(response => response.json())
        .then(data => {
				
				if(perfil != "01" && perfil != "05") {
					dadosHTML = `
					<input type="hidden" id="unidade" name="unidade" value='${secaoUnidade}'>`;
				}else{
					dadosHTML = `
						<label for="unidade">Unidade:</label>
						<select class="selecionar" type="checkbox" name="unidade" size="1" id="unidade">
							<option value="" selected disabled="disabled" id="selecionar__unidade"> - Escolher Unidade - </option>`;
		
					let num = 1; // Inicializa a variável num
		
					data.forEach(item => {
						dadosHTML += `<option value="${item.unidade}">${num} - ${item.unidade}</option>`;
						num++;
					});
				}
            dadosHTML += `
                 </select>
                 <label for="dataInicial">Data Inicial:</label>
                 <input class="calendario" type="date" id="dataInicial" name="dataInicial" min="2022-01-01" max="2035-12-31" value="2025-04-25">
                 <label for="dataFinal">Data Final:</label>
                 <input class="calendario" type="date" id="dataFinal" name="dataFinal" min="2022-01-01" max="2035-12-31" value="2025-04-25">
             </div>
             <div class="container__botao_calendario">
                 <input class="botao__diario" value="Gerar Relatório" type="submit" id="login-button">
             </div>`;
            lista.innerHTML = dadosHTML;
            aplicarDataAtual();

            // Adicionando o event listener para o botão de gerar relatório diário
            const botaoGerarRelatorio = document.querySelector('.botao__diario');
            if (botaoGerarRelatorio) {
                botaoGerarRelatorio.addEventListener('click', function(event) {
                    event.preventDefault(); // Evita o comportamento padrão de submit
                    relatorioDiarioDigitalizacao(); // Chama a sua função
                });
            }
        })
    }

    if (botaoClicado.classList.contains('botao__carga') && id === 2) {
        let botao = document.getElementById('botaoCarga-1');
        botao.classList.add('botao__carga');
        botao.classList.remove('botao__selecionado');
        botaoClicado.classList.remove('botao__carga');
        botaoClicado.classList.add('botao__selecionado');
        let lista = document.getElementById('diaria');
        let relatorio = document.getElementById('dadosContainer');
        // Limpa a lista antes de adicionar os itens    
        lista.innerHTML = '';
        relatorio.innerHTML = '';
        let dadosHTML = '';
        fetch('../cadastro/controllerRelatorioUnidade.php')
        .then(response => response.json())
        .then(data => {
            if(perfil != "01" && perfil != "05") {
                dadosHTML = `
                <input type="hidden" id="unidade" name="unidade" value='${secaoUnidade}'>`;
            }else{
                dadosHTML = `
                 <label for="unidade">Unidade:</label>
                 <select class="selecionar" type="checkbox" name="unidade" size="1" id="unidade">
                     <option value="" selected disabled="disabled" id="selecionar__unidade"> - Escolher Unidade - </option>`;
            
                let num = 1; // Inicializa a variável num

                data.forEach(item => {
                    dadosHTML += `<option value="${item.unidade}">${num} - ${item.unidade}</option>`;
                    num++;
                });
            }
                dadosHTML += `
                </select>                   
                    <label for="Ano">Selecionar Ano:</label>
                    <select class="calendario" id="ano" name="ano">
                    <option value="" selected disabled="disabled" id="selecionar__ano"> - Escolher Ano - </option>
                    </select>
                    </div>
                    <div class="container__botao_calendario">
                        <input class="botao__mensal" value="Gerar Relatório" type="submit" id="login-button">
                    </div>`;

            lista.innerHTML = dadosHTML;
            const selectAno = document.getElementById('ano');
            if (selectAno) {
                for (let ano = 2022; ano <= 2035; ano++) {
                const option = document.createElement('option');
                option.value = ano;
                option.textContent = ano;
                selectAno.appendChild(option);
                }
            }
			// Adicionando o event listener para o botão de gerar relatório mensal
            const botaoGerarRelatorio = document.querySelector('.botao__mensal');
            if (botaoGerarRelatorio) {
                botaoGerarRelatorio.addEventListener('click', function(event) {
                    event.preventDefault(); // Evita o comportamento padrão de submit
                    relatorioMensalDigitalizacao(); // Chama a sua função
                });
            }
        })
    }    
}