<?php
session_start();
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (!file_exists($db_path)) {
  die('Erro: Não foi possível localizar o arquivo de conexão com o banco de dados.');
}
require_once $db_path;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';
  $stmt = $pdo->prepare('SELECT * FROM admin_users WHERE username = ? AND password = ?');
  $stmt->execute([$username, $password]);
  $user = $stmt->fetch();
  if ($user) {
    $_SESSION['admin_logged'] = true;
    header('Location: /ordem-paranormal-homepage/app/views/admin/index.php');
    exit;
  } else {
    $error = 'Usuário ou senha inválidos.';
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/ordem-paranormal-homepage/app/css/style.css">
  <style>
    body { background: var(--cor-bg-principal); color: var(--cor-ice); }
    .login-box { max-width: 400px; margin: 8vh auto; background: var(--cor-shadow); border-radius: 18px; box-shadow: 0 8px 32px #000a; padding: 2.5rem 2rem; }
    .ordem-title { color: var(--cor-titulo) !important; }
    .btn-ritual { background: var(--cor-ritual); color: var(--cor-bg-navbar); font-weight: bold; border-radius: 8px; }
    .btn-ritual:hover { background: var(--cor-ritual); color: var(--cor-ice); }
  </style>
</head>
<body>
  <div class="login-box position-relative">
    <h2 class="ordem-title text-center mb-4">Login Administrativo</h2>
    <?php if ($error): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form method="post">
      <div class="mb-3">
        <label class="form-label text-ritual">Usuário</label>
        <input type="text" name="username" class="form-control" required autofocus>
      </div>
      <div class="mb-3">
        <label class="form-label text-ritual">Senha</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-ritual w-100">Entrar</button>
    </form>
  </div>
  <!-- Botão de voltar para home fora do painel -->
  <a href="/ordem-paranormal-homepage/" class="btn btn-gold position-fixed top-0 end-0 m-3" title="Voltar para Home" style="z-index:2; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; background:#BF9B30; color:#0a1020;">
    &#8592;
  </a>
</body>
</html>
