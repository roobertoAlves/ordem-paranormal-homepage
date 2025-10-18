<!-- Navbar principal fixa no topo -->
<nav class="navbar navbar-expand-lg navbar-dark bg-black shadow-lg fixed-top">
  <div class="container-fluid justify-content-between">
    <button id="menuToggle" class="btn btn-ritual menu-toggle-btn" type="button" aria-label="Abrir menu" style="background: #BF9B30; color: #0a1020; margin-left: 0;">
      &#9776;
    </button>
  <a href="/ordem-paranormal-homepage/app/views/admin/login.php" class="btn btn-gold text-black fw-bold ms-auto" style="background: #BF9B30; color: #0a1020; border: none;">LOGIN</a>
  </div>
</nav>
<!-- Floating Menu Content (apenas um, controlado pelo botão da navbar) -->
<div id="floatingMenu" class="floating-menu">
  <ul class="floating-menu-list">
    <li><a class="nav-link text-ritual" href="#sobre">Sobre</a></li>
    <li><a class="nav-link text-ritual" href="#funcionalidades">Funcionalidades</a></li>
    <li><a class="nav-link text-ritual" href="#beneficios">Benefícios</a></li>
    <li><a class="nav-link text-ritual" href="#planos">Planos</a></li>
    <li><a class="nav-link text-ritual" href="#faq">FAQ</a></li>
    <li><a class="nav-link text-ritual" href="#contato">Contato</a></li>
    <li><a class="nav-link text-ritual" href="#newsletter">Newsletter</a></li>
  </ul>
</div>
<script>
document.getElementById('menuToggle').onclick = function() {
  var menu = document.getElementById('floatingMenu');
  menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
};
// Fecha o menu ao clicar fora
window.addEventListener('click', function(e) {
  var menu = document.getElementById('floatingMenu');
  var btn = document.getElementById('menuToggle');
  if (menu.style.display === 'block' && !menu.contains(e.target) && e.target !== btn) {
    menu.style.display = 'none';
  }
});
</script>
<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (file_exists($db_path)) {
  require_once $db_path;
  $stmt = $pdo->prepare('SELECT * FROM section_content WHERE section_id = 1');
  $stmt->execute();
  $headerContent = $stmt->fetch();
} else {
  $headerContent = null;
}
?>
<header class="py-4 text-center bg-shadow text-ice mt-5">
  <h1 class="display-4 ordem-title text-ritual" id="main-title">
    <?= !empty($headerContent['banner_title']) ? htmlspecialchars($headerContent['banner_title']) : 'Ordem Paranormal O RPG' ?>
  </h1>
  <p class="lead text-ritual">
    <?= !empty($headerContent['banner_subtitle']) ? htmlspecialchars($headerContent['banner_subtitle']) : 'Site feito de um fã apaixonado pelo universo de Ordem Paranormal' ?>
  </p>
  <small class="text-ice">Este site é feito por fãs e não possui vínculo oficial com a série Ordem Paranormal.</small>
</header>