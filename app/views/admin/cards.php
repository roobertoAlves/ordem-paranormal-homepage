<?php
session_start();
require_once __DIR__ . '/../../factory/db.php';
$section_id = isset($_GET['section_id']) ? (int)$_GET['section_id'] : 0;
if (!$section_id) die('Seção não informada.');
// Adicionar card
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fields = ['title','subtitle','content','color','card_color','font_color','link','price'];
  $data = [];
  foreach ($fields as $f) {
    $data[$f] = $_POST[$f] ?? '';
  }
  $image_path = '';
  if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
    $targetDir = realpath(__DIR__ . '/../../../public/uploads') . '/';
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $fileName = 'card_' . time() . '_' . rand(1000,9999) . '.' . $ext;
    $targetFile = $targetDir . $fileName;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
      $image_path = '/ordem-paranormal-homepage/public/uploads/' . $fileName;
    }
  }
  $sql = 'INSERT INTO section_cards (section_id, title, subtitle, content, color, card_color, font_color, link, price, image_path, created_at, updated_at) VALUES (?,?,?,?,?,?,?,?,?,?,NOW(),NOW())';
  $params = [$section_id, $data['title'], $data['subtitle'], $data['content'], $data['color'], $data['card_color'], $data['font_color'], $data['link'], $data['price'], $image_path];
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  header('Location: cards.php?section_id=' . $section_id);
  exit;
}

// Excluir card
if (isset($_GET['delete_card'])) {
  $deleteId = (int)$_GET['delete_card'];
  $stmt = $pdo->prepare('DELETE FROM section_cards WHERE id = ?');
  $stmt->execute([$deleteId]);
  header('Location: cards.php?section_id=' . $section_id);
  exit;
}

// Listar cards
$stmt = $pdo->prepare('SELECT * FROM section_cards WHERE section_id = ? ORDER BY display_order, created_at');
$stmt->execute([$section_id]);
$cards = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cards da Seção</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container py-4">
  <h1 class="mb-4 ordem-title">Cards da Seção</h1>
  <a href="edit.php?section_id=<?= $section_id ?>" class="btn btn-secondary mb-3">Voltar</a>
  <form method="post" enctype="multipart/form-data" class="mb-4">
    <div class="row g-2">
      <div class="col-md-3"><input type="text" name="title" class="form-control" placeholder="Título"></div>
      <div class="col-md-3"><input type="text" name="subtitle" class="form-control" placeholder="Subtítulo"></div>
      <div class="col-md-3"><input type="text" name="content" class="form-control" placeholder="Texto"></div>
      <div class="col-md-2"><input type="text" name="color" class="form-control" placeholder="Cor"></div>
      <div class="col-md-2"><input type="text" name="card_color" class="form-control" placeholder="Cor Card"></div>
      <div class="col-md-2"><input type="text" name="font_color" class="form-control" placeholder="Cor Fonte"></div>
      <div class="col-md-2"><input type="text" name="link" class="form-control" placeholder="Link"></div>
      <div class="col-md-2"><input type="text" name="price" class="form-control" placeholder="Preço"></div>
      <div class="col-md-2"><input type="file" name="image" class="form-control"></div>
      <div class="col-md-2"><button type="submit" class="btn btn-ritual w-100">Adicionar Card</button></div>
    </div>
  </form>
  <table class="table table-bordered">
    <thead><tr><th>ID</th><th>Título</th><th>Subtítulo</th><th>Texto</th><th>Cor</th><th>Cor Card</th><th>Cor Fonte</th><th>Link</th><th>Preço</th><th>Imagem</th><th>Ações</th></tr></thead>
    <tbody>
      <?php foreach ($cards as $card): ?>
        <tr>
          <td><?= $card['id'] ?></td>
          <td><?= htmlspecialchars($card['title']) ?></td>
          <td><?= htmlspecialchars($card['subtitle']) ?></td>
          <td><?= htmlspecialchars($card['content']) ?></td>
          <td><?= htmlspecialchars($card['color']) ?></td>
          <td><?= htmlspecialchars($card['card_color']) ?></td>
          <td><?= htmlspecialchars($card['font_color']) ?></td>
          <td><?= htmlspecialchars($card['link']) ?></td>
          <td><?= htmlspecialchars($card['price']) ?></td>
          <td><?php if (!empty($card['image_path'])): ?><img src="<?= htmlspecialchars($card['image_path']) ?>" style="max-width:80px;max-height:60px;" alt="img"><?php endif; ?></td>
          <td>
            <a href="cards.php?section_id=<?= $section_id ?>&edit_card=<?= $card['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
            <a href="cards.php?section_id=<?= $section_id ?>&delete_card=<?= $card['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Excluir este card?')">Excluir</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
