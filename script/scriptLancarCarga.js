digitarFormulario();

relatorioDigitalizacao();

digitarFormularioModal();
    
//adicionarListenersFormularios();

const form = document.getElementById('myForm');
form.addEventListener('submit', (event) => {
    event.preventDefault(); // Impede o envio padrão do formulário
    if (validaFormulario()) {
        // Se o formulário for válido, envie os dados
       enviarDadosFormulario();
       window.location.href = '../digitalizacao/lancarCarga.php';
    }
});

    
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        const teste = document.querySelectorAll('form');        
            
            for(let i = 0; i < teste.length; i++) {
                    
                const formu = document.getElementById(`myForm${i}`);
                formu.addEventListener('submit', (event) => {
                    console.log('teste'); // Agora você deve ter todos os formulários 
                    event.preventDefault(); // Impede o envio padrão do formulário
                    
                    if (validaFormularioModal(i)) {
                        // Se o formulário for válido, envie os dados
                    //enviarDadosFormulario();
                    //window.location.href = '../digitalizacao/lancarCarga.php';
        
                    alert('validado com sucesso');
                    }else{
                        console.log('erro');
                    }
                });
            }
    },300);
        
});
    