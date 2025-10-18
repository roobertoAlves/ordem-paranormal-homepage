<?php
session_start();
if (!isset($_SESSION['admin_logged'])) {
  header('Location: login.php');
  exit;
}
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (!file_exists($db_path)) {
  die('Erro: Não foi possível localizar o arquivo de conexão com o banco de dados.');
}
require_once $db_path;
require_once 'SectionController.php';
$controller = new SectionController($pdo);
$section_id = isset($_GET['section_id']) ? (int)$_GET['section_id'] : 0;
$section = null;
$content = null;
$images = [];
if ($section_id) {
  $sections = $controller->listSections();
  foreach ($sections as $sec) if ($sec['id'] == $section_id) $section = $sec;
  $content = $controller->getSectionContent($section_id);
  $images = $controller->listImages($section_id);
}
if (!$section) die('Seção não encontrada.');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Atualizar dados da seção
  $data = [
    'title' => $_POST['title'] ?? '',
  // 'subtitle' => $_POST['subtitle'] ?? '',
    'content' => $_POST['content'] ?? '',
    'color' => $_POST['color'] ?? 'var(--cor-bg-principal)',
    'font_color' => $_POST['font_color'] ?? 'var(--cor-titulo)',
    'card_color' => $_POST['card_color'] ?? 'var(--cor-shadow)',
    'button_text' => $_POST['button_text'] ?? '',
    'link' => $_POST['link'] ?? '',
    'input_placeholder' => $_POST['input_placeholder'] ?? '',
    'subtitle' => $_POST['subtitle'] ?? '',
    'section_name' => $section['name'] ?? ''
  ];
  if ($section['name'] === 'Header') {
    $data['banner_title'] = $_POST['banner_title'] ?? '';
    $data['banner_title_color'] = $_POST['banner_title_color'] ?? 'var(--cor-titulo)';
    $data['banner_subtitle'] = $_POST['banner_subtitle'] ?? '';
    $data['banner_subtitle_color'] = $_POST['banner_subtitle_color'] ?? 'var(--cor-ice)';
  }
  $controller->updateSectionContent($section_id, $data);

  // Upload de imagem, se enviada
  if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
    $uploadError = $_FILES['image']['error'];
    if ($uploadError !== UPLOAD_ERR_OK) {
      $_SESSION['upload_error'] = 'Erro no upload (código: ' . $uploadError . ')';
    } else {
      $uploadResult = $controller->uploadImage($section_id, $_FILES['image']);
      if ($uploadResult !== true) {
        $phpError = error_get_last();
        $phpErrorMsg = $phpError ? (' | PHP: ' . $phpError['message']) : '';
        $_SESSION['upload_error'] = $uploadResult . $phpErrorMsg;
      }
    }
  }

  // Redireciona para evitar reenvio do formulário e mostrar mensagem de sucesso
  header('Location: edit.php?section_id=' . $section_id . '&ok=1');
  exit;
}
if (isset($_GET['delete_content'])) {
  $deleteId = (int)$_GET['delete_content'];
  $stmt = $pdo->prepare('DELETE FROM section_content WHERE id = ?');
  $stmt->execute([$deleteId]);
  header('Location: edit.php?section_id=' . $section_id . '&ok=1');
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Seção - <?= htmlspecialchars($section['name']) ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/ordem-paranormal-homepage/app/css/style.css">
  <style>
    body { background: var(--cor-bg-principal); color: var(--cor-ice); }
    .container { background: var(--cor-shadow); border-radius: 18px; box-shadow: 0 8px 32px #000a; padding: 2.5rem 2rem; margin-top: 4vh; }
    .ordem-title { color: var(--cor-titulo) !important; }
    .btn-ritual { background: var(--cor-ritual); color: var(--cor-bg-navbar); font-weight: bold; border-radius: 8px; }
    .btn-ritual:hover { background: var(--cor-ritual); color: var(--cor-ice); }
  </style>
  <script src="https://cdn.tiny.cloud/1/mrgc8mcj4lw6i6irn8jqs9s0itg1i8hsqo4nuq24ds9cyxap/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
  <script>tinymce.init({ selector:'.richtext', language:'pt_BR' });</script>
</head>
<body>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="index.php" class="btn btn-gold btn-icon" title="Voltar"><span>&#8592;</span></a>
    <a href="/ordem-paranormal-homepage/" class="btn btn-gold btn-icon" title="Home"><span>&#8962;</span></a>
  </div>
  <h1 class="ordem-title mb-4">Editar Seção: <?= htmlspecialchars($section['name']) ?></h1>
  <?php if ($section['name'] === 'FAQ'): ?>
    <a href="faq.php" class="btn btn-ritual mb-3">Gerenciar Tópicos FAQ</a>
  <?php endif; ?>
  <?php if (in_array($section['name'], ['Beneficios', 'Funcionalidades', 'Planos', 'Portfolio', 'Sobre'])): ?>
    <a href="cards.php?section_id=<?= $section_id ?>" class="btn btn-ritual mb-3">Gerenciar Cards/Boxes</a>
  <?php endif; ?>
  <?php if (isset($_GET['ok'])): ?>
    <div class="alert alert-success">Alterações salvas!</div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['upload_error'])): ?>
    <div class="alert alert-danger">Erro ao enviar imagem: <?= htmlspecialchars($_SESSION['upload_error']) ?></div>
    <?php unset($_SESSION['upload_error']); ?>
  <?php endif; ?>
  <?php
  // Preenchimento automático ao editar
  if (isset($_GET['edit_content'])) {
    $editId = (int)$_GET['edit_content'];
    $stmt = $pdo->prepare('SELECT * FROM section_content WHERE id = ?');
    $stmt->execute([$editId]);
    $content = $stmt->fetch();
  }
  if (isset($_GET['edit_image'])) {
    $editId = (int)$_GET['edit_image'];
    $stmt = $pdo->prepare('SELECT * FROM section_images WHERE id = ?');
    $stmt->execute([$editId]);
    $imgEdit = $stmt->fetch();
    // Preencher campos de imagem se necessário
  }
  ?>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label text-ritual">Título</label>
      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($content['title'] ?? '') ?>">
    </div>
    <?php if (!in_array($section['name'], ['FAQ', 'Newsletter'])): ?>
    <div class="mb-3">
      <label class="form-label text-ritual">Subtítulo</label>
      <input type="text" name="subtitle" class="form-control" value="<?= htmlspecialchars($content['subtitle'] ?? '') ?>">
    </div>
    <?php endif; ?>

    <div class="mb-3">
      <label class="form-label text-ritual">Conteúdo</label>
      <textarea name="content" class="form-control richtext" rows="8"><?= htmlspecialchars($content['content'] ?? '') ?></textarea>
  <?php if ($section['name'] === 'Beneficios' || $section['name'] === 'Funcionalidades' || $section['name'] === 'Planos'): ?>
  <small class="form-text text-muted">Para criar ou editar múltiplos cards/boxes, utilize o botão <b>Gerenciar Cards/Boxes</b> acima.</small>
  <?php endif; ?>
    </div>
    <?php if ($section['name'] === 'Header' || $section['name'] === 'Hero'): ?>
    <div class="mb-3">
      <label class="form-label text-ritual">Texto do Botão</label>
      <input type="text" name="button_text" class="form-control" value="<?= htmlspecialchars($content['button_text'] ?? '') ?>">
    </div>
    <?php endif; ?>
    <div class="mb-3">
      <label class="form-label text-ritual">Cor de Fundo (hex ou nome)</label>
      <input type="text" name="color" class="form-control" value="<?= htmlspecialchars($content['color'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label text-ritual">Cor da Fonte (hex ou nome)</label>
      <input type="text" name="font_color" class="form-control" value="<?= htmlspecialchars($content['font_color'] ?? '') ?>">
    </div>
    <?php if (in_array($section['name'], ['Beneficios', 'Funcionalidades'])): ?>
    <div class="mb-3">
      <label class="form-label text-ritual">Cor do Card/Retângulo (hex ou nome)</label>
      <input type="text" name="card_color" class="form-control" value="<?= htmlspecialchars($content['card_color'] ?? '') ?>">
    </div>
    <?php endif; ?>
    <?php if ($section['name'] === 'Header'): ?>
    <div class="mb-3">
      <label class="form-label text-ritual">Imagem do Banner</label>
      <input type="file" name="banner_image" class="form-control">
      <?php if (!empty($images['banner'])): ?>
        <img src="/uploads/<?= htmlspecialchars($images['banner']) ?>" alt="Banner" style="max-width: 300px; margin-top: 10px;">
      <?php endif; ?>
    </div>
    <div class="mb-3">
      <label class="form-label text-ritual">Título do Banner</label>
      <input type="text" name="banner_title" class="form-control" value="<?= htmlspecialchars($content['banner_title'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label text-ritual">Cor do Título</label>
      <input type="text" name="banner_title_color" class="form-control" value="<?= htmlspecialchars($content['banner_title_color'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label text-ritual">Subtítulo do Banner</label>
      <input type="text" name="banner_subtitle" class="form-control" value="<?= htmlspecialchars($content['banner_subtitle'] ?? '') ?>">
    </div>
    <div class="mb-3">
      <label class="form-label text-ritual">Cor do Subtítulo</label>
      <input type="text" name="banner_subtitle_color" class="form-control" value="<?= htmlspecialchars($content['banner_subtitle_color'] ?? '') ?>">
    </div>
    <?php endif; ?>
    <div class="mb-3">
      <label class="form-label text-ritual">Link</label>
      <input type="text" name="link" class="form-control" value="<?= htmlspecialchars($content['link'] ?? '') ?>">
    </div>
    <?php if (!in_array($section['name'], ['FAQ', 'Newsletter'])): ?>
    <div class="mb-3">
      <label class="form-label text-ritual">Imagem (upload)</label>
      <input type="file" name="image" class="form-control" id="imageInput">
      <div id="imagePreview" class="mt-2"></div>
    </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-ritual">Salvar</button>
    <a href="index.php" class="btn btn-secondary">Voltar</a>
  </form>
  <hr>
    <!-- CRUD Listagem de conteúdos e imagens cadastrados -->
    <?php
    // Listagem CRUD das edições feitas
    // $pdo já está disponível via require_once no topo do arquivo
    $sectionName = $section['name'] ?? '';
    if ($sectionName) {
      // Listar conteúdos
  $stmt = $pdo->prepare('SELECT * FROM section_content WHERE section_id = ? ORDER BY updated_at DESC');
  $stmt->execute([$section_id]);
      $contents = $stmt->fetchAll(PDO::FETCH_ASSOC);

      // Listar imagens
  $stmtImg = $pdo->prepare('SELECT * FROM section_images WHERE section_id = ? ORDER BY created_at DESC');
  $stmtImg->execute([$section_id]);
      $imagesCrud = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

      echo '<h3>Conteúdos e Imagens cadastrados</h3>';
      $allItems = [];
      // Adiciona conteúdos
      foreach ($contents as $row) {
        $allItems[] = [
          'id' => $row['id'],
          'tipo' => 'Conteúdo',
          'campo' => $row['field'] ?? '',
          'valor' => $row['content'] ?? '',
          'data' => $row['updated_at'] ?? $row['created_at'],
          'edit_url' => 'edit.php?section_id=' . $section_id . '&edit_content=' . $row['id'],
          'delete_url' => 'edit.php?section_id=' . $section_id . '&delete_content=' . $row['id']
        ];
      }
      // Adiciona imagens
      foreach ($imagesCrud as $img) {
        $allItems[] = [
          'id' => $img['id'],
          'tipo' => 'Imagem',
          'campo' => $img['alt_text'] ?? '',
          'valor' => $img['image_path'] ?? '',
          'data' => $img['created_at'],
          'edit_url' => 'edit.php?section_id=' . $section_id . '&edit_image=' . $img['id'],
          'delete_url' => 'edit.php?section_id=' . $section_id . '&delete_image=' . $img['id']
        ];
      }
      if ($allItems) {
        echo '<table class="table table-bordered"><thead><tr><th>ID</th><th>Tipo</th><th>Título</th><th>Subtítulo</th><th>Texto</th><th>Cor</th><th>Banner</th><th>Botão</th><th>Link</th><th>Imagem</th><th>Data</th><th>Ações</th></tr></thead><tbody>';
        foreach ($contents as $row) {
          echo '<tr>';
          echo '<td>' . $row['id'] . '</td>';
          echo '<td>Conteúdo</td>';
          echo '<td>' . htmlspecialchars($row['title'] ?? '') . '</td>';
          echo '<td>' . htmlspecialchars($row['subtitle'] ?? '') . '</td>';
          echo '<td>' . htmlspecialchars($row['content'] ?? '') . '</td>';
          echo '<td>' . htmlspecialchars($row['color'] ?? '') . '</td>';
          echo '<td>' . htmlspecialchars($row['banner_title'] ?? '') . '<br>' . htmlspecialchars($row['banner_subtitle'] ?? '') . '</td>';
          echo '<td>' . htmlspecialchars($row['button_text'] ?? '') . '</td>';
          echo '<td>' . htmlspecialchars($row['link'] ?? '') . '</td>';
          echo '<td></td>';
          echo '<td>' . ($row['updated_at'] ?? $row['created_at']) . '</td>';
          echo '<td>';
          echo '<a href="edit.php?section_id=' . $section_id . '&edit_content=' . $row['id'] . '" class="btn btn-sm btn-primary">Editar</a> ';
          echo '<a href="edit.php?section_id=' . $section_id . '&delete_content=' . $row['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Excluir este conteúdo?\')">Excluir</a>';
          echo '</td>';
          echo '</tr>';
        }
        foreach ($imagesCrud as $img) {
          echo '<tr>';
          echo '<td>' . $img['id'] . '</td>';
          echo '<td>Imagem</td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td></td>';
          echo '<td><img src="' . htmlspecialchars($img['image_path']) . '" style="max-width:100px;max-height:60px;" alt="img"></td>';
          echo '<td>' . $img['created_at'] . '</td>';
          echo '<td>';
          echo '<a href="edit.php?section_id=' . $section_id . '&edit_image=' . $img['id'] . '" class="btn btn-sm btn-primary">Editar</a> ';
          echo '<a href="edit.php?section_id=' . $section_id . '&delete_image=' . $img['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Excluir esta imagem?\')">Excluir</a>';
          echo '</td>';
          echo '</tr>';
        }
        echo '</tbody></table>';
      } else {
        echo '<p>Nenhum conteúdo ou imagem cadastrado.</p>';
      }
    }
    ?>
  <h4 class="ordem-title">Imagens da Seção</h4>

  <div class="row">
    <?php foreach ($images as $img): ?>
      <div class="col-md-3 mb-3">
  <img src="<?= str_replace('/app/assets/uploads/', '/public/uploads/', htmlspecialchars($img['image_path'])) ?>" class="img-fluid rounded bg-light p-2" alt="Imagem da seção">
        <form method="post" action="delete_image.php" onsubmit="return confirm('Remover imagem?');">
          <input type="hidden" name="image_id" value="<?= $img['id'] ?>">
          <input type="hidden" name="section_id" value="<?= $section_id ?>">
          <button type="submit" class="btn btn-sm btn-danger mt-2">Remover</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
  <script>
    // Preview da imagem selecionada
    document.addEventListener('DOMContentLoaded', function() {
      var input = document.getElementById('imageInput');
      var preview = document.getElementById('imagePreview');
      if(input) {
        input.addEventListener('change', function(e) {
          preview.innerHTML = '';
          if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(ev) {
              var img = document.createElement('img');
              img.src = ev.target.result;
              img.className = 'img-fluid rounded bg-light p-2';
              img.style.maxWidth = '200px';
              preview.appendChild(img);
            };
            reader.readAsDataURL(input.files[0]);
          }
        });
      }
    });
  </script>
</div>
</body>
</html>
