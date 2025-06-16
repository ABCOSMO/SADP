document.addEventListener('DOMContentLoaded', relatorioDigitalizacao);

// Mapeamento das SEs gerais, se elas forem fixas ou carregadas de outro lugar.
// Se "todasAsSes" for carregado do backend, garanta que esteja disponível antes de "relatorioDigitalizacao".
const todasAsSes = [
    { numero: "00003", nome: "AC", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00010", nome: "BSB", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00016", nome: "BH", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00022", nome: "SEDE", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00026", nome: "CE", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00028", nome: "MA", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00035", nome: "MT", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00045", nome: "BA", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00055", nome: "ES", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00065", nome: "RJ", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00068", nome: "SC", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00070", nome: "PR", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00074", nome: "RS", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00075", nome: "SP", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"},
    { numero: "00080", nome: "GO", saopaulo: "00424968", brasilia: "00424969", florianopolis: "00424970", curitiba: "00425981"}
];


function relatorioDigitalizacao() {
    const resultado = document.getElementById('dadosContainer'); // Seu elemento onde o HTML será inserido
    if (!resultado) {
        console.error("Elemento 'resultado' não encontrado. Verifique seu HTML.");
        return;
    }
    resultado.innerHTML = '<p>Carregando dados...</p>'; // Mensagem de carregamento

    fetch('../cadastro/controllerCargaDigitalizacao.php')
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro HTTP! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const digitalizacoes = data.digitalizacoes || [];
            const sesRecebidas = data.ses_recebidas || [];
            const ocorrencias = data.ocorrencias || [];
            const usuarioPerfil = data.perfil_usuario; // Supondo que você use isso em algum lugar

            let tableHTML = `
                <table class="tabela-digitalizacao">
                    <thead>
                        <tr>
                            <th>Unidade</th>
                            <th>Usuário</th>
                            <th>Data Digitalização</th>
                            <th>Imagens Anterior</th>
                            <th>Imagens Recebidas</th>
                            <th>Imagens Incorporadas</th>
                            <th>Imagens Impossibilitadas</th>
                            <th>Resto</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            let modalHTML = '';
            let idCounter = 1; // Começamos o ID do modal a partir de 1

            if (digitalizacoes.length === 0) {
                tableHTML += `<tr><td colspan="9">Nenhum dado de digitalização encontrado para a data.</td></tr>`;
            } else {
                digitalizacoes.forEach(item => {
                    tableHTML += `
                        <tr>
                            <td>${item.unidade}</td>
                            <td>${item.nome_usuario} (${item.matricula_usuario})</td>
                            <td>${item.data_digitalizacao}</td>
                            <td>${item.imagens_anterior}</td>
                            <td>${item.imagens_recebidas}</td>
                            <td>${item.imagens_incorporadas}</td>
                            <td>${item.imagens_impossibilitadas}</td>
                            <td>${item.resto}</td>
                            <td>
                                <div class="container__acoes">
                                    <i class="fa-solid fa-pen-to-square abrir__modal" data-modal="modal-${idCounter}"></i>
                                    <i class="fa-solid fa-file-invoice abrir__modal_se" data-modal="modals-${idCounter}"></i>
                                </div>
                            </td>
                        </tr>
                    `;

                    // Modal de Alteração de Carga (se você tiver um, este é um placeholder)
                    modalHTML += `
                    <dialog class="manter__aberto" id="modal-${idCounter}">
                        <div class="modal-header">
                            <p class="modal-title titulo">Alterar Carga</p>
                            <button class="close-modal" data-modal="modal-${idCounter}" type="button">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <section class="modal-body">
                            <form id="form-alterar-carga-${idCounter}">
                                <div class="coluna">
                                    <label for="alt_imagens_anterior_${idCounter}">Imagens Anterior:</label>
                                    <input type="number" id="alt_imagens_anterior_${idCounter}" value="${item.imagens_anterior}">
                                </div>
                                <div class="coluna">
                                    <label for="alt_imagens_recebidas_${idCounter}">Imagens Recebidas:</label>
                                    <input type="number" id="alt_imagens_recebidas_${idCounter}" value="${item.imagens_recebidas}">
                                </div>
                                <div class="coluna">
                                    <label for="alt_imagens_incorporadas_${idCounter}">Imagens Incorporadas:</label>
                                    <input type="number" id="alt_imagens_incorporadas_${idCounter}" value="${item.imagens_incorporadas}">
                                </div>
                                <div class="coluna">
                                    <label for="alt_imagens_impossibilitadas_${idCounter}">Imagens Impossibilitadas:</label>
                                    <input type="number" id="alt_imagens_impossibilitadas_${idCounter}" value="${item.imagens_impossibilitadas}">
                                </div>
                                <div class="coluna">
                                    <label for="alt_resto_${idCounter}">Resto:</label>
                                    <input type="number" id="alt_resto_${idCounter}" value="${item.resto}">
                                </div>
                                <div class="container__cadastro__envio">
                                    <button type="submit">Salvar Alterações</button>
                                </div>
                            </form>
                        </section>
                    </dialog>`;

                    // Encontra a ocorrência para a data e unidade atual do item
                    const ocorrenciaParaEstaUnidadeEData = ocorrencias.find(
                        ocorrencia => ocorrencia.data_recebimento_ocorrencia === item.data_digitalizacao &&
                                      ocorrencia.mcu_unidade === item.mcu_unidade_codigo
                    );
                    // Define o texto da ocorrência (vazio se não houver)
                    const textoOcorrencia = ocorrenciaParaEstaUnidadeEData ? ocorrenciaParaEstaUnidadeEData.ocorrencia : '';

                    // Modal de Alteração de SE e Ocorrências
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
                                // A LÓGICA DE FILTRO CORRIGIDA AQUI
                                const seRecebidaNaData = sesRecebidas.find(
                                    seRecebida => seRecebida.se_recebida === seCompleta.numero &&
                                                  seRecebida.data_recebimento === item.data_digitalizacao &&
                                                  seRecebida.mcu_unidade === item.mcu_unidade_codigo // *** A CORREÇÃO PRINCIPAL ***
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
                                            data-mcu-unidade-codigo="${item.mcu_unidade_codigo}"  
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
                                placeholder="Escreva a ocorrência aqui..." autofocus>${textoOcorrencia}</textarea>
                            </div>
                        </section>
                        <section class="modal-body">
                            <div class="container__cadastro__envio">
                                <button type="button" value="Salvar Alterações SEs" id="btn-salvar-ses-${idCounter}">Salvar Alterações SEs</button>
                            </div>
                        </section>
                    </dialog>`;
                    idCounter++;
                });
            }

            tableHTML += `
                    </tbody>
                </table>
            `;

            resultado.innerHTML = tableHTML + modalHTML; // Renderiza a tabela e todos os modais

            adicionarListenersModal();
            adicionarListenersBotoesSe(); // Adiciona os listeners para os botões de SE e o botão de salvar
        })
        .catch(error => {
            console.error('Erro ao carregar dados:', error);
            resultado.innerHTML = `<p>Erro ao carregar dados: ${error.message}. Por favor, tente novamente.</p>`;
        });
}

// Função para adicionar listeners aos botões de abrir/fechar modais
function adicionarListenersModal() {
    document.querySelectorAll('.abrir__modal, .abrir__modal_se').forEach(button => {
        button.addEventListener('click', (event) => {
            const modalId = event.currentTarget.dataset.modal;
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.showModal();
            }
        });
    });

    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', (event) => {
            const modalId = event.currentTarget.dataset.modal;
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.close();
            }
        });
    });
}

// Função para adicionar listeners aos botões de status da SE e ao botão de salvar
function adicionarListenersBotoesSe() {
    // Listeners para os botões individuais de "Recebida"
    const seButtons = document.querySelectorAll('.container__se input[type="button"]');
    seButtons.forEach(button => {
        // Remover listener anterior para evitar duplicação em chamadas múltiplas de relatorioDigitalizacao
        button.removeEventListener('click', handleSeButtonClick);
        button.addEventListener('click', handleSeButtonClick);
    });

    function handleSeButtonClick(event) {
        const button = event.target;
        // Alterna o valor e as classes
        if (button.value === "") {
            button.value = "Recebida";
            button.classList.remove("estado__nao_recebida");
            button.classList.add("estado__recebida");
        } else {
            button.value = "";
            button.classList.remove("estado__recebida");
            button.classList.add("estado__nao_recebida");
        }
        event.preventDefault(); // Impede qualquer comportamento padrão do botão
    }

    // Listener para o botão "Salvar Alterações SEs"
    const saveSeButtons = document.querySelectorAll('[id^="btn-salvar-ses-"]');
    saveSeButtons.forEach(button => {
        // Remover listener anterior para evitar duplicação
        button.removeEventListener('click', handleSaveSeChanges);
        button.addEventListener('click', handleSaveSeChanges);
    });

    function handleSaveSeChanges(event) {
        const button = event.target;
        const idCounter = button.id.split('-')[3]; // Extrai o ID do contador do ID do botão

        // Recupera os dados necessários do modal específico
        const dataDigitalizacao = document.querySelector(`#modals-${idCounter} input[data-data-digitalizacao]`).dataset.dataDigitalizacao;
        const mcuUnidadeCodigo = document.querySelector(`#modals-${idCounter} input[data-mcu-unidade-codigo]`).dataset.mcuUnidadeCodigo;

        const seStates = [];
        document.querySelectorAll(`#modals-${idCounter} .container__se input[type="button"]`).forEach(seButton => {
            const seNumero = seButton.dataset.seNumero;
            const status = seButton.value === "Recebida" ? 1 : 0; // Converte para 1 (recebida) ou 0 (não recebida)
            seStates.push({ se_numero: seNumero, status: status });
        });

        const ocorrencia = document.getElementById(`ocorrencia-${idCounter}`).value;

        console.log(`Dados para enviar para o backend para ID: ${idCounter}, Data: ${dataDigitalizacao}, MCU Unidade Código: ${mcuUnidadeCodigo}, Ocorrência: "${ocorrencia}"`);
        console.log("Estados das SEs:", seStates);

        // Envia os dados para o backend
        fetch('../cadastro/controllerAlterarSEOcorrenciaDigitalizacao.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                data_digitalizacao: dataDigitalizacao,
                se_states: seStates,
                ocorrencia: ocorrencia,
                unidade: mcuUnidadeCodigo // Enviando o código da unidade correto
            }),
        })
        .then(response => {
            if (!response.ok) {
                // Se a resposta não for OK (ex: 404, 500), joga um erro
                throw new Error(`Erro HTTP! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Resposta do backend:', data);
            if (data.success) {
                alert('Alterações de SE e ocorrência salvas com sucesso!');
                document.getElementById(`modals-${idCounter}`).close(); // Fecha o modal
                // Opcional: Recarrega os dados para refletir as alterações na tabela
                relatorioDigitalizacao();
            } else {
                alert('Erro ao salvar alterações de SE: ' + (data.message || 'Erro desconhecido.'));
            }
        })
        .catch((error) => {
            console.error('Erro ao enviar dados de SE:', error);
            alert('Erro ao salvar alterações de SE. Verifique o console para mais detalhes.');
        });
        event.preventDefault(); // Impede o comportamento padrão do botão
    }
}