<!-- Footer -->
<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (file_exists($db_path)) {
    require_once $db_path;
    $section_id = 10; // Footer
    $stmt = $pdo->prepare('SELECT * FROM section_content WHERE section_id = ?');
    $stmt->execute([$section_id]);
    $content = $stmt->fetch();
} else {
    $content = null;
}
?>
<footer class="bg-shadow text-ice py-4 mt-5 text-center">
  <div class="container">
    <p class="mb-1 ordem-title text-ritual" id="footer-title">
      <?= !empty($content['title']) ? htmlspecialchars($content['title']) : 'Ordem Paranormal' ?>
    </p>
    <small class="text-ritual">
      <?= !empty($content['content']) ? nl2br($content['content']) : 'Site de fã sem vínculo oficial. Todos os direitos reservados aos criadores originais.' ?>
    </small>
    <br>
    <span class="text-ice">
      <?= !empty($content['subtitle']) ? htmlspecialchars($content['subtitle']) : 'Desenvolvido por fãs para fãs &copy; 2025' ?>
    </span>
    <div id="footer-flicker" class="footer-flicker">&#x1F56F;</div>
  </div>
</footer>
<script>
// Candle Flicker Loop animação
anime({
  targets: '#footer-flicker',
  opacity: [0.6,1],
  duration: 600,
  direction: 'alternate',
  loop: true,
  easing: 'easeInOutSine'
});
</script>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js'></script>
<script src='/ordem-paranormal-homepage/js/main.js'></script>