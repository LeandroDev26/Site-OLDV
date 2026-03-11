function alternarModoEscuro() {
    const corpo = document.getElementById('back');

    corpo.classList.toggle('modo-escuro');

    // Atualiza a imagem de fundo dependendo do modo
    if (corpo.classList.contains('modo-escuro')) {
        corpo.style.backgroundImage = "url('img/back2.png')";
    } else {
        corpo.style.backgroundImage = "url('img/back.png')"; // imagem original
    }

    const elementosParaAlterar = document.querySelectorAll('#div, #noticia, #principal, #secundario, #maestro, footer, header, .login-container');
    

    elementosParaAlterar.forEach((elemento) => {
        elemento.classList.toggle('modo-escuro');
    });
}