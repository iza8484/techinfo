<?php
session_start();

$usuario_admin = "admin";
$senha_correta = "123456"; 

$erro_login = "";
if (isset($_POST['logar'])) {
    $usuario_digitado = isset($_POST['user']) ? trim($_POST['user']) : '';
    $senha_digitada = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($usuario_digitado === $usuario_admin && $senha_digitada === $senha_correta) {
        $_SESSION['logado'] = true;
    } else {
        $erro_login = "Usuário ou senha incorretos!";
    }
}

if (isset($_GET['sair'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechInfo</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 360px; text-align: center; }
        h2 { color: #1a237e; margin-bottom: 20px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 12px; margin: 8px 0; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #1a237e; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; margin-top: 10px; }
        button:hover { background: #0d1b60; }
        .error { color: #d32f2f; font-size: 14px; margin-bottom: 10px; }
        .btn-voltar { display: inline-block; margin-top: 15px; color: #666; text-decoration: none; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Painel Administrativo</h2>
        <?php if (!empty($erro_login)) echo "<p class='error'>$erro_login</p>"; ?>
        <form action="admin.php" method="POST">
            <input type="text" name="user" placeholder="Usuário" required autofocus>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit" name="logar">Entrar</button>
        </form>
        <a href="index.html" class="btn-voltar">← Voltar para o Site</a>
    </div>
</body>
</html>
<?php
    exit;
}

$host = "127.0.0.1"; 
$usuario = "root";
$senha = "";
$banco = "techinfo_db"; 
$porta = 3306;

$conexao = new mysqli($host, $usuario, $senha, $banco, $porta);

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

if (isset($_GET['excluir'])) {
    $id_excluir = intval($_GET['excluir']);
    $sql_delete = "DELETE FROM matriculas WHERE id = $id_excluir";
    if ($conexao->query($sql_delete) === TRUE) {
        header("Location: admin.php");
        exit;
    }
}

$sql = "SELECT id, nome, email, telefone, curso, data_inscricao FROM matriculas ORDER BY data_inscricao DESC";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração - TechInfo</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 20px; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #1a237e; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .topo-painel { display: flex; justify-content: space-between; align-items: center; }
        .btn-voltar { display: inline-block; padding: 10px 15px; background: #333; color: white; text-decoration: none; border-radius: 4px; }
        .btn-sair { display: inline-block; padding: 10px 15px; background: #d32f2f; color: white; text-decoration: none; border-radius: 4px; }
        .btn-sair:hover { background: #b71c1c; }
        .btn-excluir { background-color: #d32f2f; color: white; padding: 6px 10px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        .btn-excluir:hover { background-color: #b71c1c; }
    </style>
</head>
<body>

    <div class="topo-painel">
        <a href="index.html" class="btn-voltar">← Voltar para o Site</a>
        <a href="admin.php?sair=true" class="btn-sair">Sair do Painel</a>
    </div>
    
    <h1>Alunos Pré-Matriculados</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Completo</th>
                <th>E-mail</th>
                <th>Telefone</th>
                <th>Curso de Interesse</th>
                <th>Data do Cadastro</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado->num_rows > 0) {
                while($linha = $resultado->fetch_assoc()) {
                    $data_formatada = date('d/m/Y H:i:s', strtotime($linha['data_inscricao']));
                    
                    echo "<tr>";
                    echo "<td>" . $linha['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($linha['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($linha['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($linha['telefone']) . "</td>";
                    echo "<td>" . htmlspecialchars($linha['curso']) . "</td>";
                    echo "<td>" . $data_formatada . "</td>";
                    
                    echo "<td><a href='admin.php?excluir=" . $linha['id'] . "' class='btn-excluir' onclick='return confirm(\"Tem certeza que deseja excluir esta matrícula?\")'>Excluir</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7' style='text-align:center;'>Nenhuma matrícula encontrada.</td></tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
<?php $conexao->close(); ?>