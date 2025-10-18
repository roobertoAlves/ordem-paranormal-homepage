<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (file_exists($db_path)) {
    require_once $db_path;
    $section_id = 1; // Hero
    $stmt = $pdo->prepare('SELECT * FROM section_content WHERE section_id = ?');
    $stmt->execute([$section_id]);
    $content = $stmt->fetch();
    $stmt2 = $pdo->prepare('SELECT * FROM section_images WHERE section_id = ?');
    $stmt2->execute([$section_id]);
    $images = $stmt2->fetchAll();
} else {
    $content = null;
    $images = [];
}
?>
<section id="hero" class="hero text-center py-5">
    <?php if (!empty($images)): ?>
        <?php foreach ($images as $i => $img): ?>
            <img src="<?= str_replace('/app/assets/uploads/', '/public/uploads/', htmlspecialchars($img['image_path'])) ?>" alt="Banner Hero" class="img-fluid mb-4 rounded shadow">
            <?php if ($i === 0): ?>
                <h2 class="display-5 mb-3"><?= !empty($content['title']) ? $content['title'] : 'Entre no Mistério' ?></h2>
                <p class="lead mb-4"><?= !empty($content['content']) ? $content['content'] : (!empty($content['subtitle']) ? $content['subtitle'] : 'O RPG brasileiro que une o oculto, o medo e o desconhecido em uma experiência única.') ?></p>
                <a href="<?= !empty($content['link']) ? htmlspecialchars($content['link']) : 'index.php?page=sobre' ?>" class="btn btn-ritual btn-lg">
                    <?= !empty($content['button_text']) ? $content['button_text'] : 'Conheça o Jogo' ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/blood-bg.jpg" alt="Ordem Paranormal Banner" class="img-fluid mb-4 rounded shadow">
        <h2 class="display-5 mb-3"><?= !empty($content['title']) ? $content['title'] : 'Entre no Mistério' ?></h2>
        <p class="lead mb-4"><?= !empty($content['content']) ? $content['content'] : (!empty($content['subtitle']) ? $content['subtitle'] : 'O RPG brasileiro que une o oculto, o medo e o desconhecido em uma experiência única.') ?></p>
        <a href="<?= !empty($content['link']) ? htmlspecialchars($content['link']) : 'index.php?page=sobre' ?>" class="btn btn-ritual btn-lg">
            <?= !empty($content['button_text']) ? $content['button_text'] : 'Conheça o Jogo' ?>
        </a>
    <?php endif; ?>
</section>
