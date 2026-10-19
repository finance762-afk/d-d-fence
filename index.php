<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * Homepage — D & D Fence (Phase 3, 2026-10-19).
 * Archetype: rustic. build-plan assets.images is empty (no client photos, no logo on disk), so this page uses the
 * photo-less fallbacks the build prompt allows: .hero--type with .hero-grid--form, no recent-work gallery (< 8 photos),
 * icon-led service cards, and an inline SVG fence drawing in the about column. Swap in real photos when they arrive.
 * Section script (editorial, few photos): hero → ticker → services → proof strip → material guide (signature) →
 * CTA banner → about/process → Google reviews → FAQ → estimate section.
 * Every fact traces to build-plan.json / config.php; facts the page wanted but intake lacks are in /content-confirmations.json.
 */
$pageTitle       = 'Fence Contractor in Ennis & Waxahachie, TX | ' . $siteName;
$pageDescription = 'D & D Fence builds and repairs privacy, cedar, chain link and wrought iron fences within 25 miles of Ennis and Waxahachie, TX. Call (469) 321-7783.';
$canonicalUrl    = $siteUrl . '/';
$ogImage         = defaultOgImage();          // '' until an OG image or logo is staged
$currentPage     = 'home';
$pageType        = 'home';
$heroPreloadImage = '';                       // type hero — no LCP photo to preload

// Service cards: config.php services + homepage card copy. Icons are inline SVG via icon().
$homeCards = [
    'privacy-fence' => [
        'icon'    => 'fence',
        'desc'    => 'Solid board fences that close a backyard off from the street and neighbors.',
        'bullets' => ['Blocks sightlines into the yard', 'Keeps pets and kids contained', 'Marks the property line clearly'],
    ],
    'cedar-fence' => [
        'icon'    => 'trees',
        'desc'    => 'Cedar board fencing for a natural wood look around the yard.',
        'bullets' => ['Rot-resistant wood by nature', 'Takes stain or sealer well', 'Weathers to a soft silver'],
    ],
    'chain-link' => [
        'icon'    => 'link',
        'desc'    => 'Galvanized wire-mesh fencing for yards, perimeters and secure areas.',
        'bullets' => ['Lowest material cost per foot', 'Keeps dogs inside the yard', 'Leaves the view wide open'],
    ],
    'wrought-iron' => [
        'icon'    => 'shield-check',
        'desc'    => 'Ornamental metal fencing for front yards, entries, pools and security.',
        'bullets' => ['Decorative without blocking views', 'Little upkeep once coated', 'Pairs with matching gates'],
    ],
    'fence-repair' => [
        'icon'    => 'wrench',
        'desc'    => 'Fixes for leaning posts, broken boards and gates that no longer latch.',
        'bullets' => ['Leaning posts set straight', 'Broken pickets and rails replaced', 'Sagging gates closing again'],
    ],
    'fence-installation' => [
        'icon'    => 'hammer',
        'desc'    => 'New fence and gate installation for residential and farm properties.',
        'bullets' => ['Layout walked before digging', 'Gates planned into the run', 'Homes, acreage and farms'],
    ],
];

// Ticker: service types and places only (credentials are not repeated here).
$tickerItems = [
    ['fence', 'Privacy fences'], ['trees', 'Cedar fences'], ['link', 'Chain link'], ['shield-check', 'Wrought iron'],
    ['wrench', 'Fence repair'], ['hammer', 'New installations'], ['map-pin', 'Ennis, TX'], ['map-pin', 'Waxahachie, TX'],
    ['route', $serviceRadiusMiles . '-mile service radius'], ['tractor', 'Farm & acreage fencing'],
];

// FAQs: the five research_brief questions (rewritten answer-first) + the service-area question answered from intake.
$homeFaqs = [
    ['q' => 'How much does a new fence cost?',
     'a' => 'The price of a new fence depends on the material, the total length, the height, the ground and whether an old fence has to come out first. Most residential fences are priced by the linear foot, and a free estimate from ' . $siteName . ' puts the materials and labor for your run in writing.'],
    ['q' => 'Do I need a permit or HOA approval before building a fence?',
     'a' => 'Often, yes: many Texas cities require a permit for fences above a set height, and HOAs commonly set rules on style, color and placement. ' . $siteName . ' can check the requirements for your address so the project is not held up waiting on paperwork.'],
    ['q' => 'How do I know where my property line is?',
     'a' => 'Start with the survey or plat in your closing documents. If the line is still unclear, a licensed surveyor can stake it, which heads off disputes with neighbors. ' . $siteName . ' recommends confirming the line before any post hole is dug.'],
    ['q' => 'Which fence material lasts the longest?',
     'a' => 'Coated metal, such as wrought iron and galvanized chain link, typically lasts the longest with the least upkeep. Cedar resists rot better than most wood and lasts well with regular stain or sealer. The right pick depends on whether you need privacy, an open view or the lowest cost.'],
    ['q' => 'How long does fence installation take, and what warranty do you offer?',
     'a' => 'A typical residential fence run takes one to three days, depending on its length, the ground and the weather. Warranty coverage varies by material and workmanship, and ' . $siteName . ' puts the exact terms in writing with your estimate.'],
    ['q' => 'Which towns does ' . $siteName . ' serve?',
     'a' => $siteName . ' serves Ennis, Waxahachie and properties within about ' . $serviceRadiusMiles . ' miles of them in Ellis County and the surrounding area. Call ' . $phone . ', Monday through Friday from 7 AM to 6 PM, to confirm your address.'],
];

$schemaMarkup = [generateFAQSchema($homeFaqs)];

$servicesHubBuilt = pageBuilt('/services/');
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Homepage — page-specific composition (D & D Fence, rustic, no photos yet).
   Tokens only (var()); framework.css carries the shared components.
   ========================================================================== */

/* ---------- Hero: layered type hero (gradient ::before, noise ::after, picket line) ---------- */
.home-hero {
  background: linear-gradient(118deg, var(--color-dark) 0%, var(--color-dark-alt) 52%, var(--color-primary-deep) 120%);
  padding-bottom: calc(clamp(2.5rem, 5vw, 4rem) + var(--space-12));
}
.home-hero::before {
  content: "";
  position: absolute;
  inset: -20% -15% auto 45%;
  height: 130%;
  z-index: -1;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 24%, transparent), transparent 72%);
  pointer-events: none;
}
.home-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  opacity: .07;
  pointer-events: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='g'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23g)'/%3E%3C/svg%3E");
}
.home-hero .grain { opacity: .3; }
.home-hero .eyebrow { color: var(--color-accent-bright); }
.home-hero .hero-title { color: var(--color-white); }
.home-hero .hero-title .text-accent { color: var(--color-accent-bright); }
.home-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); }
.home-hero .hero-chips li {
  background: color-mix(in srgb, var(--color-white) 7%, transparent);
  border-color: color-mix(in srgb, var(--color-white) 20%, transparent);
  color: var(--color-white);
}
.home-hero .hero-chips svg { color: var(--color-accent-bright); }
.home-hero .hero-actions .btn-primary {
  background: var(--color-accent);
  color: var(--color-white);
  box-shadow: 0 10px 24px -12px color-mix(in srgb, var(--color-accent) 80%, transparent);
}
.home-hero .hero-actions .btn-primary:hover { background: var(--color-accent-dark); }
.hero-pickets {
  position: absolute;
  left: 0;
  right: 0;
  bottom: 0;
  height: 96px;
  z-index: -1;
  color: var(--color-paper);
  opacity: .07;
  pointer-events: none;
}
.hero-pickets svg { width: 100%; height: 100%; }
.home-hero .hero-form-card { border-color: color-mix(in srgb, var(--color-white) 30%, transparent); }
.home-hero .hero-form-card h2 { text-wrap: balance; }
.hero-form-card .hero-form-tagline b { color: var(--color-ink); font-weight: 600; }
.home-hero .hero-answer { max-width: 33rem; }
@media (max-width: 900px) {
  .home-hero .hero-text > .eyebrow { order: 0; }
  .home-hero .hero-text > .hero-title { order: 1; }
  .home-hero .hero-text > .hero-actions { order: 2; margin-top: 0; }
  .home-hero .hero-text > .hero-answer { order: 3; }
  .home-hero .hero-text > .hero-chips { order: 4; margin-top: 0; }
  .hero-pickets { height: 64px; }
}
@media (max-width: 560px) {
  .home-hero .hero-text { gap: var(--space-4); }
  .home-hero .hero-answer { font-size: var(--fs-body); }
  .home-hero .hero-actions { gap: var(--space-3); }
  .home-hero .hero-chips li { font-size: var(--font-size-xs); padding: var(--space-1) var(--space-3) var(--space-1) var(--space-2); }
}

/* ---------- Ticker: torn top edge bites into the dark hero ---------- */
.home-ticker.edge-torn-top {
  position: relative;
  z-index: 2;
  margin-top: calc(-1 * var(--space-5));
  padding-top: calc(var(--space-3) + 18px);
  padding-bottom: var(--space-3);
  background: var(--color-paper-2);
  border-top: 0;
}
.home-ticker .ticker-track svg { color: var(--color-accent-dark); }
.home-ticker .ticker-track span { font-weight: 700; }

/* ---------- Services: six icon-led cards in a clean 3 × 2 ---------- */
.home-services { background: var(--color-paper); }
.home-services .section-title { max-width: 64ch; }
.home-services .section-title h2 { text-wrap: balance; }
.home-services .section-title .hero-answer { color: var(--color-ink-2); max-width: 60ch; }
.home-services .section-subtitle { margin-top: var(--space-1); }
.home-services .services-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-5); }
.home-services .service-card-with-image { box-shadow: var(--shadow-sm); }
.home-services .service-card__body { padding: var(--space-6) var(--space-6) var(--space-5); gap: var(--space-3); }
.home-services .service-card__icon {
  width: 56px;
  height: 56px;
  border-radius: var(--radius);
  background: var(--color-surface);
  color: var(--color-accent-dark);
  box-shadow: var(--shadow);
  transition: transform var(--transition-slow), color var(--transition);
}
.home-services .service-card__icon svg { width: 26px; height: 26px; }
.home-services .service-card-with-image:hover .service-card__icon { transform: rotate(-6deg) scale(1.06); color: var(--color-primary); }
.home-services .service-card-with-image h3 { font-size: 1.25rem; text-wrap: balance; }
.home-services .service-card__head { display: flex; align-items: center; gap: var(--space-4); }
.home-services .service-card__cta { border: 0; background: none; padding: var(--space-2) 0 0; font: inherit; font-size: .92rem; font-weight: 600; color: var(--color-primary); cursor: pointer; text-align: left; }
.home-services .service-card__cta:hover { color: var(--color-accent-dark); }
.home-services .services-foot { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-4) var(--space-6); margin-top: var(--space-10); }
.home-services .services-foot p { margin: 0; color: var(--color-muted); font-size: var(--fs-small); }
@media (max-width: 1000px) { .home-services .services-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 600px) { .home-services .services-grid { grid-template-columns: 1fr; } }

/* ---------- Proof strip (dark, slanted) ---------- */
.home-proof.stats-band {
  background: linear-gradient(105deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 130%);
  color: var(--color-paper);
  border: 0;
}
.home-proof .stat-item { border-left-color: color-mix(in srgb, var(--color-white) 14%, transparent); }
.home-proof .stat-number { color: var(--color-white); font-size: clamp(1.6rem, 1.2rem + 1.2vw, 2.2rem); text-transform: uppercase; }
.home-proof .stat-number span { color: var(--color-accent-bright); }
.home-proof .stat-label { color: color-mix(in srgb, var(--color-white) 72%, transparent); }

/* ---------- Signature: material guide (lumber-tag spec sheet) ---------- */
.home-materials { background: var(--color-paper); }
.materials-layout {
  display: grid;
  grid-template-columns: minmax(0, .85fr) minmax(0, 1.4fr);
  gap: clamp(2rem, 5vw, 4.5rem);
  align-items: start;
}
.materials-intro { display: grid; gap: var(--space-4); position: sticky; top: calc(var(--nav-height) + var(--space-6)); }
.materials-intro h2 { text-wrap: balance; }
.materials-intro .hero-answer { color: var(--color-ink-2); }
.ground-note {
  position: relative;
  margin-top: var(--space-4);
  padding: var(--space-5) var(--space-6) var(--space-5) var(--space-8);
  background: var(--color-surface);
  border: 1px solid var(--color-line);
  border-radius: var(--radius);
  box-shadow: var(--shadow-sm);
}
.ground-note::before {
  content: "";
  position: absolute;
  left: var(--space-3);
  top: var(--space-5);
  bottom: var(--space-5);
  width: 4px;
  border-radius: var(--radius-full);
  background: repeating-linear-gradient(180deg, var(--color-accent) 0 8px, transparent 8px 13px);
}
.ground-note h3 { font-size: 1.05rem; margin-bottom: var(--space-2); text-wrap: balance; }
.ground-note p { margin: 0; font-size: .95rem; color: var(--color-ink-2); }
.spec-sheet {
  position: relative;
  background: var(--color-surface);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg);
  overflow: hidden;
}
.spec-sheet::before {
  content: "";
  position: absolute;
  top: var(--space-5);
  right: var(--space-5);
  width: 14px;
  height: 14px;
  border-radius: 50%;
  border: 3px solid var(--color-line);
  background: var(--color-paper);
}
.spec-sheet__head {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
  gap: var(--space-4);
  padding: var(--space-5) var(--space-12) var(--space-4) var(--space-6);
  border-bottom: 2px dashed var(--color-line);
  background: var(--color-paper-2);
}
.spec-sheet__head span { font-family: var(--font-accent); font-weight: 700; font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.spec-sheet__head b { font-family: var(--font-heading); font-size: 1.1rem; }
.table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.table-scroll:focus-visible { outline-offset: -3px; }
.material-table { width: 100%; min-width: 620px; border-collapse: collapse; font-size: .93rem; }
.material-table th, .material-table td { padding: var(--space-4) var(--space-5); text-align: left; vertical-align: top; border-bottom: 1px solid var(--color-line); }
.material-table thead th {
  font-family: var(--font-accent);
  font-weight: 700;
  font-size: var(--fs-eyebrow);
  letter-spacing: .12em;
  text-transform: uppercase;
  color: var(--color-muted);
  background: var(--color-surface);
}
.material-table tbody th { font-family: var(--font-heading); font-weight: 800; font-size: 1.02rem; color: var(--color-ink); width: 22%; }
.material-table tbody th small { display: block; margin-top: var(--space-1); font-family: var(--font-body); font-weight: 400; font-size: .8rem; color: var(--color-muted); }
.material-table tbody td { color: var(--color-ink-2); }
.material-table tbody tr:last-child th, .material-table tbody tr:last-child td { border-bottom: 0; }
.material-table tbody tr { transition: background-color var(--transition); }
.material-table tbody tr:hover { background: color-mix(in srgb, var(--color-accent) 5%, transparent); }
.cost-scale { display: inline-flex; gap: 3px; vertical-align: middle; margin-right: var(--space-2); }
.cost-scale i { width: 9px; height: 16px; border-radius: 2px; background: var(--color-line); }
.cost-scale i.on { background: var(--color-accent); }
.spec-sheet__foot { margin: 0; padding: var(--space-4) var(--space-6); font-size: var(--fs-small); color: var(--color-muted); border-top: 1px solid var(--color-line); background: var(--color-paper-2); }
@media (max-width: 960px) {
  .materials-layout { grid-template-columns: 1fr; }
  .materials-intro { position: static; }
}

/* ---------- Mid-page CTA banner (dark, curved top, grain) ---------- */
.home-cta.cta-banner { background: linear-gradient(125deg, var(--color-primary-deep) -10%, var(--color-dark) 45%, var(--color-dark-alt) 100%); }
.home-cta.edge-curve-top { padding-top: calc(var(--section-pad) + var(--space-4)); }
.home-cta::after {
  content: "";
  position: absolute;
  inset: auto auto -45% -10%;
  width: 55%;
  height: 120%;
  z-index: -1;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 70%);
  pointer-events: none;
}
.home-cta .cta-copy { display: grid; gap: var(--space-3); max-width: 58ch; }
.home-cta .cta-copy p { margin: 0; }
.home-cta .actions { align-items: center; }
.home-cta .btn-accent { color: var(--color-white); }
.home-cta .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.home-cta .link-call svg { color: var(--color-accent-bright); }
.home-cta .link-call:hover { color: var(--color-white); }
.home-cta .floating-ring { right: -90px; top: -110px; opacity: .08; }

/* ---------- About + process: the asymmetric section ---------- */
.home-about { background: var(--color-surface); }
.home-about .about-split { grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr); align-items: start; gap: clamp(2.5rem, 6vw, 6rem); }
.home-about .about-left { display: grid; gap: var(--space-4); }
.home-about .about-left > p { margin: 0; color: var(--color-ink-2); max-width: 62ch; }
.home-about .about-left h2 { text-wrap: balance; }
.home-about .process-title { margin-top: var(--space-6); font-size: 1.15rem; display: flex; align-items: center; gap: var(--space-3); }
.home-about .process-title::after { content: ""; flex: 1; height: 1px; background: var(--color-line); }
.home-about .process-steps { margin-top: var(--space-2); gap: var(--space-6) var(--space-8); }
.home-about .process-steps li { padding: var(--space-4); border-radius: var(--radius); background: var(--color-paper); border: 1px solid var(--color-line); }
.home-about .process-steps li:nth-child(even) { margin-top: var(--space-8); }
.home-about .about-right { margin-top: var(--space-16); position: relative; }
.home-about .about-right::before {
  content: "";
  position: absolute;
  inset: -24px 24px 24px -24px;
  border: 2px solid var(--color-accent);
  border-radius: var(--radius-lg);
  opacity: .55;
  z-index: 0;
}
.drawing-panel {
  position: relative;
  z-index: 1;
  margin: 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-lg);
  background: linear-gradient(160deg, var(--color-dark-alt) 0%, var(--color-dark) 100%);
  clip-path: polygon(0 0, 100% 0, 100% 88%, 86% 100%, 0 100%);
}
.drawing-panel figcaption {
  padding: var(--space-5) var(--space-6) 0;
  font-size: .82rem;
  color: color-mix(in srgb, var(--color-white) 70%, transparent);
}
.fence-drawing { width: 100%; height: auto; color: var(--color-paper); }
.fence-drawing .grid-line { stroke: color-mix(in srgb, var(--color-white) 7%, transparent); stroke-width: 1; }
.fence-drawing .post { fill: var(--color-accent); }
.fence-drawing .post-buried { fill: none; stroke: var(--color-accent-bright); stroke-width: 2; stroke-dasharray: 6 5; }
.fence-drawing .rail { fill: color-mix(in srgb, var(--color-paper) 70%, transparent); }
.fence-drawing .picket { fill: color-mix(in srgb, var(--color-paper) 88%, transparent); }
.fence-drawing .grade { stroke: var(--color-paper); stroke-width: 2; }
.fence-drawing .clay { fill: color-mix(in srgb, var(--color-accent) 16%, transparent); }
.fence-drawing .crack { fill: none; stroke: color-mix(in srgb, var(--color-paper) 35%, transparent); stroke-width: 1.5; }
.fence-drawing .leader { stroke: color-mix(in srgb, var(--color-paper) 55%, transparent); stroke-width: 1; fill: none; }
.fence-drawing .label { font-family: var(--font-accent); font-weight: 700; font-size: 13px; letter-spacing: .14em; fill: var(--color-paper); }
.fence-drawing .label--accent { fill: var(--color-accent-bright); }
.home-about .about-stat-card {
  left: calc(-1 * var(--space-8));
  bottom: calc(-1 * var(--space-6));
  display: grid;
  gap: var(--space-1);
  max-width: 15rem;
  padding: var(--space-4) var(--space-5);
}
.home-about .about-stat-card b { font-family: var(--font-accent); font-size: 2.4rem; line-height: 1; color: var(--color-accent-dark); }
.home-about .about-stat-card span { font-size: .85rem; color: var(--color-ink-2); line-height: 1.35; }
@media (max-width: 900px) {
  .home-about .about-split { grid-template-columns: 1fr; }
  .home-about .about-right { margin: var(--space-8) var(--space-6) var(--space-10) var(--space-6); }
  .home-about .about-stat-card { left: calc(-1 * var(--space-4)); }
  .home-about .process-steps li:nth-child(even) { margin-top: 0; }
}

/* ---------- Google reviews (light band) ---------- */
.home-reviews { background: var(--color-paper-2); }

/* ---------- FAQ ---------- */
.home-faq { background: var(--color-paper); }
.home-faq .section-head { margin-inline: auto; text-align: center; justify-items: center; }
.home-faq .section-head h2 { text-wrap: balance; }
.home-faq .faq summary { text-wrap: balance; }
.home-faq .faq[open] summary { color: var(--color-accent-dark); }
.home-faq .faq-more { margin-top: var(--space-8); text-align: center; color: var(--color-muted); font-size: .95rem; }
.home-faq .faq-more a { color: var(--color-primary); font-weight: 600; }

/* ---------- Estimate section (dark, wave top, white card) ---------- */
.home-estimate { background: linear-gradient(160deg, var(--color-dark) 0%, var(--color-dark-alt) 70%, var(--color-primary-deep) 140%); color: var(--color-paper); }
.home-estimate .estimate { align-items: center; }
.home-estimate .card { display: grid; gap: var(--space-3); box-shadow: var(--shadow-lg); color: var(--color-ink); }
.home-estimate .card .form-consent-legend { color: var(--color-ink); }
.home-estimate .card p, .home-estimate .card .consent-label { color: var(--color-ink-2); }
.home-estimate .card h2 { color: var(--color-ink); text-wrap: balance; }
.home-estimate .card .eyebrow { color: var(--color-primary); }
.home-estimate .card .lead { margin: 0 0 var(--space-2); font-size: 1rem; }
.home-estimate .estimate-aside { display: grid; gap: var(--space-4); }
.home-estimate .estimate-aside h3 { color: var(--color-white); font-size: 1.3rem; }
.home-estimate .next-steps li { color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.home-estimate .next-steps li strong { color: var(--color-white); }
.home-estimate .next-steps li::before { color: var(--color-accent-bright); }
.home-estimate .nap { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.home-estimate .nap svg { color: var(--color-accent-bright); }
.home-estimate .nap a:hover { color: var(--color-white); text-decoration: underline; }
.home-estimate .area-line { margin: 0; font-size: .92rem; color: color-mix(in srgb, var(--color-white) 72%, transparent); }
.home-estimate .floating-ring { left: -120px; bottom: -140px; }

/* ---------- Heading balance (all page headings) ---------- */
.home-hero h1, .home-services h2, .home-materials h2, .home-cta h2, .home-about h2, .home-faq h2, .home-estimate h2, .home-estimate h3 { text-wrap: balance; }

@media (prefers-reduced-motion: reduce) {
  .home-services .service-card__icon, .material-table tbody tr { transition: none; }
}

/* ---------- From the Blog (Phase 6): latest registry post as a featured card ---------- */
.home-blog { background: var(--color-paper-2); }
.home-blog .section-head { display: grid; gap: var(--space-3); max-width: 62ch; margin-bottom: clamp(1.5rem, 3vw, 2.25rem); }
.home-blog .section-head h2 { text-wrap: balance; }
.home-blog .section-head p { margin: 0; color: var(--color-ink-2); }
.home-blog .blog-feature { box-shadow: var(--shadow); background: var(--color-card-tint-3); }
.home-blog__more { margin-top: var(--space-6); display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-3) var(--space-6); }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ HERO (type hero — no client photo on file yet) ============ -->
<section class="hero hero--type home-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="hero-pickets" aria-hidden="true">
    <svg viewBox="0 0 1200 96" preserveAspectRatio="none" focusable="false">
      <defs>
        <pattern id="picket-run" width="30" height="96" patternUnits="userSpaceOnUse">
          <polygon points="6,16 14,4 22,16 22,96 6,96" fill="currentColor"/>
        </pattern>
      </defs>
      <rect x="0" y="0" width="1200" height="96" fill="url(#picket-run)"/>
      <rect x="0" y="40" width="1200" height="7" fill="currentColor"/>
      <rect x="0" y="74" width="1200" height="7" fill="currentColor"/>
    </svg>
  </div>
  <div class="container">
    <div class="hero-grid hero-grid--form">
      <div class="hero-text">
        <span class="eyebrow">Ennis &amp; Waxahachie, TX · Ellis County</span>
        <h1 class="hero-title" id="hero-title">Fence Contractor in <span class="text-accent">Ennis &amp; Waxahachie</span>, TX</h1>
        <p class="hero-answer"><?php echo h($siteName); ?> builds and repairs privacy, cedar, chain link and wrought iron fences within <?php echo (int) $serviceRadiusMiles; ?> miles of Ennis and Waxahachie. The company puts in new fences and gates and fixes leaning or broken ones on homes and farm properties.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
          <li><?php echo icon('clipboard-list', 16); ?>Quotes in writing</li>
          <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Get a free estimate</h2>
        <p class="hero-form-tagline">No obligation. <b>Ennis, Waxahachie &amp; nearby.</b></p>
        <form action="<?php echo h($formAction); ?>" method="POST" class="hero-form">
          <input type="hidden" name="_next" value="<?php echo h($siteUrl); ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="hero">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
          <?php echo p1_attribution_fields('hero'); ?>
          <div class="form-row"><label class="sr-only" for="hero-name">Name</label><input id="hero-name" type="text" name="name" placeholder="Name" autocomplete="name" required></div>
          <div class="form-row"><label class="sr-only" for="hero-phone">Phone</label><input id="hero-phone" type="tel" name="phone" placeholder="Phone" autocomplete="tel" required></div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options(); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Send my request</button>
        </form>
      </aside>
    </div>
  </div>
</section>

<!-- ============ TICKER (torn top edge) ============ -->
<div class="ticker-strip home-ticker edge-torn-top" aria-hidden="true">
  <div class="ticker-track">
<?php for ($tickPass = 0; $tickPass < 2; $tickPass++): foreach ($tickerItems as $tick): ?>
    <span><?php echo icon($tick[0], 18); ?><?php echo h($tick[1]); ?></span>
<?php endforeach; endfor; ?>
  </div>
</div>

<!-- ============ SERVICES ============ -->
<section class="section home-services" aria-label="Fence services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which <span class="text-accent">fences</span> does <?php echo h($siteName); ?> build in <span class="text-accent">Ennis and Waxahachie</span>?</h2>
      <p class="hero-answer"><?php echo h($siteName); ?> builds four kinds of fence (privacy, cedar, chain link and wrought iron) and repairs fences that are already standing, for homes and properties within about <?php echo (int) $serviceRadiusMiles; ?> miles of Ennis and Waxahachie. Pick a fence type below, or call if you are still deciding between materials.</p>
      <span class="section-subtitle">Privacy · Cedar · Chain Link · Wrought Iron · Repair</span>
      <p class="prose">Most calls are one of two jobs: a new fence where there was none, or a fix for a fence that has started to lean, sag or break.</p>
    </div>

    <div class="services-grid">
<?php $cardIdx = 0; foreach ($services as $svc):
        $card = $homeCards[$svc['slug']] ?? null;
        if (!$card) continue;
        $tint = ($cardIdx % 3) + 1;
        $svcBuilt = pageBuilt('/services/' . $svc['slug'] . '/');
        $cardIdx++; ?>
      <article class="service-card-with-image card-tint-<?php echo $tint; ?> reveal-up reveal-delay-<?php echo $tint; ?>">
        <div class="service-card__body">
          <div class="service-card__head">
            <div class="service-card__icon"><?php echo icon($card['icon'], 26); ?></div>
            <h3><?php echo h($svc['name']); ?></h3>
          </div>
          <p class="service-card__desc"><?php echo h($card['desc']); ?></p>
          <ul>
<?php foreach ($card['bullets'] as $bullet): ?>
            <li><?php echo h($bullet); ?></li>
<?php endforeach; ?>
          </ul>
<?php if ($svcBuilt): ?>
          <a href="/services/<?php echo h($svc['slug']); ?>/" class="service-card__cta">Learn more</a>
<?php else: ?>
          <button type="button" class="service-card__cta" data-open-estimate>Price a <?php echo h(strtolower($svc['name'])); ?> job</button>
<?php endif; ?>
        </div>
      </article>
<?php endforeach; ?>
    </div>

    <div class="services-foot reveal-up">
<?php if ($servicesHubBuilt): ?>
      <a href="/services/" class="btn btn-secondary">View All Services →</a>
<?php else: ?>
      <button type="button" class="btn btn-secondary" data-open-estimate>Ask about your fence →</button>
<?php endif; ?>
      <p>Not sure which type fits? Call <?php echo phoneLink(); ?> and describe the yard.</p>
    </div>
  </div>
</section>

<!-- ============ PROOF STRIP (verifiable intake facts only) ============ -->
<section class="stats-band texture-grain slant-top home-proof" aria-label="<?php echo h($siteName); ?> at a glance">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="stats-row">
      <div class="stat-item reveal-left reveal-delay-1"><span class="stat-number"><span><?php echo (int) $serviceRadiusMiles; ?></span>-Mile</span><span class="stat-label">Service radius from Ennis &amp; Waxahachie</span></div>
      <div class="stat-item reveal-left reveal-delay-2"><span class="stat-number"><span>4</span> Fence Types</span><span class="stat-label">Privacy, cedar, chain link, wrought iron</span></div>
      <div class="stat-item reveal-left reveal-delay-3"><span class="stat-number">Repair <span>+</span> Build</span><span class="stat-label">Old fences fixed, new ones installed</span></div>
      <div class="stat-item reveal-left reveal-delay-4"><span class="stat-number">Ellis <span>County</span></span><span class="stat-label">Where Ennis and Waxahachie both sit</span></div>
    </div>
  </div>
</section>

<!-- ============ SIGNATURE: MATERIAL GUIDE ============ -->
<section class="section home-materials" aria-labelledby="materials-title">
  <div class="container-wide">
    <div class="materials-layout">
      <div class="materials-intro reveal-left">
        <span class="eyebrow">Choosing a material</span>
        <h2 id="materials-title">Cedar, chain link or <span class="text-accent">wrought iron</span>: which fits your property?</h2>
        <p class="hero-answer">Pick cedar for privacy and a wood look, chain link for the lowest cost and an open view, and wrought iron for a decorative front yard or pool line. <?php echo h($siteName); ?> builds all three, so the choice comes down to what the fence has to do.</p>
        <aside class="ground-note">
          <h3>Whatever the material, the posts carry it</h3>
          <p>Ennis and Waxahachie sit on Blackland Prairie clay, which swells after heavy rain and shrinks and cracks in a dry summer. That movement is what works fence posts out of line, so a leaning section is usually a post problem, not a board problem.</p>
        </aside>
      </div>

      <div class="spec-sheet reveal-right">
        <div class="spec-sheet__head"><span>Material guide</span><b>Three fence materials, side by side</b></div>
        <div class="table-scroll" role="region" aria-label="Fence material comparison table" tabindex="0">
          <table class="material-table">
            <caption class="sr-only">Comparison of cedar, chain link and wrought iron fencing by use, look, upkeep and relative material cost</caption>
            <thead>
              <tr><th scope="col">Material</th><th scope="col">Best for</th><th scope="col">Look</th><th scope="col">Upkeep</th><th scope="col">Material cost</th></tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">Cedar<small>Privacy or picket boards</small></th>
                <td>Backyard privacy, pets, a natural wood finish</td>
                <td>Warm red-brown; weathers to silver-gray if left bare</td>
                <td>Stain or sealer from time to time keeps the color</td>
                <td><span class="cost-scale" aria-hidden="true"><i class="on"></i><i class="on"></i><i></i></span>Middle</td>
              </tr>
              <tr>
                <th scope="row">Chain link<small>Galvanized wire mesh</small></th>
                <td>Dogs, kids, perimeters and the tightest budget</td>
                <td>Open mesh; keeps the view and the light</td>
                <td>Very little once it is up</td>
                <td><span class="cost-scale" aria-hidden="true"><i class="on"></i><i></i><i></i></span>Lowest</td>
              </tr>
              <tr>
                <th scope="row">Wrought iron<small>Ornamental metal</small></th>
                <td>Front yards, entries, pools and security lines</td>
                <td>Open pickets with a decorative top</td>
                <td>Low when coated; touch up scratches before rust starts</td>
                <td><span class="cost-scale" aria-hidden="true"><i class="on"></i><i class="on"></i><i class="on"></i></span>Highest</td>
              </tr>
            </tbody>
          </table>
        </div>
        <p class="spec-sheet__foot">Relative material cost only. Your estimate prices the actual run: length, height, gates, ground and any old fence removal.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ MID-PAGE CTA ============ -->
<section class="cta-banner texture-grain edge-curve-top home-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-copy reveal-scale">
      <span class="eyebrow">Fence leaning or down?</span>
      <h2 id="cta-title">One loose post pulls the panels beside it out of line</h2>
      <p>A leaning section puts its weight on the posts next to it, and wet-dry swings in clay ground keep working it looser. <?php echo h($siteName); ?> repairs <?php echo serviceLink('fence-repair', 'leaning and broken fences'); ?> as well as building new ones, so call before one bad post becomes a whole run.</p>
    </div>
    <div class="actions reveal-scale reveal-delay-2">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Request a repair estimate</button>
      <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
    </div>
  </div>
</section>

<!-- ============ ABOUT + PROCESS (asymmetric) ============ -->
<section class="section home-about" aria-labelledby="about-title">
  <div class="container-wide">
    <div class="about-split">
      <div class="about-left reveal-left">
        <span class="eyebrow">About <?php echo h($siteName); ?></span>
        <h2 id="about-title">Who builds the fence at <?php echo h($siteName); ?>?</h2>
        <p><?php echo h($siteName); ?> is a fence contractor owned by <?php echo h($ownerName); ?>, building and repairing fences around Ennis and Waxahachie for <?php echo (int) $yearsInBusiness; ?> years. The work covers the four fence types most properties here call for, <?php echo serviceLink('privacy-fence', 'privacy'); ?>, <?php echo serviceLink('cedar-fence', 'cedar'); ?>, <?php echo serviceLink('chain-link', 'chain link'); ?> and <?php echo serviceLink('wrought-iron', 'wrought iron'); ?>, plus repairs to fences that are already standing.</p>
        <p>Jobs range from a backyard privacy run to <?php echo serviceLink('fence-installation', 'new fence and gate installation'); ?> on residential and farm properties. The office answers <?php echo phoneLink(); ?> Monday through Friday, and the estimate form on this page reaches <?php echo h($siteName); ?> any time.</p>

        <h3 class="process-title">How a <?php echo h($siteName); ?> job runs</h3>
        <ol class="process-steps">
          <li><b>Reach out</b><span>Call or send the form with the fence type, a rough length and the town the property is in.</span></li>
          <li><b>Estimate on site</b><span>The fence line is walked and measured, with the ground, gates and any old fence noted, and the quote comes back in writing.</span></li>
          <li><b>Line and rules</b><span>Before any digging, the property line is confirmed from your plat or survey and city or HOA rules are checked.</span></li>
          <li><b>Build</b><span>A typical residential run takes one to three days, depending on its length, the ground and the weather.</span></li>
        </ol>
      </div>

      <div class="about-right reveal-right">
        <figure class="drawing-panel">
          <figcaption>The part of a fence you never see, the post below grade, is the part Blackland clay pushes on.</figcaption>
          <svg class="fence-drawing" viewBox="0 0 400 470" role="img" aria-labelledby="fence-drawing-title" focusable="false">
            <title id="fence-drawing-title">Drawing of a wood fence section: posts set below grade in clay soil, rails running between the posts, and pickets fastened to the rails on one bay</title>
<?php for ($gx = 20; $gx < 400; $gx += 40): ?>
            <line class="grid-line" x1="<?php echo $gx; ?>" y1="0" x2="<?php echo $gx; ?>" y2="470"/>
<?php endfor; for ($gy = 20; $gy < 470; $gy += 40): ?>
            <line class="grid-line" x1="0" y1="<?php echo $gy; ?>" x2="400" y2="<?php echo $gy; ?>"/>
<?php endfor; ?>
            <!-- clay below grade -->
            <rect class="clay" x="0" y="330" width="400" height="140"/>
            <path class="crack" d="M70 330 l8 22 -6 14 10 24"/>
            <path class="crack" d="M150 330 l-6 18 9 16 -4 20"/>
            <path class="crack" d="M262 330 l7 20 -8 12 6 26"/>
            <path class="crack" d="M330 330 l-5 16 8 18"/>
            <line class="grade" x1="0" y1="330" x2="400" y2="330"/>
            <!-- rails across both bays -->
            <rect class="rail" x="48" y="150" width="304" height="10" rx="2"/>
            <rect class="rail" x="48" y="282" width="304" height="10" rx="2"/>
            <!-- pickets on the right bay only -->
<?php for ($px = 214; $px + 16 <= 348; $px += 19): ?>
            <path class="picket" d="M<?php echo $px; ?> 118 l8 -10 l8 10 V326 H<?php echo $px; ?> Z"/>
<?php endfor; ?>
            <!-- posts: above grade solid, below grade dashed -->
<?php foreach ([40, 196, 352] as $postX): ?>
            <rect class="post" x="<?php echo $postX - 8; ?>" y="96" width="16" height="234" rx="2"/>
            <rect class="post-buried" x="<?php echo $postX - 8; ?>" y="330" width="16" height="104" rx="2"/>
<?php endforeach; ?>
            <!-- labels -->
            <path class="leader" d="M118 155 V58 H150"/>
            <text class="label" x="156" y="62">RAIL</text>
            <path class="leader" d="M290 108 V40 H318"/>
            <text class="label" x="324" y="44">PICKET</text>
            <path class="leader" d="M48 110 H20 V40 H34"/>
            <text class="label" x="38" y="44">POST</text>
            <text class="label" x="14" y="320">GRADE</text>
            <text class="label label--accent" x="236" y="455">BELOW GRADE · CLAY</text>
          </svg>
        </figure>
        <div class="about-stat-card">
          <b><?php echo (int) $yearsInBusiness; ?> years</b>
          <span>building and repairing fences around Ennis and Waxahachie</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ GOOGLE REVIEWS (Page One feed; renders nothing until the profile has written reviews) ============ -->
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$homeReviews = p1_google_reviews($slug, ['heading' => 'What Ennis and Waxahachie customers say on Google']);
if ($homeReviews !== ''): ?>
<section class="section home-reviews" aria-label="Google reviews"><div class="container"><?php echo $homeReviews; ?></div></section>
<?php endif; ?>

<!-- ============ FAQ ============ -->
<section class="section home-faq" aria-labelledby="faq-title">
  <div class="container">
    <div class="section-head reveal-down">
      <span class="eyebrow">Fence questions</span>
      <h2 id="faq-title">What do Ennis and Waxahachie homeowners ask before a <span class="text-accent">new fence</span>?</h2>
      <p>These six fence questions cover cost, permits, property lines, materials, timing and service area, with straight answers from <?php echo h($siteName); ?> for homeowners and property owners in Ennis, Waxahachie and nearby towns.</p>
    </div>
    <div class="faq-grid reveal-up">
<?php foreach ($homeFaqs as $faqIdx => $faq): ?>
      <details class="faq"<?php echo $faqIdx < 2 ? ' open' : ''; ?>>
        <summary><?php echo h($faq['q']); ?></summary>
        <p><?php echo h($faq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
    <p class="faq-more">Have a question that is not here? Call <?php echo phoneLink(); ?> or email <?php echo emailLink(); ?>.</p>
  </div>
</section>

<!-- ============ FROM THE BLOG (registry-driven: latest post) ============ -->
<?php $blogPosts = blogLoad(); if ($blogPosts): ?>
<section class="section home-blog" aria-labelledby="blog-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow">From the Blog</span>
      <h2 id="blog-title">What should Ennis and Waxahachie owners read before building a <span class="text-accent">fence</span>?</h2>
      <p>Read the latest fence guide before you build: it gives plain answers on what a fence costs, why posts lean in Ellis County clay and which city rules apply in Ennis and Waxahachie.</p>
    </div>
    <?php echo blogCard($blogPosts[0], 'blog-feature reveal-up'), "\n"; ?>
    <div class="home-blog__more">
      <a class="btn btn-secondary" href="/blog/">View All Articles →</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ ESTIMATE SECTION (full form) ============ -->
<section class="section home-estimate texture-grain edge-wave-top" id="estimate" aria-labelledby="estimate-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container-wide">
    <div class="estimate">
      <div class="card reveal-up">
        <span class="eyebrow">Estimate request</span>
        <h2 id="estimate-title">Tell us about the job</h2>
        <p class="lead">The fence type, a rough length and the town are enough to get started.</p>
        <form action="<?php echo h($formAction); ?>" method="POST" class="estimate-form">
          <input type="hidden" name="_next" value="<?php echo h($siteUrl); ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="estimate-section">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
          <?php echo p1_attribution_fields('estimate-section'); ?>

          <div class="form-grid">
            <div class="field">
              <label for="est-name">Your Name</label>
              <input id="est-name" type="text" name="name" autocomplete="name" required>
            </div>
            <div class="field">
              <label for="est-phone">Phone</label>
              <input id="est-phone" type="tel" name="phone" autocomplete="tel" required>
            </div>
            <div class="field">
              <label for="est-email">Email</label>
              <input id="est-email" type="email" name="email" autocomplete="email" required>
            </div>
            <div class="field">
              <label for="est-service">Service Needed</label>
              <select id="est-service" name="service">
                <option value="">Select a service</option>
<?php foreach ($services as $estOpt): ?>
                <option value="<?php echo h($estOpt['name']); ?>"><?php echo h($estOpt['name']); ?></option>
<?php endforeach; ?>
              </select>
            </div>
            <div class="field full">
              <label for="est-message">Project Details</label>
              <textarea id="est-message" name="message" rows="4" placeholder="Fence type, rough length, gates, and which town the property is in"></textarea>
            </div>
          </div>

          <fieldset class="form-consent-fieldset">
            <legend class="form-consent-legend">Communication Consent</legend>
            <label class="form-consent-item">
              <input type="checkbox" name="email_opt_in" value="yes" class="consent-checkbox">
              <span class="consent-label"><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo h($siteName); ?> about my inquiry, services, promotions, and news. I understand I can unsubscribe anytime via the link in any email or by emailing <?php echo emailLink(); ?>. Message frequency varies.</span>
            </label>
            <label class="form-consent-item">
              <input type="checkbox" name="sms_opt_in" value="yes" class="consent-checkbox">
              <span class="consent-label"><strong>SMS/Text messages (optional):</strong> I agree to receive text messages from <?php echo h($siteName); ?> at the phone number I provided. Message types may include appointment reminders, service updates, and promotional offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. <strong>Consent is not a condition of purchase.</strong></span>
            </label>
            <label class="form-consent-item form-consent-required">
              <input type="checkbox" name="terms_accepted" value="yes" class="consent-checkbox" required>
              <span class="consent-label">I have read and agree to the <a href="/privacy-policy/">Privacy Policy</a> and <a href="/terms/">Terms of Service</a>. <span class="required-star">*</span></span>
            </label>
          </fieldset>

          <button type="submit" class="btn btn-primary btn-block btn-lg">Send my estimate request</button>
        </form>
      </div>

      <div class="estimate-aside reveal-right">
        <h3>What happens next</h3>
        <ol class="next-steps">
          <li><strong>Your request reaches <?php echo h($siteName); ?></strong>The form goes straight to the office with your fence type, length and town.</li>
          <li><strong>A call to set up the estimate</strong>Expect a call back during business hours to arrange a time to look at the fence line.</li>
          <li><strong>A written quote</strong>Materials and labor for your run, in writing, before any work starts.</li>
        </ol>
        <div class="nap">
          <div><?php echo icon('phone', 18); ?><a href="tel:<?php echo h($phoneRaw); ?>"><?php echo h($phone); ?></a></div>
          <div><?php echo icon('mail', 18); ?><a href="mailto:<?php echo h($email); ?>"><?php echo h($email); ?></a></div>
          <div><?php echo icon('clock', 18); ?><span><?php echo h($businessHours); ?></span></div>
          <div><?php echo icon('map-pin', 18); ?><span>Serving <?php echo h(areaList() . ', ' . $address['state']); ?></span></div>
        </div>
        <p class="area-line"><?php echo h($siteName); ?> works on properties within about <?php echo (int) $serviceRadiusMiles; ?> miles of Ennis and Waxahachie, from the I-45 side of Ellis County to the I-35E side.</p>
      </div>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
