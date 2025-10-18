<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (file_exists($db_path)) {
    require_once $db_path;
    $section_id = 5; // Portfolio
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
<section id="portfolio" class="bg-shadow text-ice py-5" style="<?= !empty($content['color']) ? 'background:' . htmlspecialchars($content['color']) . ' !important;' : '' ?>">
  <div class="container-fluid px-0">
    <h2 class="ordem-title text-ritual mb-5 text-center" id="portfolio-title">
  <?= !empty($content['title']) ? $content['title'] : 'Campanhas de RPG' ?>
    </h2>
    <div class="row g-4" id="portfolio-content">
      <?php
      $cards = [];
      $stmtCards = $pdo->prepare('SELECT * FROM section_cards WHERE section_id = ? ORDER BY display_order, created_at');
      $stmtCards->execute([$section_id]);
      $cards = $stmtCards->fetchAll();
      if ($cards) {
        foreach ($cards as $card) {
          echo '<div class="col-md-4">';
          echo '<div class="card bg-dark h-100 border-ritual card-hover-efeito animate__animated animate__fadeInUp" style="'.(!empty($card['card_color']) ? 'background:'.htmlspecialchars($card['card_color']).' !important;' : '').'">';
          if (!empty($card['image_path'])) {
            echo '<img src="'.htmlspecialchars($card['image_path']).'" class="card-img-top" alt="Banner Campanha">';
          }
          echo '<div class="card-body">';
          if (!empty($card['title'])) {
            echo '<h5 class="card-title text-blood">'.htmlspecialchars($card['title']).'</h5>';
          }
          if (!empty($card['subtitle'])) {
            echo '<h6 class="card-subtitle mb-2 text-ice">'.htmlspecialchars($card['subtitle']).'</h6>';
          }
          if (!empty($card['content'])) {
            echo '<p class="text-ice">'.nl2br($card['content']).'</p>';
          }
          if (!empty($card['price'])) {
            echo '<span class="badge bg-gold text-dark mb-2">'.htmlspecialchars($card['price']).'</span>';
          }
          if (!empty($card['link'])) {
            echo '<a href="'.htmlspecialchars($card['link']).'" class="btn btn-ritual mt-2">Assistir</a>';
          }
          echo '</div></div></div>';
        }
      } elseif (!empty($images)) {
        foreach ($images as $img) {
          if (!empty($img['image_path'])) {
            echo '<div class="col-md-4">';
            echo '<div class="card bg-dark h-100 border-ritual card-hover-efeito animate__animated animate__fadeInUp">';
            echo '<img src="'.str_replace('/app/assets/uploads/', '/public/uploads/', htmlspecialchars($img['image_path'])).'" class="card-img-top" alt="Banner Campanha">';
            echo '<div class="card-body">';
            if (!empty($content['subtitle'])) {
              echo '<h5 class="card-title text-blood">'.htmlspecialchars($content['subtitle']).'</h5>';
            }
            if (!empty($content['content'])) {
              echo '<p class="text-ice">'.nl2br($content['content']).'</p>';
            }
            echo '<span class="text-ritual" style="font-family: \"RomanNewTimes\", \"Times New Roman\", serif; font-weight: bold;">Assistir</span>';
            echo '</div></div></div>';
          }
        }
      } else {
        ?>
        <div class="col-12">
          <div class="card bg-dark h-100 border-ritual">
            <div class="card-body">
              <h5 class="card-title text-blood">Nenhuma campanha cadastrada</h5>
              <p class="text-ice">Adicione banners das campanhas pelo admin.</p>
            </div>
          </div>
        </div>
        <?php
      }
    ?>
  </div>
</section>
