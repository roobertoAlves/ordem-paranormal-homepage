<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordem Paranormal - Site de Fã</title>
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
  <link rel="stylesheet" href="/ordem-paranormal-homepage/app/css/style.css">
  <link rel="stylesheet" href="/ordem-paranormal-homepage/app/css/portfolio.css">
  <link rel="stylesheet" href="/ordem-paranormal-homepage/app/css/funcionalidades.css">
  <link rel="stylesheet" href="/ordem-paranormal-homepage/app/css/beneficios.css">
  <link rel="stylesheet" href="/ordem-paranormal-homepage/app/css/banners.css">
    <!-- anime.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Velocity.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/2.0.6/velocity.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/velocity/2.0.6/velocity.ui.min.js"></script>
    <!-- Mo.js -->
    <script src="https://cdn.jsdelivr.net/npm/@mojs/core"></script>
    <!-- Animações customizadas -->
    <script src="/ordem-paranormal-homepage/js/animations/main-animations.js"></script>
    <!-- API -->
    <script>
        // Carregar dados dinâmicos das seções via API e aplicar todos os campos preenchidos pelo admin
        fetch('/ordem-paranormal-homepage/app/views/admin/api.php?action=list_sections')
          .then(r => r.json())
          .then(sections => {
            sections.forEach(sec => {
              fetch(`/ordem-paranormal-homepage/app/views/admin/api.php?action=get_section_content&section_id=${sec.id}`)
                .then(r => r.json())
                .then(data => {
                  if (!data.content) return;
                  // HERO
                  if(sec.name === 'Hero') {
                    const h1 = document.querySelector('.hero-banner h1, .hero-section-main h2, #hero-headline');
                    if(h1) h1.innerHTML = data.content.title || h1.innerHTML;
                    const p = document.querySelector('.hero-banner .lead, .hero-section-main #hero-subtitle');
                    if(p) p.innerHTML = data.content.subtitle || p.innerHTML;
                    // Exibir todas as imagens cadastradas
                    if(data.images && data.images.length > 0) {
                      const imgEls = document.querySelectorAll('.hero-banner img, .hero-section-main img');
                      data.images.forEach((img, idx) => {
                        if(imgEls[idx]) imgEls[idx].src = img.image_path;
                      });
                    }
                  }
                  // SOBRE
                  if(sec.name === 'Sobre') {
                    const h2 = document.querySelector('#sobre .ordem-title');
                    if(h2) h2.innerHTML = data.content.title || h2.innerHTML;
                    const p = document.querySelector('#sobre .sobre-text');
                    if(p) p.innerHTML = data.content.content || p.innerHTML;
                  }
                  // BENEFÍCIOS
                  if(sec.name === 'Beneficios') {
                    const h2 = document.getElementById('beneficios-title');
                    if(h2) h2.innerHTML = data.content.title || h2.innerHTML;
                    // Cards dinâmicos
                    const container = document.getElementById('beneficios-content');
                    if(container && data.content && data.content.content) {
                      container.innerHTML = '';
                      // Suporte a múltiplos cards separados por ||
                      const cards = data.content.content.split('||');
                      cards.forEach(card => {
                        const [title, text] = card.split('|');
                        const div = document.createElement('div');
                        div.className = 'col-md-5';
                        div.innerHTML = `<div class="card h-100 text-center card-hover-efeito animate__animated animate__fadeInUp"><div class="card-body"><h5 class="card-title text-ritual">${title ? title.trim() : ''}</h5><p class="card-text">${text ? text.trim() : ''}</p></div></div>`;
                        container.appendChild(div);
                      });
                    }
                  }
                  // FUNCIONALIDADES
                  if(sec.name === 'Funcionalidades') {
                    const h2 = document.getElementById('funcionalidades-title');
                    if(h2) h2.innerHTML = data.content.title || h2.innerHTML;
                    const container = document.getElementById('funcionalidades-content');
                    if(container && data.content && data.content.content) {
                      container.innerHTML = '';
                      const cards = data.content.content.split('||');
                      cards.forEach(card => {
                        const [title, text] = card.split('|');
                        const div = document.createElement('div');
                        div.className = 'col-md-5';
                        div.innerHTML = `<div class="card h-100 text-center card-hover-efeito animate__animated animate__fadeInUp"><div class="card-body"><h5 class="card-title text-ritual">${title ? title.trim() : ''}</h5><p class="card-text">${text ? text.trim() : ''}</p></div></div>`;
                        container.appendChild(div);
                      });
                    }
                  }
            
                  // CONTATO
                  if(sec.name === 'Contato') {
                    const h2 = document.querySelector('#contato .ordem-title');
                    if(h2) h2.innerHTML = data.content.title || h2.innerHTML;
                  }
                  // Aplicar cor de fundo se preenchida
                  if(data.content.color) {
                    let sectionEl = document.getElementById(sec.name.toLowerCase());
                    if(sectionEl) sectionEl.style.background = data.content.color;
                  }
                  // Aplicar link se existir
                  if(data.content.link) {
                    let linkEls = document.querySelectorAll(`#${sec.name.toLowerCase()} a, .${sec.name.toLowerCase()}-link`);
                    linkEls.forEach(a => a.href = data.content.link);
                  }
                });
            });
          });
    </script>
</head>
<body class="bg-black">
<?php
include_once __DIR__ . '/../includes/header.php';
include_once __DIR__ . '/../includes/hero.php';
include_once __DIR__ . '/../includes/sobre.php';
include_once __DIR__ . '/../includes/funcionalidades.php'; 
include_once __DIR__ . '/../includes/beneficios.php';
include_once __DIR__ . '/../includes/planos.php';
include_once __DIR__ . '/../includes/faq.php';
include_once __DIR__ . '/../includes/contato.php';
include_once __DIR__ . '/../includes/newsletter.php';
// Removido segundo footer duplicado
?>
</body>
</html>