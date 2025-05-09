function relatorioDiarioDigitalizacao() {
    const unidade = document.getElementById('unidade').value;
    const dataInicial = document.getElementById('dataInicial').value;
    const dataFinal = document.getElementById('dataFinal').value;
    let id = 2;
    let resultado = document.getElementById('dadosContainer');
    resultado.innerHTML = ''; // Limpa o conteúdo existente
    let usuarioPerfil; // Variável para armazenar o perfil do usuário

    fetch('../cadastro/controllerCargaDiariaDigitalizacao.php', {
        method: 'POST',
        body: JSON.stringify({
            unidade: unidade,
            dataInicial: dataInicial,
            dataFinal: dataFinal
        })
    })
        .then(response => {
            return response.json(); // Converter a resposta para JSON
        })
        .then(data => {
            if (data.length > 0) {
                usuarioPerfil = data[0].perfil; // Assumindo que o perfil está no primeiro item
            } else {
                usuarioPerfil = null; // Caso a resposta esteja vazia
            }

            let tabelaHTML = `<section class="modal-body">
                                    <div class="input-group">
                                        <table>
                                            <tr>
                                                <th class='usuario'>Unidade</th>
                                                <th class='usuario'>Matrícula</th>
                                                <th class='usuario'>Usuário</th>
                                                <th class='usuario'>Data</th>
                                                <th class='usuario'>Carga dia anterior</th>
                                                <th class='usuario'>Carga Recebida</th>
                                                <th class='usuario'>Carga impossibilitada</th>
                                                <th class='usuario'>Carga Digitalizada</th>
                                                <th class='usuario'>Resto do dia</th>
                                                ${usuarioPerfil == '01' ? `
                                                    <th id='colunaAlterar' class='usuario'>Alterar</th>
                                                    <th id='colunaExcluir' class='usuario'>Excluir</th>
                                                ` : ''}
                                            </tr>`;


            data.forEach(item => {

                let perfil = parseInt(item.perfil); // Mantendo isso caso você use para outra lógica
                tabelaHTML += `<tr class=''>
                                        <td class='' id='unidade${id}'>${item.unidade}</td>
                                        <td class='' id='matricula${id}'>${item.matricula_usuario}</td>
                                        <td class='' id='usuario${id}'>${item.nome_usuario}</td>
                                        <td class='' id='Data${id}'>${item.data_digitalizacao}</td>
                                        <td class='' id='Anterior${id}'>${mascaraDigitarCarga(item.imagens_anterior.toString())}</td>
                                        <td class='' id='Recebida${id}'>${mascaraDigitarCarga(item.imagens_recebidas.toString())}</td>
                                        <td class='' id='Impossibilitada${id}'>${mascaraDigitarCarga(item.imagens_impossibilitadas.toString())}</td>
                                        <td class='' id='Digitalizada${id}'>${mascaraDigitarCarga(item.imagens_incorporadas.toString())}</td>
                                        <td class='' id='Resto${id}'>${mascaraDigitarCarga(item.resto.toString())}</td>
                                        ${usuarioPerfil == '01' ? `
                                            <td>
                                                <button type="button" class='open-modal botao__alterar_excluir' data-modal="modal-${id}"
                                                        id="login-cadastro"><i class='fa-solid fa-pencil'></i>
                                                </button>
                                            </td>
                                            <td>
                                                <button class='botao botao__excluir${id} botao__alterar_excluir'>
                                                    <i class='fa-solid fa-trash'></i>
                                                </button>
                                            </td>
                                        ` : ''}
                                    </tr>`;
                id++;
            });

            tabelaHTML += `</table></div></section>`;
            resultado.innerHTML = tabelaHTML;

            let modalHTML = ''; // Declaração correta da variável
            id = 2; // Reset do ID para manter consistência

            data.forEach(item => {
                modalHTML += `<dialog class="manter__aberto" id="modal-${id}">
                                        <div class="menuAlterar" id="modal-${id}">
                                            <form method="post" id="myForm${id}" name="autenticar">
                                                <div class="modal-header">
                                                    <h1 class="modal-title">Alterar dados da digitalização</h1>
                                                    <button class="close-modal" data-modal="modal-${id}" type="button">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </div>
                                                <section class="modal-body">
                                                    <div class="input-group">
                                                        <label for="data">Data</label>
                                                        <input type="text" class="modal__digitalizacao" id="inputModalData${id}"
                                                               name="novaData" value="${item.data_digitalizacao}" maxlength="10" disabled>
                                                    </div>
                                                    <div class="input-group">
                                                        <label for="cargaAnterior">Carga dia anterior</label>
                                                        <input type="text" class="modal__digitalizacao" id="inputModalAnterior${id}"
                                                               name="cargaAnterior" value="${mascaraDigitarCarga(item.imagens_anterior.toString())}"
                                                               maxlength="7">
                                                    </div>
                                                    <div class="input-group">
                                                        <label for="cargaRecebida">Carga recebida</label>
                                                        <input type="text" class="modal__digitalizacao" id="inputModalRecebida${id}"
                                                               name="cargaRecebida" value="${mascaraDigitarCarga(item.imagens_recebidas.toString())}"
                                                               maxlength="7">
                                                    </div>
                                                    <div class="input-group">
                                                        <label for="cargaImpossibilitada">Carga impossibilitada</label>
                                                        <input type="text" class="modal__digitalizacao" id="inputModalImpossibilitada${id}"
                                                               name="cargaImpossibilitada"
                                                               value="${mascaraDigitarCarga(item.imagens_impossibilitadas.toString())}" maxlength="7">
                                                    </div>
                                                    <div class="input-group">
                                                        <label for="CargaDigitalizada">Carga digitalizada</label>
                                                        <input type="text" class="modal__digitalizacao" id="inputModalDigitalizada${id}"
                                                               name="cargaDigitalizada"
                                                               value="${mascaraDigitarCarga(item.imagens_incorporadas.toString())}" maxlength="7">
                                                    </div>
                                                    <div class="input-group">
                                                        <label for="resto">Resto do dia</label>
                                                        <input type="text" class="modal__digitalizacao" id="inputModalResto${id}"
                                                               name="cargaResto" value="${mascaraDigitarCarga(item.resto.toString())}" maxlength="7">
                                                    </div>
                                                </section>
                                                    <div class="container__botao_alterar_dados">
                                                        <input value="Alterar dados" type="submit" id="login-button"></input>
                                                    </div>
                                            </form>
                                        </div>
                                    </dialog>`;
                id++;
            });

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