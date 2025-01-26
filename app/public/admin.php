<?php
session_start();
require_once 'db.php';

// Verificar se o usuário está autenticado e é admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Listar usuários
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Gerenciar Usuários</title>
</head>
<body>
<h2>Gerenciar Usuários</h2>
<p><a href="dashboard.php">Voltar ao painel</a></p>

<h3>Usuários Cadastrados</h3>
<table border="1">
<tr>
<th>Nome</th>
<th>E-mail</th>
<th>Função</th>
<th>Ações</th>
</tr>
<?php foreach ($users as $user): ?>
<tr>
<td><?php echo htmlspecialchars($user['name']); ?></td>
<td><?php echo htmlspecialchars($user['email']); ?></td>
<td><?php echo htmlspecialchars($user['role']); ?></td>
<td>
<a href="edit_user.php?id=<?php echo $user['id']; ?>">Editar</a>
<a href="delete_user.php?id=<?php echo $user['id']; ?>">Excluir</a>
</td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
