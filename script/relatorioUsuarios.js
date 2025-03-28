function relatorioUsuarios() {
    let id = 2;
    let resultado = document.getElementById('dadosContainer');
    resultado.innerHTML = ''; // Limpa o conteúdo existente

    fetch('../cadastro/controllerRelatorioUsuarios.php')
        .then(response => response.json())
        .then(data => {
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

            data.forEach(item => {
                tabelaHTML += `<tr class='linha__tabela'>
                                    <td class='usuario' id='inputUnidade${id}'>
                                        ${item.unidade}
                                    </td>
                                    <td class='usuario' id='inputNome${id}'>
                                        ${item.usuario}
                                    </td>
                                    <td class='usuario' id='inputMatricula${id}'>
                                        ${item.matricula.toString()}
                                    </td>
                                    <td class='usuario' id='inputEmail${id}'>
                                        ${item.email.toString()}
                                    </td>
                                    <td class='usuario' id='inputTelefone${id}'>
                                        ${item.telefone.toString()}
                                    </td>
                                    <td class='usuario' id='inputCelular${id}'>
                                        ${item.celular.toString()}
                                    </td>
                                    <td class='usuario' id='inputPerfil${id}'>
                                        ${item.perfil.toString()}
                                    </td>
                                    <td class='usuario' id="alterar"><button class='open-modal botao__alterar_excluir' data-modal="modal-${id}">
                                        <i class='fa-solid fa-pencil'></i></button>
                                    </td>
                                    <td class='usuario' id='usuario'>
                                        <button class='botao__excluir botao__alterar_excluir'>
                                        <i class='fa-solid fa-trash'></i></button></td>
                                    </tr>`;
                id++;
            });
            
            tabelaHTML += `</table></div></section>`;
            resultado.innerHTML = tabelaHTML;
            let modalHTML = ''; // Declaração correta da variável
            id = 2; // Reset do ID para manter consistência
            
            data.forEach(item => {
                modalHTML +=    `<dialog class="container__botao" id="modal-${id}">        
                                    <div class="menuAlterarCadastro">
                                        <form method="post" id="myForm${id}" name="autenticar" >
                                            <div class="modal-header">
                                                <h1 class="modal-title">Alterar dados usuário</h1>
                                                <button class="close-modal" data-modal="modal-${id}" type="button">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="input-group">
                                                    <label for="nome">
                                                        Alterar Nome
                                                    </label>
                                                    <input type="text" id="inputNome${id}" name="novoNome" 
                                                    value=" ${item.usuario}" maxlength="60">
                                                </div>
                                                <div class="input-group">
                                                    <label for="matricula">
                                                        Alterar Matrícula
                                                    </label>
                                                    <input type="text" id="inputMatricula${id}" name="novaMatricula" 
                                                    value="${item.matricula.toString()}" maxlength="11">
                                                </div>
                                                <div class="input-group">
                                                    <label for="email">
                                                        Alterar e-mail
                                                    </label>
                                                    <input type="email" id="inputEmail${id}" name="novoEmail" 
                                                    value="${item.email.toString()}" maxlength="60">
                                                </div>
                                                <div class="input-group">
                                                    <label for="telefone">
                                                        Alterar Telefone
                                                    </label>
                                                    <input type="text" id="inputTelefone${id}" name="novoTelefone" 
                                                    value="${item.telefone.toString()}" maxlength="11">
                                                </div>
                                                <div class="input-group">
                                                    <label for="celular">
                                                        Alterar Celular
                                                    </label>
                                                    <input type="text" id="inputCelular${id}" name="novoCelular" 
                                                    value="${item.celular.toString()}" maxlength="11">
                                                </div>
                                                <div class="input-group">
                                                <label for="unidade">
                                                        Alterar Unidade
                                                    </label>
                                                    <select class="selecionar" type="checkbox" name="novaUnidade" size="1" id="unidade${id}">
                                                        <option value=""  id="selecionar__unidade"> - Unidade - </option>
                                                        <?php $escolherUnidade->obterUnidade(); ?>
                                                    </select>
                                                </div>
                                                <div class="input-group">
                                                    <label for="perfil">
                                                        Alterar Perfil
                                                    </label>
                                                    <select class="selecionar" type="checkbox" name="novoPerfil" size="1" id="perfil${id}">
                                                        <option value=""  id="selecionar__unidade"> - Perfil - </option>
                                                        <?php $escolherUnidade->obterPerfil(); ?>
                                                    </select>
                                                </div>
                                                <input value="Alterar" type="submit" id="login-button">
                                                </input>
                                            </div>
                                        </form>
                                    </div>
                                </dialog>`;
                id++;
            });     
            
            resultado.innerHTML += modalHTML; 
            // Fechar todos os modais após criação (sem usar display: none)
            document.querySelectorAll('dialog').forEach(modal => {
                modal.close();
            });
            adicionarListenersModal();                
        })
        .catch(error => {
            console.error('Erro:', error);
        });
}

