<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (file_exists($db_path)) {
    require_once $db_path;
    $section_id = 6; // Planos
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
<section id="ramificacoes-campanhas" class="bg-shadow text-ice py-5" style="<?=
  (!empty($content['color']) ? 'background:' . htmlspecialchars($content['color']) . ' !important;' : '') .
  (!empty($content['font_color']) ? 'color:' . htmlspecialchars($content['font_color']) . ' !important;' : '')
?>">
  <div class="container-fluid px-0">
    <h2 class="ordem-title text-blood mb-4 text-center" style="font-size:clamp(2rem,6vw,3.5rem);word-break:break-word;">
      <?= !empty($content['title']) ? htmlspecialchars($content['title']) : 'Ramificações & Campanhas' ?>
    </h2>
    <div class="container-cards-campanhas mb-5">
      <div class="row g-4 justify-content-center">
        <?php
        $cards = [];
        $stmtCards = $pdo->prepare('SELECT * FROM section_cards WHERE section_id = ? ORDER BY display_order, created_at');
        $stmtCards->execute([$section_id]);
        $cards = $stmtCards->fetchAll();
        if ($cards) {
          foreach ($cards as $card) {
            echo '<div class="col-md-4">';
            echo '<div class="card h-100 text-center card-pointer card-hover-efeito animate__animated animate__fadeInUp" style="'.(!empty($card['card_color']) ? 'background:'.htmlspecialchars($card['card_color']).' !important;' : '').'">';
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
          echo '<div class="col-md-4"><a href="https://ordemparanormal.com.br/" target="_blank" class="no-underline"><div class="card h-100 text-center card-pointer card-hover-efeito"><img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/op-bg.jpg" class="card-img-top" alt="RPG de Mesa"><div class="card-body"><h5 class="card-title text-ritual">RPG de Mesa</h5><p class="card-text">Campanhas transmitidas ao vivo, expandindo o universo com mistério e investigação.</p></div></div></a></div>';
          echo '<div class="col-md-4"><a href="https://jamboeditora.com.br/produto/ordem-paranormal-iniciacao/" target="_blank" class="no-underline"><div class="card h-100 text-center card-pointer card-hover-efeito"><img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/hq-bg.png" class="card-img-top" alt="HQ Ordem Paranormal Iniciação"><div class="card-body"><h5 class="card-title text-ritual">HQ Ordem Paranormal: Iniciação</h5><p class="card-text">História oficial em quadrinhos do universo Ordem Paranormal. Disponível pela Jambô Editora.</p></div></div></a></div>';
          echo '<div class="col-md-4"><a href="#enigma" class="no-underline"><div class="card h-100 text-center card-pointer card-hover-efeito"><img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/em-bg.jpg" class="card-img-top" alt="Enigma do Medo"><div class="card-body"><h5 class="card-title text-ritual">Enigma do Medo</h5><p class="card-text">Jogo oficial de Ordem Paranormal, com exploração, sobrevivência e narrativa profunda. Clique para saber mais!</p></div></div></a></div>';
        }
      ?>
      </div>
    </div>
  </div>
</section>
  </div>
    <!-- Campanhas de RPG (cards clicáveis, sem texto 'Assistir') -->
  <div class="container-cards-campanhas mb-5">
  <div class="row g-4 mt-5">
      <div class="col-md-4">
  <a href="https://www.youtube.com/playlist?list=PL7ZwE005lvhoGkp88Ur7MBL3jXf4XqMjF" target="_blank" class="no-underline">
  <div class="card bg-dark h-100 border-ritual card-pointer card-hover-efeito">
            <img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/segredo-na-floresta-bg.jpg" class="card-img-top" alt="O Segredo na Floresta">
          <div class="card-body">
            <h5 class="card-title text-blood">O Segredo na Floresta</h5>
            <p class="text-ice">Abril 2020 - Julho 2020</p>
          </div>
        </div>
        </a>
      </div>
      <div class="col-md-4">
  <a href="https://www.youtube.com/playlist?list=PL7ZwE005lvhoeU1boBxblL0t_JL1B0Bfo" target="_blank" class="no-underline">
  <div class="card bg-dark h-100 border-ritual card-pointer card-hover-efeito">
            <img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/desconjuracao-bg.jpg" class="card-img-top" alt="Desconjuração">
          <div class="card-body">
            <h5 class="card-title text-blood">Desconjuração</h5>
            <p class="text-ice">Out 2020 - Mai 2021</p>
          </div>
        </div>
        </a>
      </div>
      <div class="col-md-4">
  <a href="https://www.youtube.com/playlist?list=PL7ZwE005lvhpwy5LoKj8FXi2MXtJyey54" target="_blank" class="no-underline">
  <div class="card bg-dark h-100 border-ritual card-pointer card-hover-efeito">
            <img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/calamidade-bg.jpg" class="card-img-top" alt="Calamidade">
          <div class="card-body">
            <h5 class="card-title text-blood">Calamidade</h5>
            <p class="text-ice">Set 2021 - Nov 2021</p>
          </div>
        </div>
        </a>
      </div>
      <div class="col-md-4">
  <a href="https://www.youtube.com/watch?v=Pf4HzTdA2WE&list=PLJ3A9Ntb1tg69P94-iQo0xCdgaBVX-ecu" target="_blank" class="no-underline">
  <div class="card bg-dark h-100 border-ritual card-pointer card-hover-efeito">
            <img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/osni-bg.jpeg" class="card-img-top" alt="O Segredo na Ilha">
          <div class="card-body">
            <h5 class="card-title text-blood">O Segredo na Ilha</h5>
            <p class="text-ice">Jun 2022 - Ago 2022</p>
          </div>
        </div>
        </a>
      </div>
      <div class="col-md-4">
  <a href="https://www.youtube.com/watch?v=va8godtJuiU&list=PLJ3A9Ntb1tg5UWwv0fsDGjPG0bp_k9pJL" target="_blank" class="no-underline">
  <div class="card bg-dark h-100 border-ritual card-pointer card-hover-efeito">
            <img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/sdol-bg.jpg" class="card-img-top" alt="Sinais do Outro Lado">
          <div class="card-body">
            <h5 class="card-title text-blood">Sinais do Outro Lado</h5>
            <p class="text-ice">Out 2022 - Dez 2022</p>
          </div>
        </div>
        </a>
      </div>
      <div class="col-md-4">
  <a href="https://www.youtube.com/watch?v=3lt1XHoYiBM&list=PLJ3A9Ntb1tg6XiRFz6l9SO34vu5AMqsPW" target="_blank" class="no-underline">
  <div class="card bg-dark h-100 border-ritual card-pointer card-hover-efeito">
            <img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/quarentena-bg.jpg" class="card-img-top" alt="Quarentena">
          <div class="card-body">
            <h5 class="card-title text-blood">Quarentena</h5>
            <p class="text-ice">Set 2023</p>
          </div>
        </div>
        </a>
      </div>
      <div class="col-md-4">
  <a href="https://www.youtube.com/watch?v=YrEdL71DYpY&list=PLJ3A9Ntb1tg6DLl1pgmYcjdtexSWjiy51" target="_blank" class="no-underline">
  <div class="card bg-dark h-100 border-ritual card-pointer card-hover-efeito">
            <img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/nm-bg.jpg" class="card-img-top" alt="Natal Macabro">
          <div class="card-body">
            <h5 class="card-title text-blood">Natal Macabro</h5>
            <p class="text-ice">Dez 2024</p>
          </div>
        </div>
        </a>
      </div>
  </div>
  </div>
    <!-- ...existing code... -->
  </div>
</section>

<!-- Enigma do Medo -->
<section id="enigma" class="bg-shadow text-ice py-5">
  <h2 class="ordem-title text-blood mb-4 text-center">Enigma do Medo</h2>
  <div class="d-flex flex-column align-items-center py-4">
  <img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/em-bg.jpg" alt="Banner Enigma do Medo" class="banner-enigma" style="margin-bottom:2rem; display:block; margin-left:auto; margin-right:auto; max-width:100%; height:auto;">
  <p class="card-text text-center enigma-desc">Enigma do Medo é o jogo oficial do universo Ordem Paranormal, desenvolvido pela Dumativa e dirigido por Cellbit. Mistura exploração, terror, sobrevivência e narrativa profunda, levando o jogador a desvendar mistérios e enfrentar ameaças sobrenaturais. Disponível para PC na Steam e Nuuvem.</p>
    <div class="row justify-content-center mt-3">
      <div class="col-auto">
        <a href="https://store.steampowered.com/app/1507580/Enigma_do_Medo/" target="_blank" title="Steam" class="enigma-btn-icon animate-enigma-btn">
          <img src="/ordem-paranormal-homepage/assets/img/Icones-e-simbolos/steam.png" alt="Steam">
        </a>
      </div>
      <div class="col-auto">
        <a href="http://nuuvem.com/fear" target="_blank" title="Nuuvem" class="enigma-btn-icon animate-enigma-btn">
          <img src="/ordem-paranormal-homepage/assets/img/Icones-e-simbolos/nuuvem.png" alt="Nuuvem">
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Planos e Preços -->
<section id="planos" class="bg-shadow text-ice py-5">
  <div class="container">
    <h2 class="ordem-title text-ritual mb-5 text-center">Planos & Preços</h2>
    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <a href="https://jamboeditora.com.br/produto/ordem-paranormal-rpg/" target="_blank" style="text-decoration:none;">
        <div class="card text-center" style="cursor:pointer;">
          <img src="/ordem-paranormal-homepage/assets/img/shop/book-ordem.png" class="card-img-top" alt="Livro Físico Ordem Paranormal RPG">
          <div class="card-body">
            <h5 class="card-title text-ritual">Livro Físico Ordem Paranormal RPG</h5>
            <p class="price">R$ 99,90</p>
            <ul class="list-unstyled mb-3">
              <li>✔ Capa dura, 400+ páginas</li>
              <li>✔ Conteúdo completo do sistema</li>
              <li>✔ Acesso ao universo oficial</li>
            </ul>
            <span class="text-ritual" style="font-family: 'RomanNewTimes', 'Times New Roman', serif; font-weight: bold;">Comprar</span>
          </div>
        </div>
        </a>
      </div>
      <div class="col-md-4">
        <a href="https://jamboeditora.com.br/produto/ordem-paranormal-rpg-pdf/" target="_blank" style="text-decoration:none;">
        <div class="card text-center" style="cursor:pointer;">
          <img src="/ordem-paranormal-homepage/assets/img/shop/book-ordem.png" class="card-img-top" alt="Livro Digital (PDF)">
          <div class="card-body">
            <h5 class="card-title text-ritual">Livro Digital (PDF)</h5>
            <p class="price">R$ 49,90</p>
            <ul class="list-unstyled mb-3">
              <li>✔ Download imediato</li>
              <li>✔ Mesma arte e conteúdo do físico</li>
              <li>✔ Leitura em qualquer dispositivo</li>
            </ul>
            <span class="text-ritual" style="font-family: 'RomanNewTimes', 'Times New Roman', serif; font-weight: bold;">Comprar PDF</span>
          </div>
        </div>
        </a>
      </div>
      <div class="col-md-4">
        <a href="https://jamboeditora.com.br/produto/ordem-paranormal-rpg/" target="_blank" style="text-decoration:none;">
        <div class="card text-center" style="cursor:pointer;">
          <img src="/ordem-paranormal-homepage/assets/img/shop/book-ordem.png" class="card-img-top" alt="Pacote Completo">
          <div class="card-body">
            <h5 class="card-title text-ritual">Pacote Completo</h5>
            <p class="price">R$ 139,90</p>
            <ul class="list-unstyled mb-3">
              <li>✔ Livro físico + PDF</li>
              <li>✔ Desconto especial</li>
              <li>✔ Brinde exclusivo</li>
            </ul>
            <span class="text-ritual" style="font-family: 'RomanNewTimes', 'Times New Roman', serif; font-weight: bold;">Comprar Pacote</span>
          </div>
        </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Banner final dos vilões -->
<div class="banner-container-fullwidth">
  <img src="/ordem-paranormal-homepage/assets/img/Banners-e-bg/villains-bg.jpeg" alt="Banner Vilões" class="banner-villains" style="object-fit:contain; width:100vw; max-height:400px; display:block; margin-left:50%; transform:translateX(-50%); border-radius:0;">
</div>
