<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (!file_exists($db_path)) {
  die('Erro: Não foi possível localizar o arquivo de conexão com o banco de dados.');
}
require_once $db_path;
require_once 'SectionController.php';
$controller = new SectionController($pdo);
header('Content-Type: application/json; charset=utf-8');

$action = $_GET['action'] ?? '';
$section_id = isset($_GET['section_id']) ? (int)$_GET['section_id'] : 0;

switch ($action) {
  case 'list_sections':
    echo json_encode($controller->listSections());
    break;
  case 'get_section_content':
    if ($section_id) {
      $data = $controller->getSectionContent($section_id);
      $imgs = $controller->listImages($section_id);
      echo json_encode(['content' => $data, 'images' => $imgs]);
    } else {
      http_response_code(400); echo json_encode(['error'=>'section_id obrigatório']);
    }
    break;
  default:
    http_response_code(400); echo json_encode(['error'=>'Ação inválida']);
}
