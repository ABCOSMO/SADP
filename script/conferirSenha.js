let matriculaInput = document.getElementById('inputMatricula');
let senha1 = document.getElementById('password1');
let senha2 = document.getElementById('password');
let botao = document.getElementById('login-button');

matriculaInput.value = mascaraMatricula(matriculaInput.value);

botao.addEventListener('click', function(event){
	let primeiraSenha = senha1.value;
	let segundaSenha = senha2.value;
	if(primeiraSenha != segundaSenha){
		alert ('Senhas divergentes. Cadastrar nova senha');
		event.preventDefault(); // Impede o comportamento padrão do botão (submit)
		return; 
	}
	if(primeiraSenha == "" || segundaSenha == ""){
		alert ('Senha em branco. Deve digitar nova senha');
		event.preventDefault(); // Impede o comportamento padrão do botão (submit)
		return; 
	}
	if(primeiraSenha == "123456" || segundaSenha == "123456"){
		alert ('Senha padrão repetida. Deve digitar nova senha');
		event.preventDefault(); // Impede o comportamento padrão do botão (submit)
		return; 
	}
});
