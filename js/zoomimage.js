// Configurar o efeito de zoom nas imagens
function configurarZoomImagens() {
    const imagens = document.querySelectorAll('img');
    
    imagens.forEach(imagem => {
        imagem.style.transition = "transform 0.3s ease";
        imagem.style.cursor = "pointer";
        imagem.addEventListener('click', () => {
            if (imagem.style.transform === "scale(1.5)") {
                imagem.style.transform = "scale(1)";
            } else {
                imagem.style.transform = "scale(1.5)";
            }
        });
    });
}

// Quando a página carregar, aplicar o zoom nas imagens
window.addEventListener('load', () => {
    configurarZoomImagens();
});
