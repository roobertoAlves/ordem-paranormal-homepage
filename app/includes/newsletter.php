<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (file_exists($db_path)) {
    require_once $db_path;
    $section_id = 9; // Newsletter
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
<section id="newsletter" class="bg-shadow text-ice py-5 newsletter-bg" style="<?=
  (!empty($content['color']) ? 'background:' . htmlspecialchars($content['color']) . ' !important;' : '') .
  (!empty($content['font_color']) ? 'color:' . htmlspecialchars($content['font_color']) . ' !important;' : '')
?>">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <?php if (!empty($images)): ?>
          <?php foreach ($images as $img): ?>
            <?php if (!empty($img['image_path'])): ?>
              <img src="<?= str_replace('/app/assets/uploads/', '/public/uploads/', htmlspecialchars($img['image_path'])) ?>" alt="Newsletter Ritualística" class="img-fluid newsletter-img-shadow mb-2">
            <?php endif; ?>
          <?php endforeach; ?>
        <?php else: ?>
          <img src="/ordem-paranormal-homepage/assets/img/Icones-e-simbolos/Elementos/Sangue.png" alt="Newsletter Ritualística" class="img-fluid newsletter-img-shadow">
        <?php endif; ?>
      </div>
      <div class="col-md-6">
        <h2 class="ordem-title text-blood mb-3">
          <?php if (!empty($content['title'])): ?>
            <?= $content['title'] ?>
          <?php else: ?>
            Receba Novidades & Segredos
          <?php endif; ?>
        </h2>
        <p class="lead text-ice">
          <?= !empty($content['content']) ? nl2br($content['content']) : 'Assine a newsletter e receba conteúdos exclusivos, dicas de campanhas e rituais diretamente no seu e-mail.' ?>
        </p>
        <form class="d-flex flex-column flex-md-row gap-2 mt-3">
          <input type="email" class="form-control" placeholder="<?= !empty($content['input_placeholder']) ? htmlspecialchars($content['input_placeholder']) : 'Seu e-mail' ?>" required>
          <button type="submit" class="btn btn-ritual text-blood fw-bold">
            <?= !empty($content['button_text']) ? htmlspecialchars($content['button_text']) : 'Assinar' ?>
          </button>
        </form>
      </div>
    </div>
  </div>
  <canvas id="newsletter-canvas" class="canvas-bg-absolute"></canvas>
</section>
