function relatorioMensalDigitalizacao() {
    const unidade = document.getElementById('unidade').value;
    const ano = document.getElementById('ano').value;
    let id = 2;
    let resultado = document.getElementById('dadosContainer');
    resultado.innerHTML = ''; // Limpa o conteúdo existente

    fetch('../cadastro/controllerCargaMensalDigitalizacao.php', {
        method: 'POST',
        body: JSON.stringify({ 
            unidade: unidade, 
            ano: ano
        })
    })
        .then(response => {
            return response.json(); // Converter a resposta para JSON
        })
        .then(data => {
            let tabelaHTML = `<section class="modal-body">
                                    <div class="input-group">
                                        <table>
                                            <tr>
                                                <th class='usuario'>Unidade</th>
                                                <th class='usuario'>Mês</th>
                                                <th class='usuario'>Carga dia anterior</th>
                                                <th class='usuario'>Carga Recebida</th>
                                                <th class='usuario'>Carga impossibilitada</th>
                                                <th class='usuario'>Carga Digitalizada</th>
                                                <th class='usuario'>Resto do dia</th>
                                            </tr>`;

        
            data.forEach(item => {
                tabelaHTML += `<tr class=''>
										<td class='' id='unidade${id}'>${item.unidade}</td>
                                        <td class='' id='Mês${id}'>${item.data_digitalizacao}</td>
                                        <td class='' id='Anterior${id}'>${mascaraDigitarCarga(item.imagens_anterior.toString())}</td>
                                        <td class='' id='Recebida${id}'>${mascaraDigitarCarga(item.imagens_recebidas.toString())}</td>
                                        <td class='' id='Impossibilitada${id}'>${mascaraDigitarCarga(item.imagens_impossibilitadas.toString())}</td>
                                        <td class='' id='Digitalizada${id}'>${mascaraDigitarCarga(item.imagens_incorporadas.toString())}</td>
                                        <td class='' id='Resto${id}'>${mascaraDigitarCarga(item.resto.toString())}</td>
                                    <td>
                                        <button type="button" class='open-modal botao__alterar_excluir' data-modal="modal-${id}" 
                                            id="login-cadastro"><i class='fa-solid fa-pencil'></i>
                                        </button>
                                    </td>
                                </tr>`;
                id++;
            });
         
            tabelaHTML += `</table></div></section>`;
            resultado.innerHTML = tabelaHTML;

            resultado.innerHTML += modalHTML;
            adicionarListenersModal();
			digitarFormularioModal();
            excluirCargaDigitalizacao();
			alterarDadosDigitalizacao(data);
			
        })
        .catch(error => {
            console.error('Erro:', error);
        });
}