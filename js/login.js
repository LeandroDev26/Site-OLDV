function login() {
    let user = document.getElementById('username').value;
    let pass = document.getElementById('password').value;
    
    if (user === "user" && pass === "1234") {
        window.location.href = "formulario_inscricao.html";
    } else {
        alert("Usuário ou senha incorretos! Tente novamente.");
    }
}