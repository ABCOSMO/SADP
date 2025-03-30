function enviarDadosAlterarFormulario(id) {
			const form = document.getElementById(`myForm${id}`);
			const loading = document.querySelector('.loading');			
			
				event.preventDefault();
				// Mostrar a animação
				loading.style.display = 'block';
				const formData = new FormData(form);
				console.log(formData);
			
				fetch('../cadastro/controllerAlterarDadosUsuario.php', {
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
					alert('Erro ao enviar os dados');
				});
			
		}


setTimeout(() => {
    const numeroForm = document.querySelectorAll('.contar');
    for(let a = 2; a <= numeroForm.length; a++) {
        let inputMatricula = document.getElementById(`inputAlterarMatricula${a}`);        
        inputMatricula.addEventListener('input', () => {
            inputMatricula.value = mascaraMatricula(inputMatricula.value);
        });

        let inputTelefone = document.getElementById(`inputAlterarTelefone${a}`);
        inputTelefone.addEventListener('input', () => {
            inputTelefone.value = mascaraTelefone(inputTelefone.value);
        });
        let inputCelular = document.getElementById(`inputAlterarCelular${a}`);
        inputCelular.addEventListener('input', () => {
            inputCelular.value = mascaraCelular(inputCelular.value);
          });
    }    
}, 500);


function validaAlterarFormulario(id){

    if (document.getElementById(`inputAlterarNome${id}`).value === "")
    {
        alert("Por favor, preencha o campo Nome.");
        return false; // Formulário inválido

    }
    if (document.getElementById(`inputAlterarMatricula${id}`).value === "")
    {
        alert("Por favor, preencha o campo Matrícula.");
        return false; // Formulário inválido

    }
    if (!isValidEmail(document.getElementById(`inputAlterarEmail${id}`).value)) {
        alert("Por favor, insira um endereço de e-mail válido.");
        return false;
      }
    if (document.getElementById(`inputAlterarTelefone${id}`).value === "")
    {
        alert("Por favor, preencha o campo Telefone.");
        return false; // Formulário inválido

    }
    if (document.getElementById(`inputAlterarCelular${id}`).value === "")
        {
            alert("Por favor, preencha o campo Celular.");
            return false; // Formulário inválido
    
        }
    if (document.getElementById(`alterarUnidade${id}`).options[document.getElementById(`alterarUnidade${id}`).selectedIndex].value === "")
    {
        alert("Por favor, preencha o campo Unidade.");
        return false; // Formulário inválido

    }
    if (document.getElementById(`alterarPerfil${id}`).options[document.getElementById(`alterarPerfil${id}`).selectedIndex].value === "")
    {
        alert("Por favor, preencha o campo Perfil.");
        return false; // Formulário inválido

    }else
    {
		 return true; // Formulário inválido
    }
}

setTimeout(() => {
const numeroForm = document.querySelectorAll('.contar');
for(let a = 2; a <= numeroForm.length; a++) {
    const form = document.getElementById(`myForm${a}`);

    form.addEventListener('submit', (event) => {
        event.preventDefault(); // Impede o envio padrão do formulário

        if (validaAlterarFormulario(a)) {
            // Se o formulário for válido, envie os dados
            enviarDadosAlterarFormulario(a);
        }
    });

}
}, 1000);