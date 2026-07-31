<?php
header('Content-Type: application/json; charset=utf-8');


$host = getenv('MYSQLHOST') ?: '127.0.0.1';
$user = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: '';
$database = getenv('MYSQLDATABASE') ?: 'techinfo_db';
$port = getenv('MYSQLPORT') ?: 3306;

$conexao = new mysqli($host, $user, $password, $database, $port);

if ($conexao->connect_error) {
    echo json_encode(["status" => "erro", "mensagem" => "Falha na conexão: " . $conexao->connect_error]);
    exit;
}

$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$telefone = isset($_POST['telefone']) ? trim($_POST['telefone']) : '';
$curso = isset($_POST['curso-interesse']) ? trim($_POST['curso-interesse']) : '';

$stmt = $conexao->prepare("INSERT INTO matriculas (nome, email, telefone, curso) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nome, $email, $telefone, $curso);

if ($stmt->execute()) {
    echo json_encode(["status" => "sucesso", "mensagem" => "Matrícula realizada com sucesso!"]);
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao salvar no banco: " . $stmt->error]);
}

$stmt->close();
$conexao->close();
?>