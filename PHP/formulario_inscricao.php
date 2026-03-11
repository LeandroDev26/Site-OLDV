<?php

// Inicia a sessão para verificar se o usuário está logado
session_start();

// Se a variável de sessão 'usuario_id' não existir, significa que o usuário não está logado.
if (!isset($_SESSION['usuario_id'])) {
    // Redireciona para a página de login e encerra o script.
    header('Location: matriculas.html');
    exit();
}

// Inclui o arquivo de conexão para ter acesso à variável $pdo
require_once 'conexao.php';

// Inclui o arquivo de conexão para ter acesso à variável $pdo
require_once 'conexao.php';

// Verifica se o formulário foi enviado usando o método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Pega os dados do formulário de forma segura
    $nome = htmlspecialchars($_POST['nome']);
    $idade = htmlspecialchars($_POST['idade']);
    $instrumento = htmlspecialchars($_POST['instrumento']);
    $tempo = htmlspecialchars($_POST['tempo']);
    $telefone = htmlspecialchars($_POST['telefone']);
    $email = htmlspecialchars($_POST['email']);

    try {
        // Prepara a instrução SQL para evitar injeção de SQL
        $sql = "INSERT INTO inscricoes (nome_completo, idade, instrumento, tempo_experiencia, telefone, email) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        
        // Executa a instrução, passando os valores do formulário
        $stmt->execute([$nome, $idade, $instrumento, $tempo, $telefone, $email]);

        // Exibe uma mensagem de sucesso para o usuário
        echo "<h1>Inscrição realizada com sucesso!</h1>";
        echo "<p>Obrigado, $nome. Seus dados foram recebidos e em breve entraremos em contato.</p>";
        echo '<br><a href="index.html">Voltar à página inicial</a>';

    } catch (PDOException $e) {
        // Se ocorrer um erro no banco de dados, exibe uma mensagem genérica
        echo "<h1>Ocorreu um erro ao processar sua inscrição.</h1>";
        echo "<p>Por favor, tente novamente mais tarde.</p>";
        // Para depuração, você pode descomentar a linha abaixo para ver o erro real:
        // error_log("Erro de banco de dados: " . $e->getMessage());
    }

} else {
    // Se o script for acessado diretamente sem enviar o formulário
    echo "Nenhum dado enviado. Por favor, preencha o formulário de inscrição.";
}
?>