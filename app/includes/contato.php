<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (file_exists($db_path)) {
    require_once $db_path;
    $section_id = 7; // Contato
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
<section id="contato" class="bg-dark text-ice py-5" style="<?=
  (!empty($content['color']) ? 'background:' . htmlspecialchars($content['color']) . ' !important;' : '') .
  (!empty($content['font_color']) ? 'color:' . htmlspecialchars($content['font_color']) . ' !important;' : '')
?>">
  <div class="container">
    <h2 class="ordem-title text-blood mb-5 text-center">
      <?php if (!empty($content['title'])): ?>
        <?= $content['title'] ?>
      <?php else: ?>
        Contato & Localização
      <?php endif; ?>
    </h2>
    <div class="row">
      <div class="col-md-6 mb-4 mb-md-0">
        <form class="bg-shadow p-4 rounded">
          <div class="mb-3">
            <label for="nome" class="form-label text-ritual">Nome</label>
            <input type="text" class="form-control" id="nome" placeholder="Seu nome">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label text-ritual">E-mail</label>
            <input type="email" class="form-control" id="email" placeholder="seu@email.com">
          </div>
          <div class="mb-3">
            <label for="mensagem" class="form-label text-ritual">Mensagem</label>
            <textarea class="form-control" id="mensagem" rows="4" placeholder="Digite sua mensagem..."></textarea>
          </div>
          <button type="submit" class="btn btn-ritual text-blood fw-bold">Enviar</button>
        </form>
      </div>
      <div class="col-md-6 text-center">
        <div class="mb-3">
          <?php if (!empty($images)): ?>
            <?php foreach ($images as $img): ?>
              <?php if (!empty($img['image_path'])): ?>
                <img src="<?= str_replace('/app/assets/uploads/', '/public/uploads/', htmlspecialchars($img['image_path'])) ?>" alt="Instituto Ordo Realitas" class="img-fluid contato-img-shadow mb-2">
              <?php endif; ?>
            <?php endforeach; ?>
          <?php else: ?>
            <img src="/ordem-paranormal-homepage/assets/img/Icones-e-simbolos/Elementos/Outro Lado.png" alt="Instituto Ordo Realitas" class="img-fluid contato-img-shadow">
          <?php endif; ?>
          <p class="mt-2 text-ritual">
            <?= !empty($content['subtitle']) ? $content['subtitle'] : 'Instituto Ordo Realitas<br><span class="text-ice">Localização fictícia</span>' ?>
          </p>
        </div>
        <div>
          <!-- Ícones de redes sociais removidos por não existirem na pasta -->
        </div>
      </div>
    </div>
  </div>
  <canvas id="contato-canvas" class="canvas-bg-absolute"></canvas>
</section>
