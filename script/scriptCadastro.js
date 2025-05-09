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

    // Fechar modal ao clicar no backdrop
    /*document.querySelectorAll('dialog').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.close();
                document.body.classList.remove('modal-open');
            }
        });
    });*/
}


function enviarDadosFormulario()
		{
			const form = document.getElementById('myForm');
			const loading = document.querySelector('.loading');
			
			
				event.preventDefault();
				// Mostrar a animação
				loading.style.display = 'block';
				const formData = new FormData(form);
				console.log(formData);
			
				fetch('../cadastro/controllerCadastro.php', {
					method: 'POST',
					body: formData
				})
				.then(response => {
					if (!response.ok) {
					throw new Error('Rede não responde');
					}
					return response.json();
				}) 
				// Recebe a resposta como JSON
				.then(data => {
					// Ocultar a animação e exibir uma mensagem
					loading.style.display = 'none';
					console.log(data);
					// Processa a resposta JSON, por exemplo, exibindo uma mensagem
					if (data.success) {
						alert(data.message);
						window.location.href = '../digitalizacao/alterarExcluirUsuario.php';
					} else {
						alert('Erro ao enviar os dados: ' + data.error);
					}
				})
				.catch(error => {
					loading.style.display = 'none';
					console.error('Erro ao enviar os dados:', error);
					alert('Erro enviar os dados::');
				});
			
		}

function mascaraMatricula(matricula) {
    // Remove todos os caracteres não numéricos
    matricula = matricula.replace(/\D/g, "");

    // Verifica se o Mátricula tem 8 dígitos
    if (matricula.length !== 8) {
        return matricula; // Retorna o Matrícula sem formatação
    }

    // Insere os pontos e hífen na posição correta
    matricula = matricula.replace(/(\d{1})(\d{3})(\d{3})(\d{1})/, "$1.$2.$3-$4");

    return matricula;
}

// Exemplo de uso:
let inputMatricula = document.getElementById('inputMatricula');

inputMatricula.addEventListener('input', () => {
    inputMatricula.value = mascaraMatricula(inputMatricula.value);
});

function mascaraTelefone(telefone) {
    // Remove todos os caracteres não numéricos
    telefone = telefone.replace(/\D/g, "");

    // Verifica se o telefone tem 10 ou 11 dígitos
    if (telefone.length !== 10 && telefone.length !== 11) {
        return telefone; // Retorna o telefone sem formatação
    }

    // Insere os pontos e hífen na posição correta
    if (telefone.length === 11) {
        telefone = telefone.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
    } else {
        telefone = telefone.replace(/(\d{2})(\d{4})(\d{4})/, "($1) $2-$3");
    }

    return telefone;
}
// Exemplo de uso:
let inputTelefone = document.getElementById('inputTelefone');

inputTelefone.addEventListener('input', () => {
    inputTelefone.value = mascaraTelefone(inputTelefone.value);
});

function mascaraCelular(celular) {
    // Remove todos os caracteres não numéricos
    celular = celular.replace(/\D/g, "");
  
    // Verifica se o celular tem 11 dígitos
    if (celular.length !== 11) {
      return celular; // Retorna o celular sem formatação se não tiver 11 dígitos
    }
  
    // Aplica a máscara: (XX) XXXXX-XXXX
    celular = celular.replace(/(\d{2})(\d{5})(\d{4})/, "($1) $2-$3");
  
    return celular;
  }
  
  // Exemplo de uso com um campo de input HTML:
  let inputCelular = document.getElementById('inputCelular');
  
  if (inputCelular) {
    inputCelular.addEventListener('input', () => {
      inputCelular.value = mascaraCelular(inputCelular.value);
    });
  }

function isValidEmail(email) {
    // Expressão regular para validar email
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }

function validaFormulario(){
    
    if (document.getElementById('inputNome').value === "")
    {
        alert("Por favor, preencha o campo Nome.");
        return false; // Formulário inválido

    }
    if (document.getElementById('inputMatricula').value === "")
    {
        alert("Por favor, preencha o campo Matrícula.");
        return false; // Formulário inválido

    }
    if (!isValidEmail(document.getElementById('inputEmail').value)) {
        alert("Por favor, insira um endereço de e-mail válido.");
        return false;
    }
    if (document.getElementById('inputTelefone').value === "")
    {
        alert("Por favor, preencha o campo Telefone.");
        return false; // Formulário inválido

    }
    if (document.getElementById('inputCelular').value === "")
    {
            alert("Por favor, preencha o campo Celular.");
            return false; // Formulário inválido
    
    }
    if (document.getElementById('unidade').options[document.getElementById('unidade').selectedIndex].value === "")
    {
        alert("Por favor, preencha o campo Unidade.");
        return false; // Formulário inválido

    }
    if (document.getElementById('perfil').options[document.getElementById('perfil').selectedIndex].value === "")
    {
        alert("Por favor, preencha o campo Perfil.");
        return false; // Formulário inválido

    }
    if (document.getElementById('password').value === "")
    {
        alert("Por favor, preencha o campo Senha.");
        return false; // Formulário inválido
    }else
    {
		 return true; // Formulário inválido
    }
}

const form = document.getElementById('myForm');
form.addEventListener('submit', (event) => {
    event.preventDefault(); // Impede o envio padrão do formulário

    if (validaFormulario()) {
        // Se o formulário for válido, envie os dados
       enviarDadosFormulario();
    }
});

relatorioUsuarios();

