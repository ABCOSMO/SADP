function adicionarListenersModal() {
    let botaoLancarCarga = document.getElementById('login-button-inicial'); // Este é o seu botão que inicia a ação
    // Certifique-se de que este botão tenha um `data-modal` atributo no HTML se ele for abrir um modal específico.
    // Ex: <button id="login-button-inicial" data-modal="idDoSeuModal" class="open-modal">Lançar Carga</button>


    botaoLancarCarga.addEventListener('click', function(event) {
        // Obtenha o ID do modal que este botão deve abrir, se houver
        const modalId = this.getAttribute('data-modal');
        const modal = document.getElementById(modalId);

        if (validaFormulario() === false) { // Se o formulário NÃO for válido
            event.preventDefault(); // IMPEDE a ação padrão do botão (se for um submit, por exemplo)
            event.stopPropagation(); // IMPEDE que o evento de clique se propague para outros listeners
            // Opcional: Mostrar uma mensagem de erro ao usuário aqui, em vez de abrir um modal ou redirecionar.
            console.log("Formulário não preenchido! Não vai abrir o modal.");
            // Você pode adicionar um alerta ou exibir uma mensagem na tela para o usuário
            alert("Por favor, preencha todos os campos obrigatórios antes de continuar.");

            // Se o formulário não está preenchido, você pode querer redirecionar
            // para 'lancarCarga.php' apenas se essa página for o formulário em si.
            // Se 'lancarCarga.php' é onde o modal seria aberto, então não redirecione AQUI.
            // O redirecionamento só deve acontecer se o formulário for VÁLIDO.
            // window.location.href = '../digitalizacao/lancarCarga.php'; // Remova ou mova isso
        } else { // Se o formulário É válido
            // Se o botão também serve para redirecionar PARA a página que abre o modal,
            // ou se ele abre um modal na página atual, você faz isso aqui.
            if (modal) {
                modal.showModal(); // Abre o modal SÓ SE O FORMULÁRIO FOR VÁLIDO
                document.body.classList.add('modal-open');
                const firstInput = modal.querySelector('input, select, textarea');
                if (firstInput) {
                    firstInput.focus();
                }
            } else {
                // Se não há modal para abrir e a intenção é redirecionar, faça isso aqui
                window.location.href = '../digitalizacao/lancarCarga.php';
            }
        }
    });

    // Remova os blocos de código abaixo que abriam e fechavam o modal de forma genérica
    // se o seu 'login-button-inicial' é o ÚNICO que deve interagir com o modal
    // de forma condicionada ao formulário.
    // Caso contrário, você pode manter os listeners genéricos `.open-modal` e `.close-modal`
    // para outros botões que abrem modais SEM validação de formulário.

    // Impedir que eventos se propaguem para elementos pais (Manter, mas com cautela se usar preventDefault acima)
    document.addEventListener('click', function(e) {
        if (e.target.closest('.open-modal') || e.target.closest('.close-modal')) {
            // Se o evento foi impedido acima, este preventDefault pode ser redundante
            // ou até indesejável se você quiser que o evento original se propague
            // em outros cenários.
            // e.preventDefault(); // Pode causar problemas se o evento já foi tratado
            // e.stopPropagation();
        }
    });

    // Fechar modal (Este bloco pode ser mantido, pois é para fechar o modal, não abrir)
    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            const modal = document.getElementById(modalId);

            if (modal) {
                modal.close();
                document.body.classList.remove('modal-open');
            }
        });
    });
}