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
Velocity(document.querySelectorAll('.card'), 'transition.slideUpIn', { stagger: 150, duration: 700 });
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
