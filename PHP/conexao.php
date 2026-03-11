<?php
// Detalhes de conexão com o banco de dados PostgreSQL
$host = 'localhost';
$port = '5432';
$dbname = 'orquestra_db'; // O nome do seu banco de dados
$user = 'postgres';      // O usuário padrão do PostgreSQL
$pass = '12345678'; // <<<<<< COLOQUE A SENHA DO SEU POSTGRESQL AQUI

// Data Source Name (DSN) para PostgreSQL
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

// Opções do PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Tenta estabelecer a conexão
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Em caso de falha, exibe uma mensagem de erro
    // Em um site real, você não mostraria o erro detalhado para o usuário
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>