function verMensagem(tag, texto) {
    let mensagem = document.querySelector(tag);
    mensagem.innerHTML = texto;
}
verMensagem('h3', 'Desenvolvido pelos CDIPs');

let openButtons = document.querySelectorAll('.open-modal');

openButtons.forEach(button => {
    button.addEventListener('click', () => {
        let modalId = button.getAttribute('data-modal');
        let modal = document.getElementById(modalId);

        modal.showModal();
    });
});

let closeButtons = document.querySelectorAll('.close-modal');

closeButtons.forEach(button => {
    button.addEventListener('click', () => {
        let modalId = button.getAttribute('data-modal');
        let modal = document.getElementById(modalId);

        modal.close();
    });
});

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

function isValidEmail(email) {
    // Expressão regular para validar email
    const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }

function validaFormulario(){
    if (document.autenticar.inputNome.value === "")
    {
        alert("Por favor, preencha o campo Nome.");
        return false; // Formulário inválido

    }
    if (document.autenticar.inputMatricula.value === "")
    {
        alert("Por favor, preencha o campo Matrícula.");
        return false; // Formulário inválido

    }
    if (!isValidEmail(document.autenticar.inputEmail.value)) {
        alert("Por favor, insira um endereço de e-mail válido.");
        return false;
      }
    /*if (document.autenticar.inputEmail.value === "")
    {
        alert("Por favor, preencha o campo e-mail.");
        return false; // Formulário inválido

    }*/
    if (document.autenticar.inputTelefone.value === "")
    {
        alert("Por favor, preencha o campo Telefone.");
        return false; // Formulário inválido

    }
    if (autenticar.unidade.options[autenticar.unidade.selectedIndex].value === "")
    {
        alert("Por favor, preencha o campo Unidade.");
        return false; // Formulário inválido

    }
    if (autenticar.perfil.options[autenticar.perfil.selectedIndex].value === "")
    {
        alert("Por favor, preencha o campo Perfil.");
        return false; // Formulário inválido

    }
    if (document.autenticar.password.value === "")
    {
        alert("Por favor, preencha o campo Senha.");
        return false; // Formulário inválido
    }else
    {
    return true; // Formulário válido
    }
}

function enviarDadosFormulario()
{
const form = document.getElementById('myForm');
const loading = document.querySelector('.loading');

form.addEventListener('submit', (event) => {
    event.preventDefault();
    loading.style.display = 'block';
    const formData = new FormData(form);
    console.log(formData);

    fetch('/sadp/cadastro/controllerCadastro.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Recebe a resposta como JSON
    .then(data => {
        loading.style.display = 'none';
        console.log(data);
        // Processa a resposta JSON, por exemplo, exibindo uma mensagem
        if (data.success) {
            alert('Dados enviados com sucesso');
            window.location.href = '/sadp/producao/';
            /*verMensagem('p', 'Dados enviados com sucesso');*/
        } else {
            alert('Erro ao enviar os dados: ' + data.error);
        }
    })
    .catch(error => {
        loading.style.display = 'none';
        console.error('Erro ao enviar os dados:', error);
        alert('Erro ao enviar os dados');
    });
});
}

enviarDadosFormulario();