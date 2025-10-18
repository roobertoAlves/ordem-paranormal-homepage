<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (file_exists($db_path)) {
    require_once $db_path;
    $section_id = 2; // Sobre
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
<section id="sobre" class="bg-shadow text-ice py-5" style="<?=
  (!empty($content['color']) ? 'background:' . htmlspecialchars($content['color']) . ' !important;' : '') .
  (!empty($content['font_color']) ? 'color:' . htmlspecialchars($content['font_color']) . ' !important;' : '')
?>">
  <div class="container">
    <h2 class="ordem-title text-blood mb-4 text-center" id="sobre-title" style="font-size:clamp(2rem,6vw,3.5rem);word-break:break-word;">
      <?= !empty($content['title']) ? htmlspecialchars($content['title']) : 'O Universo de Ordem Paranormal' ?>
    </h2>
    <div class="row g-4 justify-content-center" id="sobre-cards">
      <?php
      $cards = [];
      $stmtCards = $pdo->prepare('SELECT * FROM section_cards WHERE section_id = ? ORDER BY display_order, created_at');
      $stmtCards->execute([$section_id]);
      $cards = $stmtCards->fetchAll();
      if ($cards) {
        foreach ($cards as $card) {
          echo '<div class="col-md-5">';
          echo '<div class="card h-100 text-center card-hover-efeito animate__animated animate__fadeInUp" style="'.(!empty($card['card_color']) ? 'background:'.htmlspecialchars($card['card_color']).' !important;' : '').'">';
          if (!empty($card['image_path'])) {
            echo '<img src="'.htmlspecialchars($card['image_path']).'" class="card-img-top" alt="Imagem Card">';
          }
          echo '<div class="card-body">';
          if (!empty($card['title'])) {
            echo '<h5 class="card-title text-ritual">'.htmlspecialchars($card['title']).'</h5>';
          }
          if (!empty($card['subtitle'])) {
            echo '<h6 class="card-subtitle mb-2 text-ice">'.htmlspecialchars($card['subtitle']).'</h6>';
          }
          if (!empty($card['content'])) {
            echo '<p class="card-text">'.nl2br($card['content']).'</p>';
          }
          if (!empty($card['price'])) {
            echo '<span class="badge bg-gold text-dark mb-2">'.htmlspecialchars($card['price']).'</span>';
          }
          if (!empty($card['link'])) {
            echo '<a href="'.htmlspecialchars($card['link']).'" class="btn btn-ritual mt-2">Saiba mais</a>';
          }
          echo '</div></div></div>';
        }
      } else {
        ?>
        <p class="fs-5 text-center sobre-text animate-enigma-text" id="sobre-content">
          <?= !empty($content['content']) ? nl2br($content['content']) : 'O paranormal não entra facilmente em nossa realidade. O mundo é sustentado por uma base sólida de sanidade, por isso manifestações paranormais do Outro Lado só ocorrem em locais específicos. A membrana que separa nossa realidade do Outro Lado pode ser enfraquecida pelo Medo, e diversos grupos de ocultistas fazem de tudo para enfraquecer essa barreira e invocar entidades. Por isso, foi criada a Ordo Realitas: uma organização secreta de investigadores paranormais que protegem a realidade e combatem o caos.' ?>
        </p>
        <p class="fs-6 text-center sobre-autor mt-3" id="sobre-autor">
          <?= !empty($content['subtitle']) ? $content['subtitle'] : 'O universo foi criado por Rafael Lange (Cellbit) e se expandiu para RPG de mesa, livros, quadrinhos e jogos digitais.' ?>
        </p>
        <?php if (!empty($images)): ?>
          <div class="text-center mt-3">
            <?php foreach ($images as $img): ?>
              <?php if (!empty($img['image_path'])): ?>
                <img src="<?= str_replace('/app/assets/uploads/', '/public/uploads/', htmlspecialchars($img['image_path'])) ?>" alt="Imagem sobre" class="img-fluid rounded bg-light p-2 mb-2" style="max-width:200px;">
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        <?php
      }
      ?>
    </div>
  </div>
</section>
