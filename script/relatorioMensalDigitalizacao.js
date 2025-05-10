function relatorioMensalDigitalizacao() {
    const unidade = document.getElementById('unidade').value;
    const ano = document.getElementById('ano').value;
    let id = 2;
    let resultado = document.getElementById('dadosContainer');
    resultado.innerHTML = ''; // Limpa o conteúdo existente
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
            data.forEach(item => {
                tabelaHTML += `<tr class=''>
                                    <td class='' id='unidade${id}'>${item.unidade}</td>
                                    <td class='' id='Mês${id}'>${item.data_mes} - ${item.data_ano}</td>
                                    <td class='' id='Anterior${id}'>${mascaraDigitarCarga(item.imagens_anterior.toString())}</td>
                                    <td class='' id='Recebida${id}'>${mascaraDigitarCarga(item.imagens_recebidas.toString())}</td>
                                    <td class='' id='Impossibilitada${id}'>${mascaraDigitarCarga(item.imagens_impossibilitadas.toString())}</td>
                                    <td class='' id='Digitalizada${id}'>${mascaraDigitarCarga(item.imagens_incorporadas.toString())}</td>
                                    <td class='' id='Resto${id}'>${mascaraDigitarCarga(item.resto.toString())}</td>
                                </tr>`;
                id++;
            });

            if (unidade !== "") {
                return fetch('../cadastro/controllerTotalCargaDigitalizacao.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        unidade: unidade,
                        ano: ano
                    })
                })
                .then(responseTotal => responseTotal.json())
                .then(totalData => {
                    let tabelaTotalHTML = '';
                    if (Array.isArray(totalData) && totalData.length > 0) {
                        const total = totalData[0];
                        tabelaTotalHTML = `<tr class='total-row'>
                                                <td class='total-cell' id='unidadeTotal'>${total.unidade}</td>
                                                <td class='total-cell' id='MêsTotal'>Total</td>
                                                <td class='total-cell' id='AnteriorTotal'>${mascaraDigitarCarga(total.imagens_anterior.toString())}</td>
                                                <td class='total-cell' id='RecebidaTotal'>${mascaraDigitarCarga(total.imagens_recebidas.toString())}</td>
                                                <td class='total-cell' id='ImpossibilitadaTotal'>${mascaraDigitarCarga(total.imagens_impossibilitadas.toString())}</td>
                                                <td class='total-cell' id='DigitalizadaTotal'>${mascaraDigitarCarga(total.imagens_incorporadas.toString())}</td>
                                                <td class='total-cell' id='RestoTotal'>${mascaraDigitarCarga(total.resto.toString())}</td>
                                            </tr>`;
                    }
                    tabelaHTML += tabelaTotalHTML;
                    tabelaHTML += `</table></div></section>`;
                    resultado.innerHTML = tabelaHTML;

                    adicionarListenersModal();
                    digitarFormularioModal();
                    alterarDadosDigitalizacao(data);
                })
                .catch(errorTotal => {
                    console.error('Erro ao buscar total da carga:', errorTotal);
                    tabelaHTML += `</table></div></section>`;
                    resultado.innerHTML = tabelaHTML;
                    adicionarListenersModal();
                    digitarFormularioModal();
                    alterarDadosDigitalizacao(data);
                });
            } else {
                tabelaHTML += `</table></div></section>`;
                resultado.innerHTML = tabelaHTML;
                adicionarListenersModal();
                digitarFormularioModal();
                alterarDadosDigitalizacao(data);
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
}