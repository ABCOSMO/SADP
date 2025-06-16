// Adicione esta lista de SEs no topo do seu arquivo JS, fora de qualquer função
const todasAsSes = [
    { numero: "00003", nome: "AC" },
    { numero: "00004", nome: "AL" },
    { numero: "00005", nome: "AP" },
    { numero: "00006", nome: "AM" },
    { numero: "00008", nome: "BA" },
    { numero: "00012", nome: "CE" },
    { numero: "00010", nome: "BSB" }, // DF
    { numero: "00012", nome: "ES" },
    { numero: "00016", nome: "GO" },
    { numero: "00018", nome: "MA" },
    { numero: "00024", nome: "MT" },
    { numero: "00022", nome: "MS" },
    { numero: "00020", nome: "MG" },
    { numero: "00028", nome: "PA" },
    { numero: "00030", nome: "PB" },
    { numero: "00036", nome: "PR" },
    { numero: "00032", nome: "PE" },
    { numero: "00034", nome: "PI" },
    { numero: "00050", nome: "RJ" },
    { numero: "00060", nome: "RN" },
    { numero: "00064", nome: "RS" },
    { numero: "00026", nome: "RO" },
    { numero: "00065", nome: "RR" },
    { numero: "00068", nome: "SC" },
    { numero: "00074", nome: "SPI" }, // SP interior
    { numero: "00072", nome: "SPM" }, // SP metropolitana
    { numero: "00070", nome: "SE" },
    { numero: "00075", nome: "TO" },
];

function nomeSE(numero) {
    const seEncontrada = todasAsSes.find(se => se.numero === numero);
    return seEncontrada ? seEncontrada.nome : numero;
}

// Variável para armazenar os dados originais do backend
let dadosDigitalizacaoOriginais = [];

function relatorioDigitalizacao() {
    let resultado = document.getElementById('dadosContainer');
    resultado.innerHTML = ''; // Limpa o conteúdo existente

    fetch('../cadastro/controllerCargaDigitalizacao.php')
        .then(response => response.json())
        .then(data => {
            dadosDigitalizacaoOriginais = data.digitalizacoes || []; // Armazena os dados originais
            const sesRecebidas = data.ses_recebidas || [];
            const ocorrencias = data.ocorrencias || [];
            const usuarioPerfil = data.perfil_usuario;

            let inputBuscarCdipHTML = '';
            if (usuarioPerfil === "01") {
                inputBuscarCdipHTML =
                    `<section class="modal-body">
                        <div class="input-group">
                            <label for="data">Pesquisar Data</label>
                            <input type="text" class="modal__digitalizacao" id="inputBuscarCdip"
                                name="buscarCdip" value="" maxlength="10" placeholder="DD/MM/AAAA">
                        </div>
                    </section>`;
            }

            // Renderiza a tabela com todos os dados inicialmente
            renderizarTabela(dadosDigitalizacaoOriginais, sesRecebidas, ocorrencias, usuarioPerfil, resultado, inputBuscarCdipHTML);

            const inputBuscarCdip = document.getElementById('inputBuscarCdip');
            if (inputBuscarCdip) {
                // Adiciona a máscara de data ao input de pesquisa
                inputBuscarCdip.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito
                    if (value.length > 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2);
                    }
                    if (value.length > 5) {
                        value = value.substring(0, 5) + '/' + value.substring(5, 9); // Limita a 4 dígitos para o ano
                    }
                    e.target.value = value;

                    // Chama a função de filtro com o valor formatado e os dados originais
                    filtrarTabela(value, dadosDigitalizacaoOriginais, sesRecebidas, ocorrencias, usuarioPerfil);
                });
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
}

// Nova função para renderizar a tabela, que pode ser chamada para filtrar
function renderizarTabela(digitalizacoesParaExibir, sesRecebidas, ocorrencias, usuarioPerfil, resultadoContainer, inputHtml) {
    let tabelaHTML = '';
    tabelaHTML += inputHtml; // Adiciona o input de busca (se existir)

    tabelaHTML += `<section class="modal-body">
                            <div class="input-group">
                                <table>
                                    <thead>
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
                                            <th class='usuario'>Alterar Carga</th>
                                            <th class='usuario'>Alterar SE</th>
                                            ${usuarioPerfil === '01' ? `<th id='colunaExcluir' class='usuario'>Excluir</th>` : ''}
                                        </tr>
                                    </thead>
                                    <tbody>`;

    let idCounter = 2; // Mantém o contador para IDs únicos
    digitalizacoesParaExibir.forEach(item => {
        tabelaHTML += `<tr class='item-tabela' id='linha-${idCounter}'>
                            <td class='unidade' id='unidade${idCounter}'>${item.unidade}</td>
                            <td class='' id='matricula${idCounter}'>${item.matricula_usuario}</td>
                            <td class='' id='usuario${idCounter}'>${item.nome_usuario}</td>
                            <td class='' id='Data${idCounter}'>${item.data_digitalizacao}</td>
                            <td class='' id='Anterior${idCounter}'>${mascaraDigitarCarga(item.imagens_anterior.toString())}</td>
                            <td class='' id='Recebida${idCounter}'>${mascaraDigitarCarga(item.imagens_recebidas.toString())}</td>
                            <td class='' id='Impossibilitada${idCounter}'>${mascaraDigitarCarga(item.imagens_impossibilitadas.toString())}</td>
                            <td class='' id='Digitalizada${idCounter}'>${mascaraDigitarCarga(item.imagens_incorporadas.toString())}</td>
                            <td class='' id='Resto${idCounter}'>${mascaraDigitarCarga(item.resto.toString())}</td>
                            <td>
                                <button type="button" class='open-modal botao__alterar_excluir' data-modal="modal-${idCounter}"
                                    id="btn-alterar-digitalizacao-${idCounter}"><i class='fa-solid fa-pencil'></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class='open-modal botao__alterar_excluir' data-modal="modals-${idCounter}"
                                    id="btn-alterar-se-${idCounter}"><i class='fa-solid fa-pencil'></i>
                                </button>
                            </td>
                            ${usuarioPerfil === '01' ? `
                                <td>
                                    <button class='botao__excluir botao__alterar_excluir' id="btn-excluir-${idCounter}" data-matricula="${item.matricula_usuario}" data-data="${item.data_digitalizacao}">
                                        <i class='fa-solid fa-trash'></i>
                                    </button>
                                </td>
                            ` : ''}
                        </tr>`;
        idCounter++;
    });

    tabelaHTML += `</tbody></table></div></section>`;
    
    // Limpa o conteúdo existente antes de adicionar o novo
    resultadoContainer.innerHTML = tabelaHTML;

    // Adiciona os modais
    let modalHTML = '';
    idCounter = 2; // Reseta o contador para os modais, ou use um novo esquema de IDs se preferir
    digitalizacoesParaExibir.forEach(item => {
        modalHTML += `<dialog class="manter__aberto" id="modal-${idCounter}">
                                <div class="menuAlterar">
                                    <form method="post" id="myForm${idCounter}" name="autenticar">
                                        <div class="modal-header">
                                            <h1 class="modal-title">Alterar dados da digitalização</h1>
                                            <button class="close-modal" data-modal="modal-${idCounter}" type="button">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                        <section class="modal-body">
                                            <div class="input-group">
                                                <label for="data">Data</label>
                                                <input type="text" class="modal__digitalizacao" id="inputModalData${idCounter}"
                                                    name="novaData" value="${item.data_digitalizacao}" maxlength="10" disabled>
                                                <input type="hidden" class="modal__digitalizacao" id="inputModalUnidade${idCounter}"
                                                    name="unidade" value="${item.unidade}" maxlength="10" disabled>
                                            </div>
                                            <div class="input-group">
                                                <label for="cargaAnterior">Carga dia anterior</label>
                                                <input type="text" class="modal__digitalizacao" id="inputModalAnterior${idCounter}"
                                                    name="cargaAnterior" value="${mascaraDigitarCarga(item.imagens_anterior.toString())}"
                                                    maxlength="7">
                                            </div>
                                            <div class="input-group">
                                                <label for="cargaRecebida">Carga recebida</label>
                                                <input type="text" class="modal__digitalizacao" id="inputModalRecebida${idCounter}"
                                                    name="cargaRecebida" value="${mascaraDigitarCarga(item.imagens_recebidas.toString())}"
                                                    maxlength="7">
                                            </div>
                                            <div class="input-group">
                                                <label for="cargaImpossibilitada">Carga impossibilitada</label>
                                                <input type="text" class="modal__digitalizacao" id="inputModalImpossibilitada${idCounter}"
                                                    name="cargaImpossibilitada"
                                                    value="${mascaraDigitarCarga(item.imagens_impossibilitadas.toString())}" maxlength="7">
                                            </div>
                                            <div class="input-group">
                                                <label for="CargaDigitalizada">Carga digitalizada</label>
                                                <input type="text" class="modal__digitalizacao" id="inputModalDigitalizada${idCounter}"
                                                    name="cargaDigitalizada"
                                                    value="${mascaraDigitarCarga(item.imagens_incorporadas.toString())}" maxlength="7">
                                            </div>
                                            <div class="input-group">
                                                <label for="resto">Resto do dia</label>
                                                <input type="text" class="modal__digitalizacao" id="inputModalResto${idCounter}"
                                                    name="cargaResto" value="${mascaraDigitarCarga(item.resto.toString())}" maxlength="7">
                                            </div>
                                        </section>
                                        <section class="modal-body">
                                            <div class="container__cadastro__envio">
                                                <input value="Alterar dados" type="submit" id="login-button-${idCounter}-alterar"></input>
                                            </div>
                                        </section>
                                    </form>
                                </div>
                        </dialog>`;

        const ocorrenciaParaEstaData = ocorrencias.find(
            ocorrencia => ocorrencia.data_recebimento_ocorrencia === item.data_digitalizacao &&
                            ocorrencia.mcu_unidade === item.mcu_unidade_codigo // Adicione esta condição
        );
        const textoOcorrencia = ocorrenciaParaEstaData ? ocorrenciaParaEstaData.ocorrencia : '';

        modalHTML += `
                        <dialog class="manter__aberto contar__modal_se" id="modals-${idCounter}">
                            <div class="modal-header">
                                <p class="modal-title titulo">Carga recebida por Superintendência</p>
                                <button class="close-modal" data-modal="modals-${idCounter}" type="button">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <section class="container__se">
                                ${todasAsSes.map(seCompleta => {
                                    const seRecebidaNaData = sesRecebidas.find(
                                        seRecebida => seRecebida.se_recebida === seCompleta.numero &&
                                                      seRecebida.data_recebimento === item.data_digitalizacao &&
                                                      seRecebida.mcu_unidade === item.mcu_unidade_codigo
                                    );

                                    const valorInput = seRecebidaNaData ? "Recebida" : "";
                                    const classeEstado = seRecebidaNaData ? "estado__recebida" : "estado__nao_recebida";

                                    return `
                                        <div class="coluna__se">
                                            <label class="caixa" for="se-${seCompleta.numero}-${idCounter}">
                                                ${seCompleta.nome}
                                            </label>
                                            <input class="estados ${classeEstado}"
                                                    type="button"
                                                    id="se-${seCompleta.numero}-${idCounter}"
                                                    data-se-numero="${seCompleta.numero}"
                                                    data-id-counter="${idCounter}"
                                                    data-data-digitalizacao="${item.data_digitalizacao}"
                                                    data-mcu-unidade="${item.mcu_unidade_codigo}"
                                                    value="${valorInput}">
                                        </div>
                                        `;
                                }).join('')}
                            </section>
                            <section class="container__ocorrencias">
                                <div class="coluna__ocorrencias">
                                    <label class="areatexto" for="ocorrencia-${idCounter}">
                                        Registrar Ocorrências
                                    </label>
                                    <textarea class="ocorrencias" id="ocorrencia-${idCounter}" name="ocorrencia"
                                    placeholder="Escreva a ocorrência aqui..." autofocus>${textoOcorrencia}</textarea> </div>
                            </section>
                            <section class="modal-body">
                                <div class="container__cadastro__envio">
                                    <button type="button" value="Salvar Alterações SEs" id="btn-salvar-ses-${idCounter}">Salvar Alterações SEs</button>
                                </div>
                            </section>
                        </dialog>`;
        idCounter++;
    });

    resultadoContainer.innerHTML += modalHTML;
    adicionarListenersModal();
    adicionarListenersBotoesSe();
    // Chame a função para adicionar listeners aos botões de exclusão
    adicionarListenersExcluir(); 
}


// ---
// FUNÇÃO PARA FILTRAR A TABELA POR DATA
// ---
function filtrarTabela(termoPesquisa, dadosOriginais, sesRecebidas, ocorrencias, usuarioPerfil) {
    const termoFormatado = termoPesquisa.toLowerCase().trim();

    // Filtra os dados originais com base no termo de pesquisa
    const dadosFiltrados = dadosOriginais.filter(item => {
        // Assume que item.data_digitalizacao já está no formato DD/MM/AAAA
        return item.data_digitalizacao.toLowerCase().includes(termoFormatado);
    });

    // Re-renderiza a tabela com os dados filtrados
    const resultadoContainer = document.getElementById('dadosContainer');
    // Mantenha o input de busca (se existir)
    let inputBuscarCdipHTML = '';
    if (usuarioPerfil === "01") {
        inputBuscarCdipHTML = `<section class="modal-body">
                                        <div class="input-group">
                                            <label for="data">Pesquisar Data</label>
                                            <input type="text" class="modal__digitalizacao" id="inputBuscarCdip"
                                                name="buscarCdip" value="${termoPesquisa}" maxlength="10" placeholder="DD/MM/AAAA">
                                        </div>
                                    </section>`;
    }
    renderizarTabela(dadosFiltrados, sesRecebidas, ocorrencias, usuarioPerfil, resultadoContainer, inputBuscarCdipHTML);

    // Re-anexa o listener ao input de busca, pois ele foi recriado
    const inputBuscarCdip = document.getElementById('inputBuscarCdip');
    if (inputBuscarCdip) {
        // Adiciona a máscara de data ao input de pesquisa
        inputBuscarCdip.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito
            if (value.length > 2) {
                value = value.substring(0, 2) + '/' + value.substring(2);
            }
            if (value.length > 5) {
                value = value.substring(0, 5) + '/' + value.substring(5, 9); // Limita a 4 dígitos para o ano
            }
            e.target.value = value;

            // Chamar a função de filtro com o valor formatado e os dados originais
            // É importante passar os dadosDigitalizacaoOriginais aqui para que o filtro seja sempre no conjunto completo.
            filtrarTabela(value, dadosDigitalizacaoOriginais, sesRecebidas, ocorrencias, usuarioPerfil);
        });
    }
}

// ---
// MASCARA DE DIGITAR CARGA
// ---
function mascaraDigitarCarga(valor) {
    valor = valor.replace(/\D/g, "");
    valor = valor.replace(/(\d)(\d{3})$/, "$1.$2");
    valor = valor.replace(/(\d)(\d{3}).(\d{3})$/, "$1.$2.$3");
    return valor;
}

// ---
// ADICIONAR LISTENERS DO MODAL
// ---
function adicionarListenersModal() {
    const openModalButtons = document.querySelectorAll('.open-modal');
    const closeModalButtons = document.querySelectorAll('.close-modal');

    let botaoLancarCarga = document.getElementById('login-button-inicial');

    if(botaoLancarCarga){
        botaoLancarCarga.addEventListener('click', function(event){
            // Valida o formulário antes de abrir o modal
            if(typeof validaFormulario !== 'undefined' && !validaFormulario()){
                // Se a validação falhar, impede a abertura do modal
                event.preventDefault();
                event.stopPropagation();
                return false;
            }
            // Se a validação passar, abre o modal normalmente
            const modalId = event.currentTarget.dataset.modal;
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.showModal();
            }
        });
    }

    // Restante do código para outros modais...
    openModalButtons.forEach(button => {
        if(button.id !== 'login-button-inicial') { // Não adiciona novamente ao botão principal
            button.removeEventListener('click', handleOpenModal);
            button.addEventListener('click', handleOpenModal);
        }
    });

    closeModalButtons.forEach(button => {
        button.removeEventListener('click', handleCloseModal);
        button.addEventListener('click', handleCloseModal);
    });

    function handleOpenModal(event) {
        const modalId = event.currentTarget.dataset.modal;
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.showModal();
        }
    }

    function handleCloseModal(event) {
        const modalId = event.currentTarget.dataset.modal;
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.close();
        }
    }
}

// ---
// NOVO: ADICIONAR LISTENERS PARA OS BOTÕES DE SE
// ---
function adicionarListenersBotoesSe() {
    const seButtons = document.querySelectorAll('.container__se input[type="button"]');

    seButtons.forEach(button => {
        button.removeEventListener('click', handleSeButtonClick); // Remove previous listener to prevent duplicates
        button.addEventListener('click', handleSeButtonClick);
    });

    function handleSeButtonClick(event) {
        const button = event.target;
        // Toggle the value and class
        if (button.value === "") {
            button.value = "Recebida";
            button.classList.remove("estado__nao_recebida");
            button.classList.add("estado__recebida");
        } else {
            button.value = "";
            button.classList.remove("estado__recebida");
            button.classList.add("estado__nao_recebida");
        }
        // Prevent form submission, though it's already a button type="button"
        event.preventDefault();
    }

    // Listener for the "Salvar Alterações SEs" button (if you want to handle the update to the backend)
    const saveSeButtons = document.querySelectorAll('[id^="btn-salvar-ses-"]');
    saveSeButtons.forEach(button => {
        button.removeEventListener('click', handleSaveSeChanges);
        button.addEventListener('click', handleSaveSeChanges);
    });

    function handleSaveSeChanges(event) {
        const button = event.target;
        const idCounter = button.id.split('-')[3];
    
        const dataDigitalizacao = document.querySelector(`#modals-${idCounter} input[data-data-digitalizacao]`).dataset.dataDigitalizacao;
        // Recupera a unidade do elemento correspondente na tabela
        const unidade = document.getElementById(`unidade${idCounter}`).textContent;
    
        const seStates = [];
        document.querySelectorAll(`#modals-${idCounter} .container__se input[type="button"]`).forEach(seButton => {
            const seNumero = seButton.dataset.seNumero;
            const status = seButton.value === "Recebida" ? 1 : 0;
            seStates.push({ se_numero: seNumero, status: status });
        });
    
        const ocorrencia = document.getElementById(`ocorrencia-${idCounter}`).value;
    
        console.log(`Dados para enviar para o backend para ID: ${idCounter}, Data: ${dataDigitalizacao}, Unidade: ${unidade}, Ocorrência: "${ocorrencia}"`);
        console.log("Estados das SEs:", seStates);
    
        fetch('../cadastro/controllerAlterarSEOcorrenciaDigitalizacao.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                data_digitalizacao: dataDigitalizacao,
                se_states: seStates,
                ocorrencia: ocorrencia,
                unidade: unidade // Enviando a unidade
            }),
        })
        .then(response => response.json())
        .then(data => {
            console.log('Resposta do backend:', data);
            if (data.success) {
                alert('Alterações de SE salvas com sucesso!');
                document.getElementById(`modals-${idCounter}`).close();
            } else {
                alert('Erro ao salvar alterações de SE: ' + data.message);
            }
        })
        .catch((error) => {
            console.error('Erro ao enviar dados de SE:', error);
            alert('Erro ao salvar alterações de SE.');
        });
        event.preventDefault();
    }
}


document.addEventListener('DOMContentLoaded', relatorioDigitalizacao);