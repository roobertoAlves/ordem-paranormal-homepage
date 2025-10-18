<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (!file_exists($db_path)) {
  die('Erro: Não foi possível localizar o arquivo de conexão com o banco de dados.');
}
require_once $db_path;
require_once 'SectionController.php';
$controller = new SectionController($pdo);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image_id'], $_POST['section_id'])) {
  $controller->deleteImage((int)$_POST['image_id']);
  header('Location: edit.php?section_id=' . (int)$_POST['section_id']);
  exit;
}
header('Location: index.php');
