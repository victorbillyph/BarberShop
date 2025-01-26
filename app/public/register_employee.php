<?php
session_start();
require_once 'db.php';

// Verificar se o usuário está autenticado e é admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];

    // Validar se as senhas são iguais
    if ($password !== $passwordConfirm) {
        $error = "As senhas não coincidem.";
    } else {
        // Hash da senha
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Inserir o funcionário no banco de dados
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword, 'employee']);
        $message = "Funcionário registrado com sucesso!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Cadastrar Funcionário</title>
</head>
<body>
<h2>Cadastrar Novo Funcionário</h2>
<?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
<?php if (isset($message)) echo "<p style='color: green;'>$message</p>"; ?>

<form action="register_employee.php" method="POST">
<label for="name">Nome:</label>
<input type="text" name="name" required><br><br>

<label for="email">E-mail:</label>
<input type="email" name="email" required><br><br>

<label for="password">Senha:</label>
<input type="password" name="password" required><br><br>

<label for="password_confirm">Confirmar Senha:</label>
<input type="password" name="password_confirm" required><br><br>

<button type="submit">Registrar Funcionário</button>
</form>

<p><a href="dashboard.php">Voltar ao Painel</a></p>
</body>
</html>
