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
<section class="hero-banner" id="hero-banner">
  <?php if (!empty($images)): ?>
    <?php foreach ($images as $img): ?>
  <img src="<?= str_replace('/app/assets/uploads/', '/public/uploads/', htmlspecialchars($img['image_path'])) ?>" class="banner-img hero-img-dyn" alt="Banner Hero">
    <?php endforeach; ?>
  <?php else: ?>
    <img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/agentes-bg.jpeg" class="banner-img hero-img-dyn" alt="Banner Agentes">
  <?php endif; ?>
  <a href="<?= !empty($content['link']) ? htmlspecialchars($content['link']) : '#enigma' ?>" class="text-ritual no-underline hero-link hero-link-dyn">
    <?= !empty($content['content']) ? $content['content'] : 'Enigma do Medo' ?>
  </a>
</section>
