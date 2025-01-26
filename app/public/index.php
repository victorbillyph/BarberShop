<?php
session_start();
require_once 'db.php';

// Verificar se já existe um admin no banco de dados
$stmt = $pdo->query("SELECT * FROM users WHERE role = 'admin'");
$adminExists = $stmt->fetch(PDO::FETCH_ASSOC);

// Se não existir admin, redireciona para criar o admin
if (!$adminExists) {
    header("Location: create_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar usuário no banco de dados
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "E-mail ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Login</title>
</head>
<body>
<h2>Login - Sistema de Barbearia</h2>
<?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
<form action="index.php" method="POST">
<label for="email">E-mail:</label>
<input type="email" name="email" required><br><br>
<label for="password">Senha:</label>
<input type="password" name="password" required><br><br>
<button type="submit">Entrar</button>
</form>

<?php if ($_SESSION['role'] == 'admin'): ?>
<h3>Registrar Novo Funcionário</h3>
<p><a href="register_employee.php">Clique aqui para registrar um novo funcionário</a></p>
<?php endif; ?>
</body>
</html>
