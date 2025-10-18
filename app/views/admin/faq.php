<?php
session_start();
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (!file_exists($db_path)) {
  die('Erro: Não foi possível localizar o arquivo de conexão com o banco de dados.');
}
require_once $db_path;
$section_id = 8; // FAQ

// Adicionar tópico
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_faq'])) {
  $title = $_POST['title'] ?? '';
  $content = $_POST['content'] ?? '';
  $order = (int)($_POST['display_order'] ?? 0);
  $sql = 'INSERT INTO faq_items (section_id, title, content, display_order, created_at, updated_at) VALUES (?,?,?,?,NOW(),NOW())';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$section_id, $title, $content, $order]);
  header('Location: faq.php');
  exit;
}

// Excluir tópico
if (isset($_GET['delete_faq'])) {
  $deleteId = (int)$_GET['delete_faq'];
  $stmt = $pdo->prepare('DELETE FROM faq_items WHERE id = ?');
  $stmt->execute([$deleteId]);
  header('Location: faq.php');
  exit;
}

// Listar tópicos
$stmt = $pdo->prepare('SELECT * FROM faq_items WHERE section_id = ? ORDER BY display_order, created_at');
$stmt->execute([$section_id]);
$faqs = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>FAQ Dinâmico</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/ordem-paranormal-homepage/app/css/style.css">
  <style>
    body { background: var(--cor-bg-principal); color: var(--cor-ice); }
    .container { background: var(--cor-shadow); border-radius: 18px; box-shadow: 0 8px 32px #000a; padding: 2.5rem 2rem; margin-top: 4vh; }
    .ordem-title { color: var(--cor-titulo) !important; }
    .btn-ritual { background: var(--cor-ritual); color: var(--cor-bg-navbar); font-weight: bold; border-radius: 8px; }
    .btn-ritual:hover { background: var(--cor-ritual); color: var(--cor-ice); }
    .table { background: var(--cor-bg-principal); color: var(--cor-ice); }
    .table-bordered th, .table-bordered td { border-color: var(--cor-ritual); }
    .form-label, label { color: var(--cor-titulo); }
    input, textarea { background: var(--cor-bg-navbar); color: var(--cor-ice); border: 1px solid var(--cor-ritual); }
    input:focus, textarea:focus { border-color: var(--cor-gold); box-shadow: 0 0 0 2px var(--cor-gold)33; }
  </style>
</head>
<body>
<div class="container py-4">
  <h1 class="mb-4 ordem-title">FAQ Dinâmico</h1>
  <a href="edit.php?section_id=<?= $section_id ?>" class="btn btn-secondary mb-3">Voltar</a>
  <form method="post" class="mb-4">
    <div class="row g-2">
      <div class="col-md-4"><input type="text" name="title" class="form-control" placeholder="Título" required></div>
      <div class="col-md-6"><input type="text" name="content" class="form-control" placeholder="Conteúdo" required></div>
      <div class="col-md-2"><input type="number" name="display_order" class="form-control" placeholder="Ordem"></div>
      <div class="col-md-2"><button type="submit" name="add_faq" class="btn btn-ritual w-100">Adicionar Tópico</button></div>
    </div>
  </form>
  <table class="table table-bordered">
    <thead><tr><th>ID</th><th>Título</th><th>Conteúdo</th><th>Ordem</th><th>Ações</th></tr></thead>
    <tbody>
      <?php foreach ($faqs as $faq): ?>
        <tr>
          <td><?= $faq['id'] ?></td>
          <td><?= htmlspecialchars($faq['title']) ?></td>
          <td><?= htmlspecialchars($faq['content']) ?></td>
          <td><?= $faq['display_order'] ?></td>
          <td>
            <a href="faq.php?delete_faq=<?= $faq['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir este tópico?')">Excluir</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
