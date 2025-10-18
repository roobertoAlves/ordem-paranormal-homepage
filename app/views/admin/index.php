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
$sections = $controller->listSections();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Painel Admin - Seções do Site</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/ordem-paranormal-homepage/app/css/style.css">
  <style>
    body { background: var(--cor-bg-principal); color: var(--cor-ice); }
    .container { background: var(--cor-shadow); border-radius: 18px; box-shadow: 0 8px 32px #000a; padding: 2.5rem 2rem; margin-top: 4vh; }
    .ordem-title { color: var(--cor-titulo) !important; }
    .btn-ritual { background: var(--cor-ritual); color: var(--cor-bg-navbar); font-weight: bold; border-radius: 8px; }
    .btn-ritual:hover { background: var(--cor-ritual); color: var(--cor-ice); }
    .btn-icon { border-radius: 50%; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-right: 0.5rem; }
  </style>
</head>
<body>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="javascript:history.back()" class="btn btn-gold btn-icon" title="Voltar"><span>&#8592;</span></a>
    <a href="/ordem-paranormal-homepage/" class="btn btn-gold btn-icon" title="Home"><span>&#8962;</span></a>
  </div>
<div class="container py-4">
  <h1 class="ordem-title mb-4">Gerenciar Seções do Site</h1>
  <ul class="list-group mb-4">
    <?php
  $menuSections = ['Header', 'Hero', 'Sobre', 'Funcionalidades', 'Beneficios', 'Planos', 'FAQ', 'Contato', 'Newsletter'];
    foreach ($sections as $sec):
      if (!in_array($sec['name'], $menuSections)) continue;
    ?>
      <li class="list-group-item bg-secondary d-flex justify-content-between align-items-center">
        <span><?= htmlspecialchars($sec['name']) ?></span>
        <a href="edit.php?section_id=<?= $sec['id'] ?>" class="btn btn-sm btn-ritual">Editar</a>
      </li>
    <?php endforeach; ?>
  </ul>
  <a href="logout.php" class="btn btn-outline-danger">Sair</a>
</div>
</body>
</html>
