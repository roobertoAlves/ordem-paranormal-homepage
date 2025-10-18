<?php
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/ordem-paranormal-homepage/app/factory/db.php';
if (file_exists($db_path)) {
    require_once $db_path;
    $section_id = 8; // FAQ
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
<section id="faq" class="bg-shadow text-ice py-5">
<style>
  #faq .accordion-button {
    color: #fff !important;
    background: #181a1f !important;
    border-bottom: 1px solid #444 !important;
  }
  #faq .accordion-button.collapsed {
    color: #fff !important;
    background: #23242a !important;
  }
  #faq .accordion-body {
    color: #fff !important;
    background: #23242a !important;
    border-radius: 0 0 8px 8px;
  }
  #faq .accordion-item {
    border: 1px solid #BF9B30 !important;
    background: #181a1f !important;
  }
</style>
  <div class="container">
  <h2 class="ordem-title text-ritual mb-5 text-center" style="font-size:clamp(2.2rem,6vw,3.5rem);word-break:break-word;">
    <?php if (!empty($content['title'])): ?>
      <?= $content['title'] ?>
    <?php else: ?>
      Perguntas Frequentes
    <?php endif; ?>
  </h2>
    <div class="row">
      <div class="col-md-7">
        <?php
        $faq_items = [];
        $stmtFaq = $pdo->prepare('SELECT * FROM faq_items WHERE section_id = ? ORDER BY display_order, created_at');
        $stmtFaq->execute([$section_id]);
        $faq_items = $stmtFaq->fetchAll();
        if ($faq_items) {
          echo '<div class="accordion" id="faqAccordion">';
          foreach ($faq_items as $i => $faq) {
            $collapseId = 'collapse' . ($i+1);
            $headerId = 'faq' . ($i+1);
            $show = $i === 0 ? 'show' : '';
            $expanded = $i === 0 ? 'true' : 'false';
            $collapsed = $i === 0 ? '' : 'collapsed';
            echo '<div class="accordion-item bg-dark border-ritual">';
            echo '<h2 class="accordion-header" id="'.$headerId.'">';
            echo '<button class="accordion-button bg-shadow text-ice '.$collapsed.'" type="button" data-bs-toggle="collapse" data-bs-target="#'.$collapseId.'" aria-expanded="'.$expanded.'" aria-controls="'.$collapseId.'">'.htmlspecialchars($faq['title']).'</button>';
            echo '</h2>';
            echo '<div id="'.$collapseId.'" class="accordion-collapse collapse '.$show.'" aria-labelledby="'.$headerId.'" data-bs-parent="#faqAccordion">';
            echo '<div class="accordion-body">'.nl2br($faq['content']).'</div>';
            echo '</div></div>';
          }
          echo '</div>';
        } else {
        ?>
          <div class="accordion" id="faqAccordion">
            <div class="accordion-item bg-dark border-ritual">
              <h2 class="accordion-header" id="faq1">
                <button class="accordion-button bg-shadow text-ice" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                  O que é Ordem Paranormal?
                </button>
              </h2>
              <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                <div class="accordion-body">Um RPG brasileiro de horror investigativo, criado por Cellbit, com atmosfera gótica e sobrenatural.</div>
              </div>
            </div>
            <div class="accordion-item bg-dark border-ritual">
              <h2 class="accordion-header" id="faq2">
                <button class="accordion-button bg-shadow text-ice collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                Como posso jogar?
              </button>
            </h2>
            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
              <div class="accordion-body">Você pode participar de campanhas abertas, criar personagens e explorar missões no universo OP.</div>
            </div>
          </div>
          <div class="accordion-item bg-dark border-ritual">
            <h2 class="accordion-header" id="faq3">
              <button class="accordion-button bg-shadow text-ice collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                Onde encontro regras e fichas?
              </button>
            </h2>
            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
              <div class="accordion-body">No site, você encontra PDFs, fichas e materiais para jogar e narrar suas campanhas.</div>
            </div>
          </div>
        </div>
        <?php
        }
        ?>
      </div>
      <div class="col-md-5 text-center">
 <img src="/ordem-paranormal-homepage/assets/img/Icones-e-simbolos/Elementos/Conhecimento.png" alt="FAQ Ordem Paranormal" class="img-fluid faq-img-shadow">
      </div>
    </div>
  </div>
  <canvas id="faq-canvas" class="canvas-bg-absolute"></canvas>
</section>
