<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/ — D & D Fence services hub (Phase 4, 2026-10-19).
 * All six services in the required services component, a "which fence fits the job" matrix (signature), the job
 * process in brief, and the live Google reviews block. No client photos on file, so cards are icon-led like the homepage.
 * Estimate tool / booking are not authorized for this client and are not referenced.
 */
$pageTitle       = 'Fence Services in Ennis & Waxahachie, TX | ' . $siteName;
$pageDescription = 'Privacy, cedar, chain link and wrought iron fences, new installs and fence repair from D & D Fence in Ennis, Waxahachie and Ellis County. Call (469) 321-7783.';
$canonicalUrl    = $siteUrl . '/services/';
$ogImage         = defaultOgImage();
$currentPage     = 'services';
$pageType        = 'other';

$shCards = serviceCards();
$shBase  = rtrim($siteUrl, '/');

$shItems = [];
foreach ($services as $shPos => $shSvc) {
    $shItems[] = ['@type' => 'ListItem', 'position' => $shPos + 1, 'name' => $shSvc['name'],
                  'url' => $shBase . '/services/' . $shSvc['slug'] . '/',
                  'item' => ['@id' => $shBase . '/services/' . $shSvc['slug'] . '/#service-' . $shSvc['slug']]];
}
$shCrumbs = generateBreadcrumbSchema([['name' => 'Home', 'url' => '/'], ['name' => 'Services', 'url' => '/services/']]);
unset($shCrumbs['@context']);
$schemaMarkup = ['@context' => 'https://schema.org', '@graph' => [
    ['@type' => 'CollectionPage', '@id' => $shBase . '/services/#webpage', 'url' => $shBase . '/services/',
     'name' => 'Fence Services in Ennis & Waxahachie, TX', 'isPartOf' => ['@id' => $shBase . '/#website'],
     'about' => ['@id' => $shBase . '/#organization'],
     'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']],
     'mainEntity' => ['@type' => 'ItemList', 'name' => $siteName . ' fence services', 'itemListElement' => $shItems]],
    $shCrumbs,
]];

// Signature matrix: the job the owner describes → the page that answers it. General guidance only, no prices.
$shJobs = [
    ['job' => 'Keep the dog in without losing the view', 'start' => 'chain-link',         'why' => 'Open mesh keeps the yard visible and costs the least per foot of the four fence types.'],
    ['job' => 'Close off the backyard from the street',  'start' => 'privacy-fence',      'why' => 'Solid boards above eye level turn a patio or pool deck back into private space.'],
    ['job' => 'A natural wood fence that ages well',     'start' => 'cedar-fence',        'why' => 'Cedar resists rot on its own and can be stained or left to turn silver.'],
    ['job' => 'Fence a pool or dress up the front yard', 'start' => 'wrought-iron',       'why' => 'Ornamental metal leaves the view open and pairs with matching gates.'],
    ['job' => 'A section is leaning, sagging or down',   'start' => 'fence-repair',       'why' => 'Most leaning runs are a post problem, which is often fixable without a new fence.'],
    ['job' => 'A new run, a wide gate or an opener',     'start' => 'fence-installation', 'why' => 'Layout, gates and the full build planned together, on homes and larger properties.'],
];

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$shReviews = p1_google_reviews($slug, ['heading' => '', 'limit' => 9]);
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   /services/ hub — page-specific composition (D & D Fence, rustic, no photos yet).
   Layered type hero + service index card, icon-led services grid, job matrix (signature),
   dark process band, Google reviews, closing CTA. Tokens only (var()).
   ========================================================================== */

/* ---------- Hero: layered (gradient ::before, noise ::after, post-and-rail motif) ---------- */
.sh-hero {
  background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 125%);
  padding-bottom: clamp(3rem, 6vw, 4.5rem);
}
.sh-hero::before {
  content: "";
  position: absolute;
  inset: -25% auto auto -15%;
  width: 70%;
  height: 140%;
  z-index: -1;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 72%);
  pointer-events: none;
}
.sh-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  opacity: .07;
  pointer-events: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='g'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23g)'/%3E%3C/svg%3E");
}
.sh-hero .grain { opacity: .28; }
.sh-rails {
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  height: 110px;
  z-index: -1;
  color: var(--color-paper);
  opacity: .06;
  pointer-events: none;
}
.sh-rails svg { width: 100%; height: 100%; }
.sh-hero .breadcrumb { align-items: center; color: color-mix(in srgb, var(--color-white) 62%, transparent); margin-bottom: var(--space-2); }
.sh-hero .breadcrumb a:hover { color: var(--color-white); }
.sh-hero .breadcrumb [aria-current] { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.sh-hero .hero-grid { grid-template-columns: minmax(0, 1.1fr) minmax(300px, .9fr); align-items: center; }
.sh-hero .hero-copy { gap: var(--space-4); max-width: 38rem; }
.sh-hero .hero-title { color: var(--color-white); text-wrap: balance; }
.sh-hero .hero-title .text-accent { color: var(--color-accent-bright); }
.sh-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); text-wrap: pretty; }
.sh-hero .hero-chips li { background: color-mix(in srgb, var(--color-white) 7%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.sh-hero .hero-chips svg { color: var(--color-accent-bright); }
.sh-hero .hero-actions .btn-primary { background: var(--color-accent); color: var(--color-white); }
.sh-hero .hero-actions .btn-primary:hover { background: var(--color-accent-dark); }
.sh-hero .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.sh-hero .link-call svg { color: var(--color-accent-bright); }
.sh-hero .link-call:hover { color: var(--color-white); }

/* Service index card (glass, numbered jump list) */
.sh-index {
  position: relative;
  padding: var(--space-6) var(--space-6) var(--space-4);
  border-radius: var(--radius-lg);
  border: 1px solid color-mix(in srgb, var(--color-white) 18%, transparent);
  background: color-mix(in srgb, var(--color-white) 5%, transparent);
  backdrop-filter: blur(10px);
  box-shadow: var(--shadow-lg);
}
.sh-index__label { display: block; margin-bottom: var(--space-3); font-family: var(--font-accent); font-weight: 700; font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-bright); }
.sh-index ol { margin: 0; padding: 0; list-style: none; counter-reset: sh-idx; }
.sh-index li { counter-increment: sh-idx; border-top: 1px solid color-mix(in srgb, var(--color-white) 12%, transparent); }
.sh-index li:first-child { border-top: 0; }
.sh-index a {
  display: grid;
  grid-template-columns: 2.4rem 1fr auto;
  align-items: center;
  gap: var(--space-3);
  min-height: 52px;
  padding: var(--space-2) 0;
  color: var(--color-white);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: 1.08rem;
  text-decoration: none;
  transition: color var(--transition), padding-left var(--transition);
}
.sh-index a::before { content: counter(sh-idx, decimal-leading-zero); font-family: var(--font-accent); font-size: .95rem; letter-spacing: .08em; color: color-mix(in srgb, var(--color-white) 50%, transparent); }
.sh-index a svg { color: var(--color-accent-bright); transition: transform var(--transition); }
.sh-index a:hover { color: var(--color-accent-bright); padding-left: var(--space-2); }
.sh-index a:hover svg { transform: translateX(4px); }
@media (max-width: 900px) {
  .sh-hero .hero-grid { grid-template-columns: 1fr; }
  .sh-index { display: none; }
}
@media (max-width: 560px) {
  .sh-hero .hero-answer { font-size: var(--fs-body); }
  .sh-hero .hero-chips li { font-size: var(--font-size-xs); }
}

/* ---------- Services grid: six icon-led cards, 3 × 2 ---------- */
.sh-services { background: var(--color-paper); }
.sh-services .section-title { max-width: 64ch; }
.sh-services .section-title h2 { text-wrap: balance; }
.sh-services .section-title .hero-answer { color: var(--color-ink-2); max-width: 62ch; }
.sh-services .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-5); }
.sh-services .service-card-with-image { box-shadow: var(--shadow-sm); }
.sh-services .service-card__body { padding: var(--space-6) var(--space-6) var(--space-5); gap: var(--space-3); }
.sh-services .service-card__head { display: flex; align-items: center; gap: var(--space-4); }
.sh-services .service-card__icon { width: 56px; height: 56px; border-radius: var(--radius); background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow); transition: transform var(--transition-slow), color var(--transition); }
.sh-services .service-card__icon svg { width: 26px; height: 26px; }
.sh-services .service-card-with-image:hover .service-card__icon { transform: rotate(-6deg) scale(1.06); color: var(--color-primary); }
.sh-services .service-card-with-image h3 { font-size: 1.25rem; text-wrap: balance; }
.sh-services .service-card__num { margin-left: auto; font-family: var(--font-accent); font-weight: 700; font-size: 1.6rem; line-height: 1; color: color-mix(in srgb, var(--color-ink) 18%, transparent); }
@media (max-width: 1000px) { .sh-services .services-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 600px) { .sh-services .services-grid { grid-template-columns: 1fr; } }

/* ---------- Signature: job matrix ---------- */
.sh-jobs { background: var(--color-surface); }
.sh-jobs__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.6fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.sh-jobs__intro { display: grid; gap: var(--space-4); position: sticky; top: calc(var(--nav-height) + var(--space-6)); }
.sh-jobs__intro h2 { text-wrap: balance; }
.sh-jobs__intro .answer-block { margin: 0; }
.sh-jobs__intro p:not(.answer-block) { margin: 0; color: var(--color-ink-2); }
.sh-jobs__intro a { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-underline-offset: .18em; }
.sh-matrix { margin: 0; padding: 0; list-style: none; display: grid; gap: var(--space-3); counter-reset: sh-job; }
.sh-matrix li {
  counter-increment: sh-job;
  position: relative;
  display: grid;
  grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr);
  gap: var(--space-2) var(--space-6);
  align-items: center;
  padding: var(--space-5) var(--space-6) var(--space-5) var(--space-16);
  background: var(--color-paper);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-lg);
  transition: border-color var(--transition), transform var(--transition-slow), box-shadow var(--transition-slow);
}
.sh-matrix li::before {
  content: counter(sh-job);
  position: absolute;
  left: var(--space-5);
  top: 50%;
  transform: translateY(-50%);
  width: 34px;
  height: 34px;
  display: grid;
  place-items: center;
  border-radius: 50%;
  border: 2px solid var(--color-accent);
  font-family: var(--font-accent);
  font-weight: 700;
  color: var(--color-accent-dark);
}
.sh-matrix li:nth-child(even) { background: var(--color-paper-2); }
.sh-matrix li:hover { border-color: var(--color-accent); transform: translateX(4px); box-shadow: var(--shadow); }
.sh-matrix__job { font-family: var(--font-heading); font-weight: 700; font-size: 1.05rem; color: var(--color-ink); }
.sh-matrix__answer { display: grid; gap: var(--space-1); }
.sh-matrix__answer a { display: inline-flex; align-items: center; gap: var(--space-2); font-family: var(--font-accent); font-weight: 700; font-size: .95rem; letter-spacing: .1em; text-transform: uppercase; color: var(--color-accent-dark); }
.sh-matrix__answer a:hover { color: var(--color-primary); }
.sh-matrix__answer span { font-size: .9rem; color: var(--color-ink-2); }
@media (max-width: 960px) {
  .sh-jobs__grid { grid-template-columns: 1fr; }
  .sh-jobs__intro { position: static; }
}
@media (max-width: 640px) {
  .sh-matrix li { grid-template-columns: 1fr; padding: var(--space-5) var(--space-5) var(--space-5) var(--space-12); }
  .sh-matrix li::before { left: var(--space-3); top: var(--space-5); transform: none; }
}

/* ---------- Process band (dark, slanted, grain) ---------- */
.sh-process .sh-process__head { display: grid; gap: var(--space-3); max-width: 62ch; margin-bottom: var(--space-10); }
.sh-process .answer-block { background: color-mix(in srgb, var(--color-white) 6%, transparent); border-left-color: var(--color-accent-bright); color: color-mix(in srgb, var(--color-white) 90%, transparent); margin: 0; }
.sh-steps { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-5); margin: 0; padding: 0; list-style: none; counter-reset: sh-step; }
.sh-steps li {
  counter-increment: sh-step;
  position: relative;
  display: grid;
  gap: var(--space-2);
  align-content: start;
  padding: var(--space-12) var(--space-5) var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid color-mix(in srgb, var(--color-white) 14%, transparent);
  background: color-mix(in srgb, var(--color-white) 4%, transparent);
}
.sh-steps li::before { content: counter(sh-step, decimal-leading-zero); position: absolute; top: var(--space-4); left: var(--space-5); font-family: var(--font-accent); font-weight: 700; font-size: 1.5rem; color: var(--color-accent-bright); }
.sh-steps li::after { content: ""; position: absolute; top: calc(var(--space-4) + .8rem); left: calc(var(--space-5) + 2.6rem); right: var(--space-5); height: 1px; background: color-mix(in srgb, var(--color-white) 18%, transparent); }
.sh-steps h3 { color: var(--color-white); font-size: 1.08rem; }
.sh-steps p { margin: 0; font-size: .93rem; }
.sh-process .floating-ring { right: -110px; bottom: -150px; }
@media (max-width: 1000px) { .sh-steps { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 600px) { .sh-steps { grid-template-columns: 1fr; } }

/* ---------- Google reviews ---------- */
.sh-reviews { background: var(--color-paper); }
.sh-reviews .sp-head, .sh-reviews .sh-reviews__head { display: grid; gap: var(--space-3); max-width: 62ch; margin-bottom: var(--space-8); }
.sh-reviews .answer-block { margin: 0; }

/* ---------- Closing CTA ---------- */
.sh-cta.cta-banner { background: linear-gradient(125deg, var(--color-primary-deep) -10%, var(--color-dark) 45%, var(--color-dark-alt) 100%); }
.sh-cta .cta-copy { display: grid; gap: var(--space-3); max-width: 58ch; }
.sh-cta .cta-copy p { margin: 0; }
.sh-cta .actions { align-items: center; }
.sh-cta .btn-accent { color: var(--color-white); }
.sh-cta .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.sh-cta .link-call svg { color: var(--color-accent-bright); }
.sh-cta .floating-ring { left: -100px; top: -130px; }

/* ---------- Headings ---------- */
.sh-services h2, .sh-jobs h2, .sh-process h2, .sh-reviews h2, .sh-cta h2 { text-wrap: balance; }

@media (prefers-reduced-motion: reduce) {
  .sh-index a, .sh-index a svg, .sh-matrix li, .sh-services .service-card__icon { transition: none; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ HERO (type hero + service index; no client photo on file yet) ============ -->
<section class="hero hero--interior sh-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="sh-rails" aria-hidden="true">
    <svg viewBox="0 0 1200 110" preserveAspectRatio="none" focusable="false">
      <defs>
        <pattern id="sh-posts" width="150" height="110" patternUnits="userSpaceOnUse">
          <rect x="4" y="10" width="14" height="100" fill="currentColor"/>
        </pattern>
      </defs>
      <rect x="0" y="0" width="1200" height="110" fill="url(#sh-posts)"/>
      <rect x="0" y="34" width="1200" height="8" fill="currentColor"/>
      <rect x="0" y="74" width="1200" height="8" fill="currentColor"/>
    </svg>
  </div>
  <div class="container">
    <div class="hero-grid">
      <div class="hero-copy">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="breadcrumb-sep" aria-hidden="true">/</li>
            <li><span aria-current="page">Services</span></li>
          </ol>
        </nav>
        <span class="eyebrow">Fence services · Ennis &amp; Waxahachie, TX</span>
        <h1 class="hero-title" id="hero-title">Fence Services in <span class="text-accent">Ennis &amp; Waxahachie</span>, TX</h1>
        <p class="hero-answer"><?php echo h($siteName); ?> builds privacy, cedar, chain link and wrought iron fences, installs new fence runs and gates, and repairs fences that lean, sag or break. The work covers homes and properties in Ennis, Waxahachie and the towns within about <?php echo (int) $serviceRadiusMiles; ?> miles of them.</p>
        <div class="hero-actions">
          <?php echo estimateLink('btn btn-primary btn-lg', 'Get a free estimate'), "\n"; ?>
          <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
          <li><?php echo icon('fence', 16); ?><?php echo count($services); ?> fence services</li>
          <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
        </ul>
      </div>

      <nav class="sh-index" aria-label="Fence service pages">
        <span class="sh-index__label">Jump to a service</span>
        <ol>
<?php foreach ($services as $shSvc): ?>
          <li><a href="/services/<?php echo h($shSvc['slug']); ?>/"><?php echo h($shSvc['name']); ?><?php echo icon('arrow-right', 18); ?></a></li>
<?php endforeach; ?>
        </ol>
      </nav>
    </div>
  </div>
</section>

<!-- ============ SERVICES (required component — all six services) ============ -->
<section class="section sh-services" aria-label="Fence services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which <span class="text-accent">fence services</span> does <?php echo h($siteName); ?> offer in <span class="text-accent">Ennis and Waxahachie</span>?</h2>
      <p class="hero-answer"><?php echo h($siteName); ?> offers six fence services: privacy fences, cedar fences, chain link, wrought iron, fence repair and new fence installation. Each one has its own page below with what the job includes, how it runs, and the questions owners in Ennis and Waxahachie ask before they call.</p>
      <span class="section-subtitle">Four fence types · New builds · Repairs</span>
      <p class="prose">The four fence types differ in look, upkeep and cost; repair and installation cover the work around them, from a single leaning post to a full new run with gates.</p>
    </div>

    <div class="services-grid">
<?php foreach ($services as $shI => $shSvc):
        $shCard = $shCards[$shSvc['slug']];
        $shTint = ($shI % 3) + 1; ?>
      <article class="service-card-with-image card-tint-<?php echo $shTint; ?> reveal-up reveal-delay-<?php echo $shTint; ?>">
        <div class="service-card__body">
          <div class="service-card__head">
            <div class="service-card__icon"><?php echo icon($shCard['icon'], 26); ?></div>
            <h3><?php echo h($shSvc['name']); ?></h3>
            <span class="service-card__num" aria-hidden="true"><?php echo sprintf('%02d', $shI + 1); ?></span>
          </div>
          <p class="service-card__desc"><?php echo h($shCard['desc']); ?></p>
          <ul>
<?php foreach ($shCard['bullets'] as $shBullet): ?>
            <li><?php echo h($shBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($shSvc['slug']); ?>/" class="service-card__cta">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ SIGNATURE: which service fits the job ============ -->
<section class="section sh-jobs" aria-labelledby="jobs-title">
  <div class="container-wide">
    <div class="sh-jobs__grid">
      <div class="sh-jobs__intro reveal-left">
        <span class="eyebrow">Start with the job</span>
        <h2 id="jobs-title">Which fence service fits the job you have in mind?</h2>
        <p class="answer-block">Start from what the fence has to do. Chain link keeps pets in for the least money, privacy and cedar fences block the view, wrought iron suits pools and front yards, and fence repair comes first when a section is leaning, sagging or down.</p>
        <p>Not sure which line fits your property? Call <?php echo phoneLink(); ?> and describe the yard, or read the <?php echo serviceLink('fence-installation', 'fence installation page'); ?> for how layout, gates and the build are planned together.</p>
      </div>

      <ol class="sh-matrix">
<?php foreach ($shJobs as $shJob):
        $shTarget = serviceBySlug($shJob['start']); ?>
        <li class="reveal-right">
          <span class="sh-matrix__job"><?php echo h($shJob['job']); ?></span>
          <span class="sh-matrix__answer">
            <a href="/services/<?php echo h($shJob['start']); ?>/"><?php echo h($shTarget['name']); ?><?php echo icon('arrow-right', 16); ?></a>
            <span><?php echo h($shJob['why']); ?></span>
          </span>
        </li>
<?php endforeach; ?>
      </ol>
    </div>
  </div>
</section>

<!-- ============ PROCESS (dark, slanted) ============ -->
<section class="section sh-process texture-grain slant-top" aria-labelledby="process-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div class="sh-process__head reveal-up">
      <span class="eyebrow">From call to fence</span>
      <h2 id="process-title">How does a job with <?php echo h($siteName); ?> run from the first call?</h2>
      <p class="answer-block">Every <?php echo h($siteName); ?> job follows the same four steps, whatever the fence type: you describe the job, the line is measured on site, the property line and local rules are settled, and then the fence or repair is built. The price comes back in writing before work starts.</p>
    </div>
    <ol class="sh-steps">
      <li class="reveal-up reveal-delay-1"><h3>Describe the job</h3><p>Call or send the form with the fence type, a rough length and the town. Photos of an old fence help with repairs.</p></li>
      <li class="reveal-up reveal-delay-2"><h3>Measure on site</h3><p>The run is walked and measured, with the ground, gates and any fence that has to come out noted for the estimate.</p></li>
      <li class="reveal-up reveal-delay-3"><h3>Settle line and rules</h3><p>Your survey or plat fixes where the fence goes; city and HOA rules fix how tall it can be and how it faces.</p></li>
      <li class="reveal-up reveal-delay-4"><h3>Build</h3><p>Buried lines are located before digging, then posts, rails and panels or fabric go in, and the site is cleaned up.</p></li>
    </ol>
  </div>
</section>

<?php if ($shReviews !== ''): ?>
<!-- ============ GOOGLE REVIEWS (live Page One feed; renders nothing until written reviews exist) ============ -->
<section class="section sh-reviews" aria-labelledby="reviews-title">
  <div class="container">
    <div class="sh-reviews__head reveal-up">
      <span class="eyebrow">Google reviews</span>
      <h2 id="reviews-title">What do Ennis and Waxahachie customers say about <?php echo h($siteName); ?>?</h2>
      <p class="answer-block">Customers on Google describe fences finished on schedule, clear communication from Austin, careful work around utilities and dogs, and fair pricing when plans changed. The reviews below come from the <?php echo h($siteName); ?> Google Business Profile and are shown exactly as written.</p>
    </div>
    <?php echo $shReviews; ?>
  </div>
</section>
<?php endif; ?>

<!-- ============ CLOSING CTA ============ -->
<section class="cta-banner texture-grain edge-curve-top sh-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-copy reveal-scale">
      <span class="eyebrow">Free estimate</span>
      <h2 id="cta-title">Ready to talk through your fence?</h2>
      <p>Tell <?php echo h($siteName); ?> the fence type, a rough length and the town, and the office will call back during business hours to set up a time to see the line.</p>
    </div>
    <div class="actions reveal-scale reveal-delay-2">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a Free Fence Estimate</button>
      <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
