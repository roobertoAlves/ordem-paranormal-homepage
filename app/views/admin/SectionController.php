<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (!file_exists($db_path)) {
    die('Erro: Não foi possível localizar o arquivo de conexão com o banco de dados.');
}
require_once $db_path;

class SectionController {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Listar todas as seções
    public function listSections() {
        $stmt = $this->pdo->query('SELECT * FROM sections ORDER BY display_order');
        return $stmt->fetchAll();
    }

    // Obter conteúdo de uma seção
    public function getSectionContent($section_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM section_content WHERE section_id = ?');
        $stmt->execute([$section_id]);
        return $stmt->fetch();
    }

    // Atualizar conteúdo de uma seção
    public function updateSectionContent($section_id, $data) {
        // Verifica se já existe registro
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM section_content WHERE section_id = ?');
        $stmt->execute([$section_id]);
        $exists = $stmt->fetchColumn() > 0;
        $fields = [
            'title','subtitle','content','color','font_color','card_color',
            'banner_title','banner_title_color','banner_subtitle','banner_subtitle_color',
            'button_text','link'
        ];
        $values = [];
        foreach ($fields as $f) {
            $values[$f] = $data[$f] ?? null;
        }
        if ($exists) {
            $sql = 'UPDATE section_content SET title=?, subtitle=?, content=?, color=?, font_color=?, card_color=?, banner_title=?, banner_title_color=?, banner_subtitle=?, banner_subtitle_color=?, button_text=?, link=?, updated_at=NOW() WHERE section_id=?';
            $params = array_values($values);
            $params[] = $section_id;
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } else {
            $sql = 'INSERT INTO section_content (section_id, title, subtitle, content, color, font_color, card_color, banner_title, banner_title_color, banner_subtitle, banner_subtitle_color, button_text, link, created_at, updated_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),NOW())';
            $params = array_merge([$section_id], array_values($values));
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        }
    }

    // Upload de imagem para seção
    public function uploadImage($section_id, $file) {
    $targetDir = realpath(__DIR__ . '/../../../public/uploads') . '/';
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0777, true)) {
                error_log('Falha ao criar diretório de upload: ' . $targetDir);
                return 'Erro ao criar diretório de upload.';
            }
        }
        $allowed = ['jpg','jpeg','png','gif','webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mime = mime_content_type($file['tmp_name']);
        if (!in_array($ext, $allowed)) {
            error_log('Extensão não permitida: ' . $ext);
            return 'Extensão de arquivo não permitida.';
        }
        if (strpos($mime, 'image/') !== 0) {
            error_log('Tipo MIME inválido: ' . $mime);
            return 'Tipo de arquivo não é imagem.';
        }
            // Novo padrão: img1, img2, ... por seção
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM section_images WHERE section_id = ?');
            $stmt->execute([$section_id]);
            $imgCount = (int)$stmt->fetchColumn();
            $fileName = 'img' . ($imgCount + 1) . '_' . $section_id . '.' . $ext;
        $targetFile = $targetDir . $fileName;
        if (!is_uploaded_file($file['tmp_name'])) {
            error_log('Arquivo não é upload válido: ' . print_r($file, true));
            return 'Arquivo não é upload válido.';
        }
        $moveResult = move_uploaded_file($file['tmp_name'], $targetFile);
        error_log('Tentando mover arquivo de ' . $file['tmp_name'] . ' para ' . $targetFile . ' - Resultado: ' . ($moveResult ? 'SUCESSO' : 'FALHA'));
        if (!$moveResult) {
            error_log('Falha ao mover arquivo para: ' . $targetFile . ' | Permissão pasta: ' . (is_writable($targetDir) ? 'gravável' : 'NÃO gravável'));
            return 'Falha ao salvar arquivo no servidor.';
        }
        chmod($targetFile, 0644);
    $webPath = '/ordem-paranormal-homepage/public/uploads/' . $fileName;
        $stmt = $this->pdo->prepare('INSERT INTO section_images (section_id, image_path) VALUES (?, ?)');
        $stmt->execute([$section_id, $webPath]);
        return true;
    }

    // Listar imagens de uma seção
    public function listImages($section_id) {
        $stmt = $this->pdo->prepare('SELECT * FROM section_images WHERE section_id = ?');
        $stmt->execute([$section_id]);
        return $stmt->fetchAll();
    }

    // Deletar imagem
    public function deleteImage($image_id) {
        $stmt = $this->pdo->prepare('SELECT image_path FROM section_images WHERE id = ?');
        $stmt->execute([$image_id]);
        $img = $stmt->fetch();
        if ($img) {
            $file = __DIR__ . '/../' . ltrim($img['image_path'], '/');
            if (file_exists($file)) unlink($file);
        }
        $stmt = $this->pdo->prepare('DELETE FROM section_images WHERE id = ?');
        return $stmt->execute([$image_id]);
    }
}
