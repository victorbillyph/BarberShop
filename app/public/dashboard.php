<?php
session_start();
require_once 'db.php';

// Verificar se o usuário está autenticado e é admin
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Verificar se o usuário tem o papel de admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Obter agendamentos
$stmt = $pdo->query("SELECT * FROM appointments");
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Painel de Administração</title>
</head>
<body>
<h2>Painel de Administração</h2>
<p><a href="settings.php">Configurações</a></p>
<p><a href="admin.php">Gerenciar Usuários</a></p>
<p><a href="logout.php">Sair</a></p>

<h3>Agendamentos</h3>
<table border="1">
<tr>
<th>Cliente</th>
<th>Serviço</th>
<th>Data</th>
<th>Status</th>
<th>Ações</th>
</tr>
<?php foreach ($appointments as $appointment): ?>
<tr>
<td><?php echo htmlspecialchars($appointment['client_name']); ?></td>
<td><?php echo htmlspecialchars($appointment['service']); ?></td>
<td><?php echo $appointment['date']; ?></td>
<td><?php echo htmlspecialchars($appointment['status']); ?></td>
<td>
<a href="conclude_appointment.php?id=<?php echo $appointment['id']; ?>">Concluir</a>
<a href="delete_appointment.php?id=<?php echo $appointment['id']; ?>">Apagar</a>
</td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
