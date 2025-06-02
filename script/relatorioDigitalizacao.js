// Adicione esta lista de SEs no topo do seu arquivo JS, fora de qualquer função
const todasAsSes = [
    { numero: "00061", nome: "AC" },
    { numero: "00062", nome: "AL" },
    { numero: "00063", nome: "AP" },
    { numero: "00064", nome: "AM" },
    { numero: "00055", nome: "BA" },
    { numero: "00065", nome: "CE" },
    { numero: "00010", nome: "BSB" }, // DF
    { numero: "00066", nome: "ES" },
    { numero: "00060", nome: "GO" },
    { numero: "00068", nome: "MA" },
    { numero: "00069", nome: "MT" },
    { numero: "00070", nome: "MS" },
    { numero: "00030", nome: "MG" },
    { numero: "00071", nome: "PA" },
    { numero: "00072", nome: "PB" },
    { numero: "00035", nome: "PR" },
    { numero: "00050", nome: "PE" },
    { numero: "00073", nome: "PI" },
    { numero: "00074", nome: "RJ" },
    { numero: "00075", nome: "RN" },
    { numero: "00076", nome: "RS" },
    { numero: "00078", nome: "RO" },
    { numero: "00079", nome: "RR" },
    { numero: "00045", nome: "SC" },
    { numero: "00020", nome: "SPI" }, // SP interior
    { numero: "00015", nome: "SPM" }, // SP metropolitana
    { numero: "00080", nome: "SE" },
    { numero: "00081", nome: "TO" },
];

function nomeSE(numero) {
    const seEncontrada = todasAsSes.find(se => se.numero === numero);
    return seEncontrada ? seEncontrada.nome : numero;
}

function relatorioDigitalizacao() {
    let tabelaHTML = '';
    let resultado = document.getElementById('dadosContainer');
    resultado.innerHTML = ''; // Limpa o conteúdo existente

    fetch('../cadastro/controllerCargaDigitalizacao.php')
        .then(response => response.json())
        .then(data => {
            const digitalizacoes = data.digitalizacoes || [];
            const sesRecebidas = data.ses_recebidas || [];
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
                                                <th class='usuario'>Alterar</th>
                                                <th class='usuario'>Alterar SE</th>
                                                ${usuarioPerfil === '01' ? `<th id='colunaExcluir' class='usuario'>Excluir</th>` : ''}
                                            </tr>
                                        </thead>
                                        <tbody>`;

            let idCounter = 2;
            digitalizacoes.forEach(item => {
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
                                            <button class='botao botao__excluir${idCounter} botao__alterar_excluir' id="btn-excluir-${idCounter}">
                                                <i class='fa-solid fa-trash'></i>
                                            </button>
                                        </td>
                                    ` : ''}
                                </tr>`;
                idCounter++;
            });

            tabelaHTML += `</tbody></table></div></section>`;
            resultado.innerHTML = inputBuscarCdipHTML + tabelaHTML;

            let modalHTML = '';
            idCounter = 2;
            digitalizacoes.forEach(item => {
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
                                              seRecebida.data_recebimento === item.data_digitalizacao
                            );

                            const valorInput = seRecebidaNaData ? "Recebida" : "Não Recebida";
                            const classeEstado = seRecebidaNaData ? "estado__recebida" : "estado__nao_recebida";

                            return `
                            <div class="coluna__se">
                                <label class="caixa" for="se-${seCompleta.numero}-${idCounter}">
                                    ${seCompleta.nome}
                                </label>
                                <input class="estados ${classeEstado}"
                                        type="button"
                                        id="se-${seCompleta.numero}-${idCounter}"
                                        name="${seCompleta.nome.toLowerCase()}"
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
                            placeholder="Escreva a ocorrência aqui..." autofocus></textarea>
                        </div>
                    </section>
                    <section class="modal-body">
                        <div class="container__cadastro__envio">
                            <input value="Incluir SEs" type="submit" id="login-button-modal-${idCounter}"></input>
                        </div>
                    </section>
                </dialog>`;
                idCounter++;
            });

            resultado.innerHTML += modalHTML;
            adicionarListenersModal();

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

                    // Chama a função de filtro com o valor formatado
                    filtrarTabela(value, digitalizacoes);
                });
            }

        })
        .catch(error => {
            console.error('Erro:', error);
        });
}

// ---
// FUNÇÃO PARA FILTRAR A TABELA POR DATA
// ---
function filtrarTabela(termoPesquisa, dadosOriginais) {
    const linhas = document.querySelectorAll('.item-tabela');
    const termoFormatado = termoPesquisa.toLowerCase().trim(); // Mantém a formatação para DD/MM/AAAA

    linhas.forEach(linha => {
        const dataCelula = linha.querySelector('[id^="Data"]').textContent.toLowerCase(); // Pega o texto da célula de data

        // Compara o termo de pesquisa (já formatado para DD/MM/AAAA) diretamente com a data da célula
        if (dataCelula.includes(termoFormatado)) {
            linha.style.display = ''; // Mostra a linha
        } else {
            linha.style.display = 'none'; // Esconde a linha
        }
    });
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
            if(validaFormulario() == false){
                event.preventDefault(); 
                event.stopPropagation();
                window.location.href = '../digitalizacao/lancarCarga.php';
            }
        });
    }


    openModalButtons.forEach(button => {
        button.removeEventListener('click', handleOpenModal);
        button.addEventListener('click', handleOpenModal);
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

document.addEventListener('DOMContentLoaded', relatorioDigitalizacao);