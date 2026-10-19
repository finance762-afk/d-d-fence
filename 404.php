<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * 404.php — friendly error page (Phase 5, 2026-10-19). Served by .htaccess ErrorDocument 404; sends a real 404 status and noindex.
 * There is no on-site search engine, so the "search suggestion" is a set of the questions visitors usually mean, each linked to the page
 * that answers it. Links render only for pages that exist on disk (pageBuilt), per the link-integrity rule.
 */
http_response_code(404);
$pageTitle       = 'Page Not Found | ' . $siteName;
$pageDescription = 'That page could not be found. Find D & D Fence services, the FAQ or the contact page, or call ' . $phone . ' for a fence estimate in Ennis and Waxahachie, TX.';
$canonicalUrl    = $siteUrl . '/404';
$ogImage         = defaultOgImage();
$currentPage     = '404';
$pageType        = 'other';
$noindex         = true;

$nfLooking = [
    ['/services/',                          'Looking for a fence type or a price?',     'See all six fence services'],
    ['/services/fence-repair/',             'Is a section leaning, sagging or down?',    'Fence repair'],
    ['/faq/',                               'Have a question about permits or timing?',  'Fence questions answered'],
    ['/contact/',                           'Ready to talk to the office?',              'Contact and hours'],
    ['/about/',                             'Wondering who builds the fence?',           'About ' . $siteName],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   404 — page-specific composition (D & D Fence, rustic). Dark hero with a broken-fence-line drawing, "what were you looking for"
   list, popular services grid. Tokens only (var()).
   ========================================================================== */
.nf-hero {
  background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 125%);
  padding-bottom: clamp(3rem, 6vw, 4.5rem);
}
.nf-hero::before {
  content: "";
  position: absolute;
  inset: -30% -10% auto 40%;
  height: 140%;
  z-index: -1;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 22%, transparent), transparent 72%);
  pointer-events: none;
}
.nf-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  opacity: .07;
  pointer-events: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='g'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23g)'/%3E%3C/svg%3E");
}
.nf-hero__grid { display: grid; grid-template-columns: minmax(0, 1.2fr) minmax(0, .8fr); gap: clamp(2rem, 5vw, 4rem); align-items: center; }
.nf-hero .hero-copy { display: grid; gap: var(--space-4); max-width: 40rem; }
.nf-hero .hero-title { color: var(--color-white); text-wrap: balance; }
.nf-hero .hero-title .text-accent { color: var(--color-accent-bright); }
.nf-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); text-wrap: pretty; }
.nf-hero .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.nf-hero .link-call svg { color: var(--color-accent-bright); }
.nf-hero .link-call:hover { color: var(--color-white); }
.nf-fence { color: var(--color-paper); opacity: .9; }
.nf-fence svg { width: 100%; height: auto; display: block; }
.nf-fence .num { font-family: var(--font-accent); font-weight: 700; font-size: 118px; letter-spacing: .04em; fill: var(--color-accent-bright); }
.nf-fence .rail { fill: currentColor; opacity: .55; }
.nf-fence .post { fill: currentColor; opacity: .75; }
.nf-fence .post--down { transform-box: fill-box; transform-origin: 50% 100%; transform: rotate(-17deg); opacity: .5; }
@media (max-width: 860px) { .nf-hero__grid { grid-template-columns: 1fr; } .nf-fence { max-width: 22rem; } }

.nf-looking { background: var(--color-paper); }
.nf-looking .section-head { display: grid; gap: var(--space-3); max-width: 60ch; margin-bottom: var(--space-8); }
.nf-looking h2 { text-wrap: balance; }
.nf-list { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-3) var(--space-8); margin: 0; padding: 0; list-style: none; }
.nf-list li { border-top: 1px solid var(--color-line); }
.nf-list a { display: grid; grid-template-columns: 1fr auto; gap: var(--space-1) var(--space-4); align-items: center; padding: var(--space-4) 0; text-decoration: none; min-height: 44px; }
.nf-list b { font-family: var(--font-heading); font-size: 1.05rem; color: var(--color-ink); }
.nf-list span { grid-column: 1; font-size: .92rem; color: var(--color-accent-dark); font-weight: 600; }
.nf-list svg { grid-column: 2; grid-row: 1 / span 2; color: var(--color-accent-dark); transition: transform var(--transition); }
.nf-list a:hover b { color: var(--color-primary); }
.nf-list a:hover svg { transform: translateX(4px); }
@media (max-width: 700px) { .nf-list { grid-template-columns: 1fr; } }

.nf-services { background: var(--color-surface); }
.nf-services .section-head { display: grid; gap: var(--space-3); max-width: 60ch; margin-bottom: var(--space-8); }
.nf-services h2 { text-wrap: balance; }
.nf-chips { display: flex; flex-wrap: wrap; gap: var(--space-3); margin: 0; padding: 0; list-style: none; }
.nf-chips a { display: inline-flex; align-items: center; gap: var(--space-2); min-height: 48px; padding: .6rem 1.1rem; border-radius: var(--radius); border: 1px solid var(--color-line); background: var(--color-paper); color: var(--color-ink); font-weight: 600; text-decoration: none; transition: border-color var(--transition), transform var(--transition); }
.nf-chips a svg { color: var(--color-accent-dark); }
.nf-chips a:hover { border-color: var(--color-accent); transform: translateY(-2px); }
@media (prefers-reduced-motion: reduce) { .nf-list svg, .nf-chips a { transition: none; } }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ HERO ============ -->
<section class="hero hero--interior nf-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="nf-hero__grid">
      <div class="hero-copy">
        <span class="eyebrow">Error 404 · Page not found</span>
        <h1 class="hero-title" id="hero-title">This part of the fence line <span class="text-accent">isn't here</span></h1>
        <p class="hero-answer">The page you tried to open does not exist or has moved. <?php echo h($siteName); ?> still builds and repairs fences in Ennis and Waxahachie, and the links below lead to the pages that do exist.</p>
        <div class="hero-actions">
          <a class="btn btn-primary btn-lg" href="/"><?php echo icon('home', 18); ?>Back to the homepage</a>
          <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
      </div>
      <div class="nf-fence" aria-hidden="true">
        <svg viewBox="0 0 420 260" focusable="false">
          <text class="num" x="210" y="120" text-anchor="middle">404</text>
          <rect class="rail" x="0" y="150" width="420" height="9" rx="2"/>
          <rect class="rail" x="0" y="206" width="420" height="9" rx="2"/>
<?php foreach ([30, 100, 170, 310, 380] as $nfX): ?>
          <rect class="post" x="<?php echo $nfX; ?>" y="132" width="14" height="108" rx="2"/>
<?php endforeach; ?>
          <rect class="post post--down" x="240" y="132" width="14" height="108" rx="2"/>
        </svg>
      </div>
    </div>
  </div>
</section>

<!-- ============ WHAT WERE YOU LOOKING FOR ============ -->
<section class="section nf-looking" aria-labelledby="looking-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow">Try one of these</span>
      <h2 id="looking-title">What were you looking for on the <?php echo h($siteName); ?> website?</h2>
      <p>Pick the question closest to what you wanted and the link goes straight to the page that answers it.</p>
    </div>
    <ul class="nf-list reveal-up">
<?php foreach ($nfLooking as $nfItem): if (!pageBuilt($nfItem[0])) continue; ?>
      <li><a href="<?php echo h($nfItem[0]); ?>"><b><?php echo h($nfItem[1]); ?></b><span><?php echo h($nfItem[2]); ?></span><?php echo icon('arrow-right', 20); ?></a></li>
<?php endforeach; ?>
    </ul>
  </div>
</section>

<!-- ============ POPULAR SERVICES + CTA ============ -->
<section class="section nf-services" aria-labelledby="services-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow">Fence services</span>
      <h2 id="services-title">Which fence service do you need in Ennis or Waxahachie?</h2>
      <p><?php echo h($siteName); ?> builds privacy, cedar, chain link and wrought iron fences, repairs fences that already stand, and installs new fences and gates. Choose a page, or call <?php echo phoneLink(); ?> and describe the job.</p>
    </div>
    <ul class="nf-chips reveal-up">
<?php foreach ($services as $nfSvc): if (!pageBuilt('/services/' . $nfSvc['slug'] . '/')) continue; ?>
      <li><a href="/services/<?php echo h($nfSvc['slug']); ?>/"><?php echo icon('fence', 18); ?><?php echo h($nfSvc['name']); ?></a></li>
<?php endforeach; ?>
      <li><?php echo estimateLink('btn btn-accent', 'Get a free estimate'); ?></li>
    </ul>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
