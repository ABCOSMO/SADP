let inputPerfil = document.getElementById('perfilOculto');
let perfil = inputPerfil.value;

/*async function generateSha256Hash(text) {
  const textEncoder = new TextEncoder();
  const data = textEncoder.encode(text);
  const hashBuffer = await crypto.subtle.digest('SHA-256', data);
  const hashArray = Array.from(new Uint8Array(hashBuffer));
  const hexHash = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
  return hexHash;
}*/
function generateSha256Hash(text) {
  // Use CryptoJS para calcular o hash SHA-256
  const hash = CryptoJS.SHA256(text);
  // Converta o hash para uma string hexadecimal
  return hash.toString(CryptoJS.enc.Hex);
}
for(let s=1; s <= 5; s++){
	let conferirPerfil = "0" + s;
	//console.log(conferirPerfil);
	const hashJS = generateSha256Hash(conferirPerfil);
	//console.log("Hash SHA-256 (JavaScript):", hashJS);
	if (hashJS === perfil) {
	if(conferirPerfil == "01"){
			let botaoEnviarDados = document.getElementById('login-button-inicial');
			if(botaoEnviarDados){
				botaoEnviarDados.remove();
			}
			
			let lancaDados = document.getElementById('lancaDados');
			if(lancaDados){
				lancaDados.remove();
			}
		}

		if(conferirPerfil != "01" && conferirPerfil != "03"){
			let menuCadastrarUsuario = document.getElementById('cadastrarUsuario');
			if(menuCadastrarUsuario){
				menuCadastrarUsuario.remove();
			}
		}
		
		if(conferirPerfil == "05"){
			let menuCadastrarUsuario = document.getElementById('cadastrarUsuario');
			let menuLancarDados = document.getElementById('lancarDados');
			if(menuCadastrarUsuario){
				menuCadastrarUsuario.remove();
			}
			
			if(menuLancarDados){
				menuLancarDados.remove();
			}
		}

		if(conferirPerfil == "03"){
			let menuDigitalizacao = document.getElementById('lista');
			if(menuDigitalizacao){
				menuDigitalizacao.remove();
			}
		}

	} else {
		console.log("Hashes NÃO correspondem.");
	}
}