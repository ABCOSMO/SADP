function adicionarListenersModal() {
    // Impedir que eventos se propaguem para elementos pais
    document.addEventListener('click', function(e) {
        if (e.target.closest('.open-modal') || e.target.closest('.close-modal')) {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    // Abrir modal
    document.querySelectorAll('.open-modal').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            const modal = document.getElementById(modalId);
            
            if (modal) {
                modal.showModal();
                // Adiciona classe ao body para evitar scroll
                document.body.classList.add('modal-open');
                
                // Focar no primeiro elemento input do modal
                const firstInput = modal.querySelector('input, select, textarea');
                if (firstInput) {
                    firstInput.focus();
                }
            }
        });
    });

    // Fechar modal
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