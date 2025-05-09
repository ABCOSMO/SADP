/*function verMensagem(tag, texto) {
    let mensagem = document.querySelector(tag);
    mensagem.innerHTML = texto;
}
verMensagem('h3', 'Desenvolvido pelos CDIPs');*/

const menuDigitalizacao = document.getElementById('digitalizacao');
const listaDigitalizacao = document.getElementById('lista');

menuDigitalizacao.addEventListener('mouseover', function() {
    menuDigitalizacao.click(); // Abre o menu ao passar o mouse
});

listaDigitalizacao.addEventListener('mouseleave', function() {
    menuDigitalizacao.click(); // Fecha o menu ao sair do submenu
});


// Opcional: Fechar o menu se o mouse sair da área do cabeçalho (nav)
const cabecalho = document.querySelector('.cabecalho__links'); // Seleciona o nav principal

cabecalho.addEventListener('mouseleave', function(event) {
    // Verifica se o mouse saiu para fora do cabeçalho (e não para um elemento filho)
    if (!cabecalho.contains(event.relatedTarget)) {
        if (menuDigitalizacao.checked) { // Verifica se o menu está aberto antes de fechar
            menuDigitalizacao.click();
        }
    }
});


// Melhoria para evitar conflitos com o clique:
menuDigitalizacao.addEventListener('click', function(event) {
    event.stopPropagation(); // Impede que o clique no label propague para o checkbox
});

listaDigitalizacao.addEventListener('click', function(event) {
    event.stopPropagation(); // Impede que o clique no submenu propague para o checkbox
});

const menulogoff = document.getElementById('menuLogoff');

menuLogoff.addEventListener('mouseover', function() {
    menuLogoff.click(); // Abre o menu ao passar o mouse
});