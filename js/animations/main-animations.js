// Efeitos de texto diferentes para cada seção
window.addEventListener('DOMContentLoaded', function() {
  // Sobre: typewriter no título, fadeInUp no texto
  if(document.querySelector('#sobre .ordem-title')) {
    anime({
      targets: '#sobre .ordem-title',
      opacity: [0,1],
      translateY: [-40,0],
      duration: 1200,
      easing: 'easeOutExpo',
      update: function(anim) {
        const el = document.querySelector('#sobre .ordem-title');
        const text = 'Sobre';
        const progress = Math.round(anim.progress * text.length / 100);
        el.innerHTML = text.substring(0, progress) + '<span class="type-cursor">|</span>';
        if(progress === text.length) el.innerHTML = text;
      }
    });
    anime({
      targets: '#sobre p',
      opacity: [0,1],
      translateY: [30,0],
      delay: 400,
      duration: 900,
      easing: 'easeOutExpo'
    });
  }
  // Funcionalidades: bounceIn título, highlight texto
  if(document.querySelector('#funcionalidades .ordem-title')) {
    document.querySelector('#funcionalidades .ordem-title').classList.add('animate__animated','animate__bounceIn');
    anime({
      targets: '#funcionalidades p',
      opacity: [0,1],
      color: ['#EAEAEA','#BF9B30'],
      duration: 1200,
      easing: 'easeInOutQuad'
    });
  }
  // Benefícios: fadeInDown título, pulse texto
  if(document.querySelector('#beneficios .ordem-title')) {
    document.querySelector('#beneficios .ordem-title').classList.add('animate__animated','animate__fadeInDown');
    anime({
      targets: '#beneficios p',
      opacity: [0,1],
      scale: [0.95,1],
      duration: 1000,
      direction: 'alternate',
      loop: 2,
      easing: 'easeInOutSine'
    });
  }
  // Planos: flipInX título, fadeIn texto
  if(document.querySelector('#planos .ordem-title')) {
    document.querySelector('#planos .ordem-title').classList.add('animate__animated','animate__flipInX');
    anime({
      targets: '#planos p',
      opacity: [0,1],
      duration: 900,
      easing: 'easeOutExpo'
    });
  }
  // FAQ: zoomIn título, typewriter nas perguntas
  if(document.querySelector('#faq .ordem-title')) {
    document.querySelector('#faq .ordem-title').classList.add('animate__animated','animate__zoomIn');
    document.querySelectorAll('#faq .accordion-button').forEach(function(el) {
      const text = el.textContent;
      el.innerHTML = '';
      anime({
        targets: el,
        update: function(anim) {
          const progress = Math.round(anim.progress * text.length / 100);
          el.innerHTML = text.substring(0, progress) + '<span class="type-cursor">|</span>';
          if(progress === text.length) el.innerHTML = text;
        },
        duration: 1200 + text.length * 20,
        easing: 'linear'
      });
    });
  }
  // Enigma do Medo: fadeInLeft título, typewriter descrição
  if(document.querySelector('#enigma .ordem-title')) {
    document.querySelector('#enigma .ordem-title').classList.add('animate__animated','animate__fadeInLeft');
    const desc = document.querySelector('#enigma p');
    if(desc) {
      const text = desc.textContent;
      desc.innerHTML = '';
      anime({
        targets: desc,
        update: function(anim) {
          const progress = Math.round(anim.progress * text.length / 100);
          desc.innerHTML = text.substring(0, progress) + '<span class="type-cursor">|</span>';
          if(progress === text.length) desc.innerHTML = text;
        },
        duration: 1800 + text.length * 30,
        easing: 'linear'
      });
    }
  }
});
// Animações profissionais para todas as abas: banners, cards, textos (typewriter)
window.addEventListener('DOMContentLoaded', function() {
  // Banners: fadeIn + scale com GSAP
  gsap.utils.toArray('.banner-img, .banner-villains, #enigma img, #ramificacoes-campanhas img, #planos img, #sobre img, #funcionalidades img, #beneficios img, #faq img').forEach(function(img, i) {
    gsap.from(img, {
      opacity: 0,
      scale: 0.92,
      y: 30,
      duration: 1.1,
      delay: 0.2 + i * 0.08,
      ease: 'power3.out'
    });
  });
  // Cards: popIn com GSAP
  gsap.utils.toArray('.card').forEach(function(card, i) {
    gsap.from(card, {
      opacity: 0,
      scale: 0.85,
      y: 40,
      duration: 0.9,
      delay: 0.3 + i * 0.07,
      ease: 'back.out(1.7)'
    });
  });
  // Textos principais: efeito máquina de escrever com anime.js
  function typewriterEffect(selector, text, loop = false) {
    const el = document.querySelector(selector);
    if (!el) return;
    el.innerHTML = '';
    anime({
      targets: el,
      update: function(anim) {
        const progress = Math.round(anim.progress * text.length / 100);
        el.innerHTML = text.substring(0, progress) + '<span class="type-cursor">|</span>';
      },
      duration: 1800 + text.length * 30,
      easing: 'linear',
      complete: function() {
        el.innerHTML = text;
        if(loop) setTimeout(() => typewriterEffect(selector, text, loop), 1200);
      }
    });
  }
  // Aplica efeito máquina de escrever nos títulos principais das seções
  typewriterEffect('#sobre .ordem-title, #sobre h2', 'Sobre', false);
  typewriterEffect('#funcionalidades .ordem-title, #funcionalidades h2', 'Funcionalidades', false);
  typewriterEffect('#beneficios .ordem-title, #beneficios h2', 'Benefícios', false);
  typewriterEffect('#planos .ordem-title, #planos h2', 'Planos & Preços', false);
  typewriterEffect('#faq .ordem-title, #faq h2', 'FAQ', false);
  typewriterEffect('#enigma .ordem-title, #enigma h2', 'Enigma do Medo', false);
  // Efeito máquina de escrever para subtítulos e textos principais (opcional)
  document.querySelectorAll('.card-title, .lead, .card-text, #sobre p, #funcionalidades p, #beneficios p, #planos p, #faq p, #enigma p').forEach(function(el) {
    if(el.textContent.length > 0 && el.id && el.id.trim() !== '') {
      typewriterEffect('#'+el.id, el.textContent, false);
    }
  });
});
// Animações profissionais para imagens, banners, textos e formatos
window.addEventListener('DOMContentLoaded', function() {
  // Imagens e banners: fadeIn + scale com GSAP
  gsap.utils.toArray('img, .banner-villains, .banner-img').forEach(function(img, i) {
    gsap.from(img, {
      opacity: 0,
      scale: 0.92,
      y: 30,
      duration: 1.1,
      delay: 0.2 + i * 0.08,
      ease: 'power3.out'
    });
  });
  // Textos principais: fadeInUp com anime.js
  anime({
    targets: 'h1, h2, h3, h4, h5, h6, .ordem-title, .card-title, .lead, .card-text, p',
    opacity: [0,1],
    translateY: [40,0],
    duration: 1200,
    delay: anime.stagger(80),
    easing: 'easeOutExpo'
  });
  // Formatos especiais (cards, botões): popIn com GSAP
  gsap.utils.toArray('.card, .enigma-btn-icon, button').forEach(function(el, i) {
    gsap.from(el, {
      opacity: 0,
      scale: 0.85,
      y: 40,
      duration: 0.9,
      delay: 0.3 + i * 0.07,
      ease: 'back.out(1.7)'
    });
  });
});
// Animações Animate.css e GSAP/anime.js para todos os elementos principais
window.addEventListener('DOMContentLoaded', function() {
  // Animate.css em seções, headers, nav, divs, listas, imagens, títulos, parágrafos, links e botões
  document.querySelectorAll('section, header, .navbar, div, ul, ol, li, img, h1, h2, h3, h4, h5, h6, p, a, button').forEach(function(el) {
    el.classList.add('animate__animated','animate__fadeIn');
  });
  // Cards animados com GSAP
  gsap.from('.card', { opacity: 0, y: 40, duration: 1, stagger: 0.15, ease: 'power2.out' });
  // Títulos animados com anime.js
  anime({
    targets: '.ordem-title, h1, h2, h3, h4, h5, h6',
    opacity: [0,1],
    translateY: [-30,0],
    duration: 1200,
    delay: anime.stagger(120),
    easing: 'easeOutExpo'
  });
  // Fade-in para todos os links e botões
  anime({
    targets: 'a, button',
    opacity: [0,1],
    duration: 900,
    delay: anime.stagger(80),
    easing: 'easeOutExpo'
  });
  // Fade-in para todas as imagens
  anime({
    targets: 'img',
    opacity: [0,1],
    duration: 1000,
    delay: anime.stagger(60),
    easing: 'easeOutExpo'
  });
});
// Animação Animate.css e GSAP nos botões de ícone do Enigma do Medo
document.querySelectorAll('.animate-enigma-btn').forEach(function(btn) {
  btn.classList.add('animate__animated','animate__fadeInUp');
  gsap.fromTo(btn, {y: 40, opacity: 0}, {y: 0, opacity: 1, duration: 1, ease: 'power3.out', delay: 0.5});
  btn.addEventListener('mouseenter', function() {
    btn.classList.remove('animate__fadeInUp');
    void btn.offsetWidth;
    btn.classList.add('animate__pulse');
    gsap.to(btn, { scale: 1.12, boxShadow: '0 0 24px #e94560', duration: 0.3 });
    anime({
      targets: btn,
      rotate: [0, 6, -6, 0],
      duration: 600,
      easing: 'easeInOutSine'
    });
  });
  btn.addEventListener('mouseleave', function() {
    btn.classList.remove('animate__pulse');
    void btn.offsetWidth;
    btn.classList.add('animate__fadeInUp');
    gsap.to(btn, { scale: 1, boxShadow: '0 2px 8px #0004', duration: 0.3 });
  });
});

// Sobre: typewriter no texto principal igual ao Enigma do Medo
if(document.querySelector('#sobre .animate-enigma-text')) {
  const sobreText = document.querySelector('#sobre .animate-enigma-text');
  if(sobreText) {
    const text = sobreText.textContent;
    sobreText.innerHTML = '';
    anime({
      targets: sobreText,
      update: function(anim) {
        const progress = Math.round(anim.progress * text.length / 100);
        sobreText.innerHTML = text.substring(0, progress) + '<span class="type-cursor">|</span>';
        if(progress === text.length) sobreText.innerHTML = text;
      },
      duration: 1800 + text.length * 30,
      easing: 'linear'
    });
  }
}
// Animações globais e de seções
// Fade Ritual (Hero Title)
anime({
  targets: '#main-title',
  opacity: [0,1],
  scale: [0.8,1],
  duration: 1200,
  easing: 'easeOutExpo'
});
// Glow Fade-In (Slogan)
anime({
  targets: '.lead',
  opacity: [0,1],
  duration: 1000,
  delay: 400,
  easing: 'easeOutExpo',
  direction: 'alternate',
  loop: 2,
  update: function(anim) {
    document.querySelector('.lead').style.textShadow = '0 0 12px #BF9B30';
  }
});
// Navbar animação de entrada
if(document.querySelector('.navbar')) {
  gsap.from('.navbar', { y: -60, opacity: 0, duration: 1, ease: 'power2.out' });
}
// Sigil Pulse nos links da navbar
if(document.querySelectorAll('.nav-link')) {
  document.querySelectorAll('.nav-link').forEach(function(link){
    link.addEventListener('mouseenter', function(){
      gsap.to(link, { scale: 1.08, color: '#8C0E03', textShadow: '0 0 12px #BF9B30', duration: 0.3 });
    });
    link.addEventListener('mouseleave', function(){
      gsap.to(link, { scale: 1, color: '#EAEAEA', textShadow: 'none', duration: 0.3 });
    });
  });
}
// Candle Flicker Loop (Footer)
anime({
  targets: '#footer-flicker',
  opacity: [0.6,1],
  duration: 600,
  direction: 'alternate',
  loop: true,
  easing: 'easeInOutSine'
});
// Fade Ritual (Hero Section)
anime({
  targets: '#hero-headline',
  opacity: [0,1],
  translateY: [-50,0],
  duration: 1200,
  easing: 'easeOutExpo'
});
// Mist Rise (Sobre Section)
if(document.querySelector('#sobre')) {
  gsap.from('#sobre', { opacity: 0, y: 50, duration: 1.2, ease: 'power2.out' });
}
// Ethereal Float (Funcionalidades Cards)
if(document.querySelector('#funcionalidades .card')) {
  anime({
    targets: '#funcionalidades .card',
    opacity: [0,1],
    translateY: [40,0],
    delay: anime.stagger(200),
    duration: 900,
    easing: 'easeOutExpo'
  });
}
// Dark Slide (Portfolio Cards)
if(document.querySelector('#portfolio .card')) {
  gsap.from('#portfolio .card', { opacity: 0, y: 40, duration: 1, stagger: 0.2 });
}
// Glow Fade-In (Planos Cards)
anime({
  targets: '#planos .card',
  opacity: [0,1],
  scale: [0.9,1],
  delay: anime.stagger(200),
  duration: 900,
  easing: 'easeOutExpo'
});
// Veil Shift (FAQ Accordion)
if(document.querySelector('#faqAccordion')) {
  gsap.from('#faqAccordion', { opacity: 0, y: 40, duration: 1 });
}
// Blood Ripple (Contato Button)
if(document.querySelector('#contato .btn')) {
  document.querySelector('#contato .btn').addEventListener('click', function(e){
    let ripple = document.createElement('span');
    ripple.className = 'blood-ripple';
    ripple.style.position = 'absolute';
    ripple.style.left = e.pageX + 'px';
    ripple.style.top = e.pageY + 'px';
    ripple.style.width = '40px';
    ripple.style.height = '40px';
    ripple.style.background = 'rgba(140,14,3,0.3)';
    ripple.style.borderRadius = '50%';
    ripple.style.pointerEvents = 'none';
    ripple.style.transform = 'translate(-50%,-50%) scale(0)';
    ripple.style.transition = 'transform 0.5s, opacity 0.5s';
    document.body.appendChild(ripple);
    setTimeout(function(){
      ripple.style.transform = 'translate(-50%,-50%) scale(2)';
      ripple.style.opacity = '0';
    },10);
    setTimeout(function(){
      ripple.remove();
    },600);
  });
}
// Floating Particles (Background)
// Exemplo simples usando anime.js
for(let i=0;i<20;i++){
  let particle = document.createElement('div');
  particle.className = 'particle';
  particle.style.position = 'fixed';
  particle.style.left = Math.random()*100+'vw';
  particle.style.top = Math.random()*100+'vh';
  particle.style.width = '6px';
  particle.style.height = '6px';
  particle.style.background = '#BF9B30';
  particle.style.borderRadius = '50%';
  particle.style.opacity = '0.3';
  document.body.appendChild(particle);
  anime({
    targets: particle,
    translateY: [-20, -200],
    opacity: [0.3,0],
    duration: 6000 + Math.random()*4000,
    delay: Math.random()*2000,
    loop: true,
    easing: 'easeOutSine'
  });
}

// Animações de entrada e rolagem
// Animação Mo.js em botões e ícones
function ritualParticles(target) {
  if (!target) return;
  const burst = new mojs.Burst({
    left: 0, top: 0,
    radius:   { 0: 40 },
    count:    8,
    children: {
      shape:        'circle',
      radius:       8,
      fill:         '#BF9B30',
      strokeWidth:  2,
      duration:     700
    }
  });
  target.addEventListener('mouseenter', function(e) {
    burst.tune({ x: e.pageX, y: e.pageY }).replay();
  });
}
document.querySelectorAll('.btn, .card-title, .nav-link').forEach(ritualParticles);
