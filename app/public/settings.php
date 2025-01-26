<?php
session_start();
require_once 'db.php';

// Verificar se o usuário está autenticado e é admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];

    // Verificar a senha atual
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($currentPassword, $user['password'])) {
        // Atualizar a senha
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        $updateStmt->execute(['password' => $hashedPassword, 'id' => $_SESSION['user_id']]);
        $message = "Senha alterada com sucesso!";
    } else {
        $message = "Senha atual incorreta.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Configurações</title>
</head>
<body>
<h2>Alterar Senha</h2>
<?php if (isset($message)) echo "<p>$message</p>"; ?>
<form action="settings.php" method="POST">
<label for="current_password">Senha Atual:</label>
<input type="password" name="current_password" required><br><br>
<label for="new_password">Nova Senha:</label>
<input type="password" name="new_password" required><br><br>
<button type="submit">Alterar Senha</button>
</form>
<p><a href="dashboard.php">Voltar ao painel</a></p>
</body>
</html>
