function relatorioDiarioSE() {
    const unidade = document.getElementById('unidade').value;
    const dataInicial = document.getElementById('dataInicial').value;
    const dataFinal = document.getElementById('dataFinal').value;
    let resultado = document.getElementById('dadosContainer');
    resultado.innerHTML = ''; // Limpa o conteúdo existente

    fetch('../cadastro/controllerCargaDiariaSE.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            unidade: unidade,
            dataInicial: dataInicial,
            dataFinal: dataFinal
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.text().then(text => { throw new Error(text) });
        }
        return response.json();
    })
    .then(data => {
        if (!Array.isArray(data) || data.length === 0) {
            resultado.innerHTML = '<p>Nenhum dado encontrado para os critérios informados.</p>';
            return;
        }

        // 1. Agrupar os dados por matrícula e data
        const groupedData = {};
        
        data.forEach(item => {
            const key = `${item.matricula}-${item.data_recebimento}`;
            
            if (!groupedData[key]) {
                groupedData[key] = {
                    unidade: item.unidade,
                    matricula: item.matricula,
                    data_recebimento: item.data_recebimento,
                    ses: []
                };
            }
            
            groupedData[key].ses.push(item.se_recebida);
        });

        // 2. Converter o objeto agrupado em array para facilitar a iteração
        const processedData = Object.values(groupedData);

        // 3. Encontrar o número máximo de SEs para qualquer registro
        const maxSes = Math.max(...processedData.map(item => item.ses.length));

        // 4. Gerar os cabeçalhos das colunas de SE
        let seHeaders = '';
        for (let i = 1; i <= maxSes; i++) {
            seHeaders += `<th class='usuario'>SE ${i}</th>`;
        }

        // 5. Construir a tabela HTML
        let tabelaHTML = `
        <section>
            <div>
                <a href="../cadastro/controllerGerarExcelSE.php?dataInicial=${dataInicial}&dataFinal=${dataFinal}&unidade=${unidade}">Gerar arquivo XLS</a>
            </div>
        </section>
        <section class="modal-body centralizar__tabela">
            <div class="input-group">
                <table>
                    <thead>
                        <tr>
                            <th class='usuario'>Unidade</th>
                            <th class='usuario'>Matrícula</th>
                            <th class='usuario'>Data</th>
                            ${seHeaders}
                        </tr>
                    </thead>
                    <tbody>`;

        // 6. Adicionar as linhas de dados
        processedData.forEach(item => {
            let seCells = '';
            
            // Preencher as células de SE
            for (let i = 0; i < maxSes; i++) {
                const se = item.ses[i] || ''; // Se não houver SE, usa string vazia
                seCells += `<td class=''>${se}</td>`;
            }
            
            tabelaHTML += `
                <tr>
                    <td class=''>${item.unidade}</td>
                    <td class=''>${item.matricula}</td>
                    <td class=''>${item.data_recebimento}</td>
                    ${seCells}
                </tr>`;
        });

        tabelaHTML += `</tbody></table></div></section>`;
        resultado.innerHTML = tabelaHTML;
    })
    .catch(error => {
        console.error('Erro na requisição ou no processamento dos dados:', error);
        resultado.innerHTML = `<p>Ocorreu um erro ao carregar os dados: ${error.message}</p>`;
    });
}