<?php
// VERIFICA SE O FORMULÁRIO FOI ENVIADO
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    // Se não foi via POST, redireciona ou exibe erro
    exit('Acesso inválido.');
}

// 1. DETALHES DA CONEXÃO
$host = 'localhost';
$port = '5432';
$dbname = 'orquestra_db';
$user = 'postgres';
$pass = '12345678'; // <<<<<< COLOQUE SUA SENHA AQUI

// Data Source Name (DSN) para PostgreSQL
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

// Opções do PDO para um bom tratamento de erros
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // 2. CONECTANDO AO BANCO DE DADOS
    $pdo = new PDO($dsn, $user, $pass, $options);

    // 3. RECEBENDO DADOS DO FORMULÁRIO
    $usuario_formulario = $_POST['usuario'];
    $senha_formulario = $_POST['senha'];

    // 4. SEGURANÇA: CRIPTOGRAFANDO A SENHA (ESSENCIAL!)
    $senha_hash = password_hash($senha_formulario, PASSWORD_DEFAULT);

    // 5. PREPARANDO A INSTRUÇÃO SQL COM NAMED PLACEHOLDERS (ex: :usuario)
    $sql = "INSERT INTO usuarios (usuario, senha) VALUES (:usuario, :senha)";
    $stmt = $pdo->prepare($sql);

    // 6. EXECUTANDO A INSTRUÇÃO
    // Passamos um array associativo para o execute() que corresponde aos placeholders
    $stmt->execute([
        'usuario' => $usuario_formulario,
        'senha'   => $senha_hash
    ]);

    // 7. FEEDBACK DE SUCESSO PARA O USUÁRIO
    echo "<h1>Cadastro realizado com sucesso!</h1>";
    echo "<p>Você já pode retornar e fazer o login.</p>";
    echo '<a href="matriculas.html"><button>Ir para a página de Login</button></a>';

} catch (PDOException $e) {
    // 8. TRATAMENTO DE ERROS
    // O código '23505' é o código de erro padrão do SQL para violação de chave única (UNIQUE)
    if ($e->getCode() == '23505') {
        echo "<h1>Erro ao cadastrar.</h1>";
        echo "<p>Este nome de usuário já está em uso. Por favor, escolha outro.</p>";
        echo '<a href="formulariocadastro.html"><button>Tentar Novamente</button></a>';
    } else {
        // Para outros erros, exibe uma mensagem genérica por segurança
        // Em um ambiente de produção, você deveria registrar o erro em um log, não exibi-lo
        // error_log($e->getMessage());
        die("<h1>Ocorreu um erro inesperado ao tentar realizar o cadastro.</h1><p>Por favor, tente novamente mais tarde.</p>");
    }
} finally {
    // Fecha a conexão
    $pdo = null;
}
?>