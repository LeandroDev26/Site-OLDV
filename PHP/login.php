<?php
// Inicia a sessão. Isso é essencial para manter o usuário logado.
session_start();

// Inclui o arquivo de conexão para reutilizar a variável $pdo
require_once 'conexao.php';

// VERIFICA SE O FORMULÁRIO FOI ENVIADO
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('Acesso inválido.');
}

// 1. RECEBENDO DADOS DO FORMULÁRIO
$usuario_formulario = $_POST['usuario'] ?? null;
$senha_formulario = $_POST['senha'] ?? null;

// Validação simples para garantir que os campos não estão vazios
if (!$usuario_formulario || !$senha_formulario) {
    die("<h1>Erro</h1><p>Por favor, preencha o nome de usuário e a senha.</p><a href='matriculas.html'><button>Tentar Novamente</button></a>");
}

try {
    // 2. BUSCANDO O USUÁRIO NO BANCO DE DADOS
    $sql = "SELECT id, usuario, senha FROM usuarios WHERE usuario = :usuario";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['usuario' => $usuario_formulario]);
    
    // fetch() retorna o usuário ou `false` se não for encontrado
    $usuario_db = $stmt->fetch();

    // 3. VERIFICANDO A SENHA
    // password_verify() compara a senha fornecida com o hash salvo no banco.
    if ($usuario_db && password_verify($senha_formulario, $usuario_db['senha'])) {
        
        // 4. LOGIN BEM-SUCEDIDO: ARMAZENA DADOS NA SESSÃO
        $_SESSION['usuario_id'] = $usuario_db['id'];
        $_SESSION['usuario_nome'] = $usuario_db['usuario'];
        
        // Redireciona para a página de inscrição
        header('Location: formulario_inscricao.html');
        exit(); // Garante que o script para após o redirecionamento

    } else {
        // Se o usuário não existe ou a senha está incorreta
        echo "<h1>Login Falhou</h1>";
        echo "<p>Nome de usuário ou senha incorretos.</p>";
        echo '<a href="matriculas.html"><button>Tentar Novamente</button></a>';
    }

} catch (PDOException $e) {
    // Erro de banco de dados
    die("<h1>Ocorreu um erro inesperado.</h1><p>Por favor, tente novamente mais tarde.</p>");
}
?>