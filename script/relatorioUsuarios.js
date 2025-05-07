function listarUnidade(selectElement) {
    fetch('../cadastro/controllerRelatorioUsuarios.php')
        .then(response => response.json())
        .then(data => {
            // Filtrar apenas objetos de unidade
            const unidades = data.filter(item => item.lista_unidade);

            let optionsHTML = '<option value=""> - Unidade - </option>'; // Adiciona a opção padrão

            unidades.forEach(item => {
                optionsHTML += `<option value="${item.lista_unidade}" id="selecionar__unidade">${item.id_unidade} - ${item.lista_unidade}</option>`;
            });

            // Adiciona as opções ao elemento select fornecido
            if (selectElement) {
                selectElement.innerHTML = optionsHTML;
            } else {
                console.error('Elemento select não fornecido para listarUnidade.');
            }
        })
        .catch(error => console.error('Erro:', error));
}

function listarPerfil(selectElementPerfil) {
    fetch('../cadastro/controllerRelatorioUsuarios.php')
        .then(response => response.json())
        .then(data => {
            // Filtrar apenas objetos de pefil
            const perfil = data.filter(item => item.lista_perfil);

            let optionsPerfilHTML = '<option value=""> - Perfil - </option>'; // Adiciona a opção padrão

            perfil.forEach(item => {
                optionsPerfilHTML += `<option value="${item.lista_perfil}" id="selecionar__unidade">${item.id_perfil} - ${item.lista_perfil}</option>`;
            });

            // Adiciona as opções ao elemento select fornecido
            if (selectElementPerfil) {
                selectElementPerfil.innerHTML = optionsPerfilHTML;
            } else {
                console.error('Elemento select não fornecido para listarUnidade.');
            }
        })
        .catch(error => console.error('Erro:', error));
}


function relatorioUsuarios() {
    let id = 2;
    let resultado = document.getElementById('dadosContainer');
    resultado.innerHTML = ''; // Limpa o conteúdo existente

    fetch('../cadastro/controllerRelatorioUsuarios.php')
        .then(response => response.json())
        .then(data => {
            // Filtrar apenas objetos de usuário
            const usuarios = data.filter(item => item.usuario);

            let tabelaHTML = `<section class="modal-body">
                                    <div class="input-group">
                                        <table>
                                            <tr>
                                                <th class='usuario'>Unidade</th>
                                                <th class='usuario'>Usuário</th>
                                                <th class='usuario'>Matrícula</th>
                                                <th class='usuario'>e-mail</th>
                                                <th class='usuario'>Telefone</th>
                                                <th class='usuario'>Celular</th>
                                                <th class='usuario'>Perfil</th>
                                                <th class='usuario'>Alterar</th>
                                                <th class='usuario'>Habilitar/Desabilitar</th>
                                            </tr>`;

            usuarios.forEach(item => {
                tabelaHTML += `<tr class='linha__tabela ${item.status === 0 ? 'usuarioDesabilitado' : ''}'>
                                    <td class='${item.status === 0 ? 'usuarioDesabilitado' : 'usuario'}' id='inputUnidade${id}'>${item.unidade}</td>
                                    <td class='${item.status === 0 ? 'usuarioDesabilitado' : 'usuario'}' id='inputNome${id}'>${item.usuario}</td>
                                    <td class='${item.status === 0 ? 'usuarioDesabilitado' : 'usuario'}' id='inputMatricula${id}'>${item.matricula}</td>
                                    <td class='${item.status === 0 ? 'usuarioDesabilitado' : 'usuario'}' id='inputEmail${id}'>${item.email}</td>
                                    <td class='${item.status === 0 ? 'usuarioDesabilitado' : 'usuario'}' id='inputTelefone${id}'>${item.telefone}</td>
                                    <td class='${item.status === 0 ? 'usuarioDesabilitado' : 'usuario'}' id='inputCelular${id}'>${item.celular}</td>
                                    <td class='${item.status === 0 ? 'usuarioDesabilitado' : 'usuario'}' id='inputPerfil${id}'>${item.perfil}</td>
                                    <td class='${item.status === 0 ? 'usuarioDesabilitado' : 'usuario'}' id="alterar">
                                        <button class='open-modal botao__alterar_excluir' data-modal="modal-${id}">
                                            <i class='fa-solid fa-pencil'></i>
                                        </button>
                                    </td>
                                    <td class='${item.status === 0 ? 'usuarioDesabilitado' : 'usuario'}'>
                                        <button class='botao botao__excluir${id} botao__alterar_excluir'>
                                            <i class='fa-solid fa-trash'></i>
                                        </button>
                                    </td>
                                </tr>`;
                        id++;
            });

            tabelaHTML += `</table></div></section>`;
            resultado.innerHTML = tabelaHTML;

            let modalHTML = '';
            id = 2;

            usuarios.forEach(item => {
                modalHTML += `<dialog class="manter__aberto" id="modal-${id}">
                                    <div class="menuAlterar">
                                        <form method="post" id="myForm${id}" name="autenticar">
                                            <div class="modal-header">
                                                <h1 class="modal-title">Alterar dados usuário</h1>
                                                <button class="close-modal" data-modal="modal-${id}" type="button">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                            <section class="modal-body">
                                                <div class="input-group">
                                                    <label for="nome">Alterar Nome</label>
                                                    <input type="text" class="modal__digitalizacao" id="inputAlterarNome${id}" 
                                                    name="novoNome" value="${item.usuario}" maxlength="60">
                                                </div>
                                                <div class="input-group">
                                                    <label for="matricula">Alterar Matrícula</label>
                                                    <input type="text" class="modal__digitalizacao" id="inputAlterarMatricula${id}" 
                                                    name="novaMatricula" value="${item.matricula}" maxlength="11">
                                                </div>
                                                <div class="input-group">
                                                    <label for="email">Alterar e-mail</label>
                                                    <input type="email" class="modal__digitalizacao" id="inputAlterarEmail${id}" 
                                                    name="novoEmail" value="${item.email}" maxlength="60">
                                                </div>
                                                <div class="input-group">
                                                    <label for="telefone">Alterar Telefone</label>
                                                    <input type="text" class="modal__digitalizacao" id="inputAlterarTelefone${id}" 
                                                    name="novoTelefone" value="${item.telefone}" maxlength="11">
                                                </div>
                                                <div class="input-group">
                                                    <label for="celular">Alterar Celular</label>
                                                    <input type="text" class="modal__digitalizacao" id="inputAlterarCelular${id}" 
                                                    name="novoCelular" value="${item.celular}" maxlength="11">
                                                </div>
                                                <div class="input-group">
                                                    <label for="unidade">Alterar Unidade</label>
                                                    <select class="selecionar modal__digitalizacao" type="checkbox" 
                                                    name="novaUnidade" size="1" id="alterarUnidade${id}">
                                                    </select>
                                                </div>
                                                <div class="input-group">
                                                    <label for="perfil">Alterar Perfil</label>
                                                    <select class="selecionar modal__digitalizacao" type="checkbox" 
                                                    name="novoPerfil" size="1" id="alterarPerfil${id}">
                                                    </select>
                                                </div>
                                             </section>
                                             <section class="modal-body">
                                                <div class="alterar__dados">
                                                    <input value="Alterar" type="submit" id="login-button">
                                                </div>
                                            </section>
                                        </form>
                                    </div>
                                </dialog>`;
                id++;
            });

            resultado.innerHTML += modalHTML;
            document.querySelectorAll('dialog').forEach(modal => modal.close());
            adicionarListenersModal();
            document.querySelectorAll('[id^="alterarUnidade"]').forEach(selectElement => {
                listarUnidade(selectElement);
            });
            document.querySelectorAll('[id^="alterarPerfil"]').forEach(selectElementPerfil => {
                listarPerfil(selectElementPerfil);
            });
        })
        .catch(error => console.error('Erro:', error));
}