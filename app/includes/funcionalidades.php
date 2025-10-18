<!-- Funcionalidades do Universo -->
<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (file_exists($db_path)) {
    require_once $db_path;
    $section_id = 3; // ID da seção Funcionalidades
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
<section id="funcionalidades" class="bg-shadow text-ice py-5" style="<?=
  (!empty($content['color']) ? 'background:' . htmlspecialchars($content['color']) . ' !important;' : '') .
  (!empty($content['font_color']) ? 'color:' . htmlspecialchars($content['font_color']) . ' !important;' : '')
?>">
  <div class="container-fluid px-0">
    <h2 class="ordem-title text-blood mb-4 text-center" id="funcionalidades-title" style="font-size:clamp(2rem,6vw,3.5rem);word-break:break-word;">
      <?= !empty($content['title']) ? htmlspecialchars($content['title']) : 'Funcionalidades' ?>
    </h2>
    <div class="row g-4 justify-content-center" id="funcionalidades-content">
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
        <div class="col-md-5">
          <div class="card h-100 text-center card-hover-efeito animate__animated animate__fadeInUp">
            <div class="card-body">
              <h5 class="card-title text-ritual">Criação de Personagens</h5>
              <p class="card-text">Monte fichas completas, escolha poderes, antecedentes e personalize seu agente.</p>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="card h-100 text-center card-hover-efeito animate__animated animate__fadeInUp">
            <div class="card-body">
              <h5 class="card-title text-ritual">Sistema de Rolagem</h5>
              <p class="card-text">Role dados, aplique bônus e efeitos especiais de forma prática e visual.</p>
            </div>
          </div>
        </div>
        <?php
      }
    ?>

