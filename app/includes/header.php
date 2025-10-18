<!-- Apenas o topo, sem <html>, <head> ou <body> -->
<!-- Floating Menu Button -->
<nav class="navbar navbar-dark shadow-lg navbar-floating">
  <button id="menuToggle" class="btn btn-ritual menu-toggle-btn">
    &#9776;
  </button>
</nav>

<!-- Floating Menu Content -->
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
</script>
<header class="py-4 text-center bg-shadow text-ice">
    <h1 class="display-4 ordem-title text-ritual" id="main-title">Ordem Paranormal O RPG</h1>
    <p class="lead text-ritual">Site feito de um fã apaixonado pelo universo de Ordem Paranormal</p>
    <small class="text-ice">Este site é feito por fãs e não possui vínculo oficial com a série Ordem Paranormal.</small>
</header>