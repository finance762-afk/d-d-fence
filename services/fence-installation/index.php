<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/fence-installation/ — D & D Fence (Phase 4, 2026-10-19). Premium editorial service page (interactive-patterns §2.8).
 * No client photos on file: type hero with a survey-stake motif; the signature is the gate planner (plan-view drawing +
 * a real <table>). Section order differs from the material pages: pre-dig checklist → gate planner (dark) → material
 * picker → scope/process → reviews → FAQ. Proof is live from the Google reviews feed (serviceReviews), never hard-coded.
 * Facts the page wanted but intake lacks (opener brands, power, gate widths, farm fence types) are in /content-confirmations.json.
 */
$svc            = serviceBySlug('fence-installation');
$pageTitle      = 'Fence & Gate Installation in Ennis & Waxahachie, TX | ' . $siteName;
$pageDescription = 'New fence and gate installation by D & D Fence in Ennis, Waxahachie and Ellis County: swing, sliding and automatic gates planned in. Call (469) 321-7783.';
$canonicalUrl   = $siteUrl . '/services/fence-installation/';
$ogImage        = defaultOgImage();
$currentPage    = 'services';
$pageType       = 'service';
$serviceSlug    = 'fence-installation';

$fiFaqs = [
    ['q' => 'How much does fence installation cost in Ennis or Waxahachie?',
     'a' => 'New fence installation is quoted per linear foot of fence, plus each gate. What moves the number is the material, the height, how many gates the run needs and what kind (an automatic opener adds hardware and a power source), the ground along the line, and any old fence that must come out. D & D Fence measures on site and writes the quote down.'],
    ['q' => 'Do I need a permit or HOA approval to install a new fence?',
     'a' => 'Usually you need at least one of the two. Cities in Ellis County can require a fence permit and cap heights, and an HOA may approve the material, color and gate locations before work starts. D & D Fence can look up the requirements for your address while the layout is still on paper.'],
    ['q' => 'How long does fence installation take, and what warranty comes with it?',
     'a' => 'A typical residential install takes one to three days once the materials are on site, depending on length, ground and weather. Big gate jobs with an opener can take more than one visit to finish. Warranty coverage depends on the material and the workmanship, and D & D Fence gives you the exact terms in writing with the estimate.'],
    ['q' => 'Who finds the property line before a new fence is installed?',
     'a' => 'The owner does, using the survey or plat from closing; the fence crew builds to that line. If the corner pins are buried or missing, hire a licensed surveyor to stake them before installation day. A new fence set a foot onto the neighbor\'s side is expensive to move.'],
];

$schemaMarkup = servicePageSchema(
    $svc,
    'Fence and Gate Installation in Ennis & Waxahachie, TX',
    'New fence and gate installation by D & D Fence for residential and farm properties in Ennis, Waxahachie and the surrounding Ellis County area: layout, utility locate, posts, fence, walk, drive, sliding and automatic gates, and old fence removal.',
    generateFAQSchema($fiFaqs),
    ['serviceType' => 'Fence and gate installation']
);

$fiReviews = serviceReviews('gate|opener|measure|linear', 3);
$fiCards   = serviceCards();
$fiRelated = ['privacy-fence', 'chain-link', 'wrought-iron'];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?>

/* ==========================================================================
   Fence installation — page-specific composition: survey-stake hero motif, torn-edge pre-dig checklist,
   dark gate planner (plan-view drawing + table, the signature), material picker, scope/process on paper-2.
   Tokens only.
   ========================================================================== */
.fi-hero .sp-hero__motif { opacity: .09; width: min(60%, 780px); }
.fi-hero .eyebrow::before { width: 14px; height: 14px; border-radius: 2px; background: transparent; border: 2px solid var(--color-accent); transform: rotate(45deg); }

/* ---------- Pre-dig checklist: stake cards on a string line ---------- */
.fi-predig.edge-torn-top {
  position: relative;
  z-index: 2;
  margin-top: calc(-1 * var(--space-5));
  background: var(--color-paper);
}
.fi-predig__head { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: var(--space-4) clamp(2rem, 5vw, 4rem); align-items: end; margin-bottom: clamp(2rem, 4vw, 3rem); }
.fi-predig__head .answer-block { margin: 0; grid-column: 2; grid-row: 1 / span 2; }
.fi-predig__head .eyebrow, .fi-predig__head h2 { grid-column: 1; }
.fi-stakes {
  position: relative;
  display: grid;
  grid-template-columns: repeat(5, minmax(0, 1fr));
  gap: var(--space-4);
  margin: 0;
  padding: var(--space-8) 0 0;
  list-style: none;
  counter-reset: fi-stake;
}
.fi-stakes::before {
  content: "";
  position: absolute;
  left: 0;
  right: 0;
  top: var(--space-4);
  height: 2px;
  background: repeating-linear-gradient(90deg, var(--color-accent) 0 14px, transparent 14px 22px);
}
.fi-stakes > li {
  position: relative;
  counter-increment: fi-stake;
  display: grid;
  gap: var(--space-2);
  align-content: start;
  padding: var(--space-6) var(--space-5) var(--space-5);
  background: var(--color-surface);
  border: 1px solid var(--color-line);
  border-top: 4px solid var(--color-accent);
  border-radius: 0 0 var(--radius) var(--radius);
  box-shadow: var(--shadow-sm);
  transition: transform var(--transition-slow), box-shadow var(--transition-slow);
}
.fi-stakes > li:nth-child(even) { margin-top: var(--space-6); border-top-color: var(--color-primary); }
.fi-stakes > li:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
.fi-stakes > li::before {
  content: counter(fi-stake, decimal-leading-zero);
  position: absolute;
  top: calc(-1 * var(--space-8));
  left: var(--space-5);
  padding: 0 var(--space-2);
  background: var(--color-paper);
  font-family: var(--font-accent);
  font-weight: 700;
  font-size: 1rem;
  letter-spacing: .1em;
  color: var(--color-accent-dark);
}
.fi-stakes > li > svg { color: var(--color-accent-dark); }
.fi-stakes h3 { font-size: 1.02rem; }
.fi-stakes p { margin: 0; font-size: .92rem; color: var(--color-ink-2); }
@media (max-width: 1100px) {
  .fi-stakes { grid-template-columns: repeat(3, minmax(0, 1fr)); row-gap: var(--space-10); }
  .fi-stakes > li:nth-child(even) { margin-top: 0; }
}
@media (max-width: 900px) { .fi-predig__head { grid-template-columns: 1fr; } .fi-predig__head .answer-block { grid-column: 1; grid-row: auto; } }
@media (max-width: 640px) {
  .fi-stakes { grid-template-columns: 1fr; padding-top: var(--space-4); row-gap: var(--space-8); }
  .fi-stakes::before { display: none; }
  .fi-stakes > li::before { top: calc(-1 * var(--space-6)); background: transparent; padding: 0; }
}

/* ---------- Signature: gate planner (dark band, plan drawing + table) ---------- */
.fi-gates { padding-bottom: calc(var(--section-pad) + var(--space-4)); }
.fi-gates .floating-ring { right: -120px; top: 12%; }
.fi-gates__top { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1.05fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: center; margin-bottom: clamp(2rem, 4vw, 3rem); }
.fi-gates .answer-block {
  background: color-mix(in srgb, var(--color-white) 6%, transparent);
  border-left-color: var(--color-accent-bright);
  color: color-mix(in srgb, var(--color-white) 90%, transparent);
}
.fi-gates__intro { display: grid; gap: var(--space-4); }
.fi-gates__intro > p:not(.answer-block) { margin: 0; color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.fi-plan {
  margin: 0;
  padding: var(--space-5);
  border: 1px solid color-mix(in srgb, var(--color-white) 16%, transparent);
  border-radius: var(--radius-lg);
  background:
    linear-gradient(color-mix(in srgb, var(--color-white) 5%, transparent) 1px, transparent 1px) 0 0 / 24px 24px,
    linear-gradient(90deg, color-mix(in srgb, var(--color-white) 5%, transparent) 1px, transparent 1px) 0 0 / 24px 24px,
    color-mix(in srgb, var(--color-white) 3%, transparent);
}
.fi-plan svg { width: 100%; height: auto; display: block; }
.fi-plan figcaption { margin-top: var(--space-3); font-size: .86rem; color: color-mix(in srgb, var(--color-white) 70%, transparent); }
.fi-plan .pl-fence { stroke: var(--color-paper); stroke-width: 4; stroke-linecap: round; }
.fi-plan .pl-post { fill: var(--color-accent-bright); }
.fi-plan .pl-leaf { stroke: var(--color-accent-bright); stroke-width: 5; stroke-linecap: round; }
.fi-plan .pl-arc { fill: color-mix(in srgb, var(--color-accent) 18%, transparent); stroke: var(--color-accent-bright); stroke-width: 1.5; stroke-dasharray: 6 5; }
.fi-plan .pl-clear { fill: color-mix(in srgb, var(--color-accent) 14%, transparent); stroke: var(--color-accent-bright); stroke-width: 1.5; stroke-dasharray: 6 5; }
.fi-plan .pl-arrow { stroke: var(--color-paper); stroke-width: 2; fill: none; }
.fi-plan .pl-drive { stroke: color-mix(in srgb, var(--color-paper) 30%, transparent); stroke-width: 1.5; stroke-dasharray: 3 6; }
.fi-plan .pl-label { font-family: var(--font-accent); font-weight: 700; font-size: 13px; letter-spacing: .14em; fill: var(--color-paper); }
.fi-plan .pl-label--accent { fill: var(--color-accent-bright); }
.fi-gates .sp-sheet { box-shadow: var(--shadow-lg); color: var(--color-ink); }
.fi-gates .sp-sheet__head b { color: var(--color-ink); }
.fi-gates .sp-sheet .sp-sheet__foot { color: var(--color-muted); }
.fi-gates .sp-table tbody th { width: 20%; }
.fi-gates .sp-table td:last-child { color: var(--color-ink); }
.fi-tag { display: inline-block; margin-top: var(--space-2); padding: var(--space-1) var(--space-2); border-radius: var(--radius-sm); background: var(--color-card-tint-3); font-family: var(--font-accent); font-size: .74rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--color-accent-dark); }
.fi-ledger { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-4); margin: var(--space-8) 0 0; padding: 0; list-style: none; }
.fi-ledger li { display: grid; grid-template-columns: 26px 1fr; gap: var(--space-3); padding: var(--space-4) var(--space-5); border-left: 2px solid var(--color-accent-bright); background: color-mix(in srgb, var(--color-white) 4%, transparent); border-radius: 0 var(--radius) var(--radius) 0; font-size: .93rem; color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.fi-ledger li svg { color: var(--color-accent-bright); margin-top: 2px; }
.fi-ledger li strong { color: var(--color-white); }
@media (max-width: 960px) {
  .fi-gates__top { grid-template-columns: 1fr; }
  .fi-ledger { grid-template-columns: 1fr; }
}

/* ---------- Material picker ---------- */
.fi-materials { background: var(--color-surface); }
.fi-materials__grid { display: grid; grid-template-columns: minmax(0, .85fr) minmax(0, 1.6fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.fi-picks { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: var(--space-4); margin: 0; padding: 0; list-style: none; }
.fi-picks > li {
  position: relative;
  display: grid;
  grid-template-columns: 48px 1fr;
  gap: var(--space-2) var(--space-4);
  align-items: start;
  padding: var(--space-5) var(--space-5) var(--space-5) var(--space-4);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-lg);
  background: var(--color-paper);
  transition: border-color var(--transition), transform var(--transition-slow), box-shadow var(--transition-slow);
}
.fi-picks > li:hover { border-color: var(--color-accent); transform: translateY(-3px); box-shadow: var(--shadow); }
.fi-picks > li:nth-child(1) { background: var(--color-card-tint-1); }
.fi-picks > li:nth-child(2) { background: var(--color-card-tint-3); }
.fi-picks > li:nth-child(3) { background: var(--color-card-tint-2); }
.fi-picks__icon { grid-row: span 2; width: 48px; height: 48px; display: grid; place-items: center; border-radius: var(--radius); background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow-sm); }
.fi-picks h3 { font-size: 1.08rem; }
.fi-picks h3 a { color: var(--color-ink); text-decoration: underline; text-decoration-color: color-mix(in srgb, var(--color-accent) 55%, transparent); text-underline-offset: .18em; }
.fi-picks h3 a:hover { color: var(--color-accent-dark); }
.fi-picks p { margin: 0; font-size: .93rem; color: var(--color-ink-2); }
@media (max-width: 960px) { .fi-materials__grid { grid-template-columns: 1fr; } }
@media (max-width: 600px) { .fi-picks { grid-template-columns: 1fr; } }

/* ---------- Scope + process on paper-2 (timeline left, included right) ---------- */
.fi-scope.sp-scope { background: var(--color-paper-2); }
.fi-scope .sp-scope__grid { grid-template-columns: minmax(0, 1.25fr) minmax(0, 1fr); }
.fi-scope .sp-scope__aside { order: 2; }
.fi-scope .sp-included { background: var(--color-surface); border-style: solid; }
.fi-scope .sp-timeline > li::before { border-radius: var(--radius-sm); transform: rotate(45deg); }
.fi-scope .sp-timeline > li::before { content: ""; width: 30px; height: 30px; left: calc(5px - var(--space-12)); top: 5px; }
.fi-scope .sp-timeline > li > b {
  position: absolute;
  left: calc(-1 * var(--space-12));
  top: 0;
  width: 40px;
  height: 40px;
  display: grid;
  place-items: center;
  font-family: var(--font-accent);
  font-size: 1rem;
  color: var(--color-accent-dark);
  pointer-events: none;
}
.fi-scope .sp-timeline > li:hover > b { color: var(--color-white); }
@media (max-width: 900px) { .fi-scope .sp-scope__aside { order: 0; } .fi-scope .sp-scope__grid { grid-template-columns: 1fr; } }

/* ---------- Proof on paper, FAQ on surface ---------- */
.fi-proof .sp-head { max-width: 66ch; }
.fi-proof .sp-quote { border-top: 4px solid var(--color-accent); }
.fi-faq .sp-head { max-width: none; }

.fi-cta .floating-ring { left: -110px; right: auto; top: auto; bottom: -150px; }

@media (prefers-reduced-motion: reduce) {
  .fi-stakes > li, .fi-picks > li { transition: none; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ 1. HERO (type hero, survey-stake motif; no client photo on file yet) ============ -->
<section class="hero hero--interior sp-hero fi-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="sp-hero__motif" aria-hidden="true">
    <svg viewBox="0 0 720 420" preserveAspectRatio="xMaxYMax slice" focusable="false">
      <path d="M0 250 L720 196" stroke="currentColor" stroke-width="2" stroke-dasharray="10 7" fill="none"/>
<?php foreach ([40, 160, 280, 400, 520, 640] as $fiStakeX):
        $fiStakeY = 250 - ($fiStakeX * 54 / 720); ?>
      <path d="M<?php echo $fiStakeX - 5; ?> <?php echo round($fiStakeY - 70); ?> h10 V<?php echo round($fiStakeY + 90); ?> l-5 14 l-5 -14 Z" fill="currentColor"/>
      <path d="M<?php echo $fiStakeX + 5; ?> <?php echo round($fiStakeY - 70); ?> l34 9 l-34 9 Z" fill="currentColor"/>
<?php endforeach; ?>
      <line x1="0" y1="372" x2="720" y2="372" stroke="currentColor" stroke-width="3"/>
    </svg>
  </div>
  <div class="container">
    <div class="hero-grid hero-grid--form">
      <div class="hero-copy">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="breadcrumb-sep" aria-hidden="true">/</li>
            <li><a href="/services/">Services</a></li>
            <li class="breadcrumb-sep" aria-hidden="true">/</li>
            <li><span aria-current="page">Fence Installation</span></li>
          </ol>
        </nav>
        <span class="eyebrow">New fences &amp; gates · Ennis &amp; Waxahachie, TX</span>
        <h1 class="hero-title" id="hero-title">Fence &amp; Gate Installation in <span class="text-accent">Ennis &amp; Waxahachie</span>, TX</h1>
        <p class="hero-answer"><?php echo h($siteName); ?> installs new fences and gates on homes and farm properties in Ennis, Waxahachie and the area within about <?php echo (int) $serviceRadiusMiles; ?> miles. The job starts with the line, buried utilities and the gates you need, then the posts and fence go in, so the finished run matches how you use the property.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
          <li><?php echo icon('waypoints', 16); ?>Swing, sliding &amp; automatic gates</li>
          <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Want a free fence installation estimate?</h2>
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
          <div class="form-row"><label class="sr-only" for="hero-email">Email</label><input id="hero-email" type="email" name="email" placeholder="Email" autocomplete="email" required></div>
          <div class="form-row"><label class="sr-only" for="hero-service">Service</label><select id="hero-service" name="service"><?php echo p1_service_options($svc['name']); ?></select></div>
          <label class="consent" for="hero-terms"><input id="hero-terms" type="checkbox" name="terms_accepted" value="yes" required><span>I agree to the <a href="/terms/" target="_blank" rel="noopener">Terms</a> and <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and consent to be contacted. *</span></label>
          <button type="submit" class="btn btn-primary btn-block">Send my request</button>
        </form>
      </aside>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

<!-- ============ 2. BEFORE THE FIRST POST HOLE (torn edge into the hero) ============ -->
<section class="section fi-predig edge-torn-top" aria-labelledby="predig-title">
  <div class="container-wide">
    <div class="fi-predig__head reveal-up">
      <span class="eyebrow">Before any digging</span>
      <h2 id="predig-title">What has to happen before the first post hole is dug for a new fence?</h2>
      <p class="answer-block">Five things get settled before the first post hole for a new fence. They are the property line, buried utilities, city and HOA rules, gate locations, and whether an old fence comes out. Skipping any one of them is how fences end up moved, redone or torn out.</p>
    </div>
    <ol class="fi-stakes">
      <li class="reveal-up reveal-delay-1">
        <?php echo icon('map', 24); ?>
        <h3>Find the property line</h3>
        <p>Your survey or plat from closing shows where the line runs. If the corner pins are lost, a surveyor can re-stake them first.</p>
      </li>
      <li class="reveal-up reveal-delay-2">
        <?php echo icon('waypoints', 24); ?>
        <h3>Locate buried utilities</h3>
        <p>Texas811 marks gas, power and water lines at no charge. Two Google reviewers noted the utility check on their jobs was done before any work began.</p>
      </li>
      <li class="reveal-up reveal-delay-3">
        <?php echo icon('landmark', 24); ?>
        <h3>Check city and HOA rules</h3>
        <p>Height limits, permits and HOA approval of material or color are cheaper to sort out on paper than after the posts are set.</p>
      </li>
      <li class="reveal-up reveal-delay-1">
        <?php echo icon('route', 24); ?>
        <h3>Place every gate</h3>
        <p>Mowers, trailers, trash bins and the dog's route all decide where a gate belongs and how wide it should be.</p>
      </li>
      <li class="reveal-up reveal-delay-2">
        <?php echo icon('truck', 24); ?>
        <h3>Plan the old fence out</h3>
        <p>If a worn fence stands on the same line, its removal and haul-off is part of the job and part of the estimate.</p>
      </li>
    </ol>
  </div>
</section>

<!-- ============ 3. SIGNATURE: GATE PLANNER (dark band, plan drawing + real table) ============ -->
<section class="section fi-gates texture-grain edge-parallelogram-top" aria-labelledby="gates-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container-wide">
    <div class="fi-gates__top">
      <div class="fi-gates__intro reveal-left">
        <span class="eyebrow">Gate planner</span>
        <h2 id="gates-title">Which gate belongs on your new fence: swing, double drive, sliding or automatic?</h2>
        <p class="answer-block">The right gate depends on what passes through it and how much open ground sits beside it. A single swing gate suits people and mowers, a double drive gate suits vehicles, a sliding gate suits tight or sloped driveways, and an opener suits gates you use many times a day.</p>
        <p>Gates are the moving part of a fence, so they take the most wear. Planning them into the layout from the start puts a heavier post on each side, lines the latch up with how you walk, and leaves room for an opener later if you want one.</p>
      </div>
      <figure class="fi-plan reveal-right">
        <svg viewBox="0 0 560 260" role="img" aria-labelledby="plan-title" focusable="false">
          <title id="plan-title">Plan view of a fence line seen from above, with a swing gate on the left showing the arc of ground it needs to open, and a sliding gate on the right showing the straight run of fence it rolls along when it opens</title>
          <line class="pl-drive" x1="300" y1="130" x2="300" y2="250"/>
          <line class="pl-drive" x1="420" y1="130" x2="420" y2="250"/>
          <path class="pl-arc" d="M60 130 L60 40 A90 90 0 0 1 150 130 Z"/>
          <line class="pl-fence" x1="10" y1="130" x2="60" y2="130"/>
          <line class="pl-fence" x1="150" y1="130" x2="300" y2="130"/>
          <line class="pl-fence" x1="420" y1="130" x2="550" y2="130"/>
          <line class="pl-leaf" x1="60" y1="130" x2="124" y2="66"/>
          <rect class="pl-clear" x="420" y="102" width="122" height="22" rx="3"/>
          <line class="pl-leaf" x1="300" y1="130" x2="420" y2="130"/>
          <path class="pl-arrow" d="M330 152 H452 M440 144 l12 8 l-12 8"/>
<?php foreach ([60, 150, 300, 420] as $fiPostX): ?>
          <rect class="pl-post" x="<?php echo $fiPostX - 6; ?>" y="124" width="12" height="12" rx="2"/>
<?php endforeach; ?>
          <text class="pl-label" x="30" y="24">SWING GATE</text>
          <text class="pl-label pl-label--accent" x="30" y="166">CLEAR THE ARC</text>
          <text class="pl-label" x="300" y="88">SLIDING GATE</text>
          <text class="pl-label pl-label--accent" x="300" y="190">CLEAR THE RUN BESIDE IT</text>
          <text class="pl-label" x="318" y="238">DRIVEWAY</text>
        </svg>
        <figcaption>A swing gate needs open, fairly level ground across its whole arc. A sliding gate needs none, but it needs a straight stretch of fence beside the opening at least as long as the gate.</figcaption>
      </figure>
    </div>

    <div class="sp-sheet reveal-up">
      <div class="sp-sheet__head"><span>Gate planner</span><b>Four common gates, side by side</b></div>
      <div class="table-scroll" role="region" aria-label="Gate type comparison" tabindex="0">
        <table class="sp-table">
          <caption class="sr-only">Comparison of single walk gates, double drive gates, sliding gates and gates with automatic openers by use, space needed and what to plan before the fence is built</caption>
          <thead>
            <tr><th scope="col">Gate</th><th scope="col">Best for</th><th scope="col">Space it needs</th><th scope="col">Plan before the build</th></tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Single walk gate<small>One leaf, hinged on one post</small></th>
              <td>People, pets, wheelbarrows and push mowers</td>
              <td>Level ground across the swing</td>
              <td>Which way it opens, which side the latch sits, and whether it needs to be wide enough for a riding mower</td>
            </tr>
            <tr>
              <th scope="row">Double drive gate<small>Two leaves that meet in the middle</small></th>
              <td>Trucks, trailers and boats into a backyard or pasture</td>
              <td>Room for both leaves to swing open</td>
              <td>A drop rod or stop to hold the resting leaf, and posts heavy enough for the extra weight</td>
            </tr>
            <tr>
              <th scope="row">Sliding gate<small>Rolls along the fence line</small></th>
              <td>Driveways that slope or sit close to the road</td>
              <td>A straight run of fence beside the opening</td>
              <td>Fairly even ground for the travel path and a clear spot for the gate to park when open<span class="fi-tag">Seen in a Google review</span></td>
            </tr>
            <tr>
              <th scope="row">Automatic gate<small>A swing or slide gate with an opener</small></th>
              <td>Entrances used many times a day, and long rural drives</td>
              <td>Same as the gate it drives, plus the opener</td>
              <td>A power source at the gate post and where the controls go, settled before the post is set<span class="fi-tag">Seen in Google reviews</span></td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="sp-sheet__foot">General planning guide. Gate widths, hardware and opener options are confirmed for your property at the estimate.</p>
    </div>

    <ul class="fi-ledger" aria-label="Gate jobs described in Google reviews">
      <li class="reveal-up reveal-delay-1"><?php echo icon('waypoints', 20); ?><span><strong>Sliding gate.</strong> A reviewer had more than 90 feet of fence and a sliding gate built and stained in a matter of days.</span></li>
      <li class="reveal-up reveal-delay-2"><?php echo icon('shield-check', 20); ?><span><strong>Automatic gate.</strong> Another installed about 500 feet of wrought iron with an automatic gate, then hired <?php echo h($siteName); ?> again for a second gate.</span></li>
      <li class="reveal-up reveal-delay-3"><?php echo icon('handshake', 20); ?><span><strong>A very large gate.</strong> One big gate-and-opener job took several visits, and the reviewer said every promise was kept to the end.</span></li>
    </ul>
  </div>
</section>

<!-- ============ 4. MATERIAL PICKER (contextual links to the four material pages) ============ -->
<section class="section fi-materials" aria-labelledby="materials-title">
  <div class="container">
    <div class="fi-materials__grid">
      <div class="sp-head reveal-left">
        <span class="eyebrow">Choose the fence</span>
        <h2 id="materials-title">Which fence material should a new installation use?</h2>
        <p class="answer-block">The material follows the fence's job. Wood privacy boards close a yard off, cedar adds a natural finish, chain link contains pets for the least money, and wrought iron or steel dresses up a front yard or pool. <?php echo h($siteName); ?> installs all four, each with its own page.</p>
        <p>Not sure yet? Read the <a class="sp-link" href="/services/">full list of fence services</a>, or bring the question to the estimate and decide on site.</p>
      </div>
      <ul class="fi-picks">
        <li class="reveal-up reveal-delay-1">
          <span class="fi-picks__icon"><?php echo icon('fence', 24); ?></span>
          <h3><?php echo serviceLink('privacy-fence', 'Privacy fence'); ?></h3>
          <p>Solid boards at full height when the goal is to stop people seeing in.</p>
        </li>
        <li class="reveal-up reveal-delay-2">
          <span class="fi-picks__icon"><?php echo icon('trees', 24); ?></span>
          <h3><?php echo serviceLink('cedar-fence', 'Cedar fence'); ?></h3>
          <p>Wood that resists rot on its own and takes stain well, at a higher price than pine.</p>
        </li>
        <li class="reveal-up reveal-delay-3">
          <span class="fi-picks__icon"><?php echo icon('link', 24); ?></span>
          <h3><?php echo serviceLink('chain-link', 'Chain link'); ?></h3>
          <p>The lowest cost per foot for containing dogs or marking a long line; it hides nothing.</p>
        </li>
        <li class="reveal-up reveal-delay-1">
          <span class="fi-picks__icon"><?php echo icon('shield-check', 24); ?></span>
          <h3><?php echo serviceLink('wrought-iron', 'Wrought iron'); ?></h3>
          <p>Open metal pickets for entries, pools and security; the most expensive of the four.</p>
        </li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ 5. SCOPE + PROCESS (paper-2; timeline left, included right) ============ -->
<section class="section sp-scope fi-scope" aria-labelledby="scope-title">
  <div class="container">
    <div class="sp-scope__grid">
      <div class="sp-scope__aside reveal-right">
        <span class="eyebrow">What you get</span>
        <h2 id="scope-title">What does a fence installation from <?php echo h($siteName); ?> include?</h2>
        <p class="answer-block">A fence installation from <?php echo h($siteName); ?> includes the on-site measure, a written quote, the layout, the posts, the fence itself and every gate on the run. Removing an old fence is added when needed, and the yard is cleaned up before the crew leaves.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span>Measurements and gate locations taken at the property</span></li>
          <li><?php echo icon('check', 18); ?><span>A written quote with materials and labor listed</span></li>
          <li><?php echo icon('check', 18); ?><span>Utility locate and a strung line before digging</span></li>
          <li><?php echo icon('check', 18); ?><span>Posts, fence and hardware in the material you chose</span></li>
          <li><?php echo icon('check', 18); ?><span>Walk, drive, sliding or automatic gates hung and adjusted</span></li>
          <li><?php echo icon('check', 18); ?><span>Old fence torn out and hauled off when it is in the way</span></li>
        </ul>
        <p class="footnote">An existing fence that only leans or sags may not need replacing; see <?php echo serviceLink('fence-repair', 'fence repair'); ?>.</p>
      </div>

      <div>
        <h3 class="sr-only">How a fence installation runs</h3>
        <ol class="sp-timeline">
          <li class="reveal-up">
            <b aria-hidden="true">01</b>
            <h3>Tell us about the property</h3>
            <p>Call <?php echo phoneLink(); ?> or send the form with the town, a rough length, the material you have in mind and how many gates you expect.</p>
          </li>
          <li class="reveal-up">
            <b aria-hidden="true">02</b>
            <h3>Measure at the property</h3>
            <p>The line is walked and measured, the gates are placed, and the ground is noted. One Google reviewer said the crew drove from Ennis to Waco to take measurements, and the quote came back in short order.</p>
          </li>
          <li class="reveal-up">
            <b aria-hidden="true">03</b>
            <h3>Approve the written quote</h3>
            <p>You get the price in writing. If you add upgrades afterward, the quote is revised before the work, not after.</p>
          </li>
          <li class="reveal-up">
            <b aria-hidden="true">04</b>
            <h3>Locate, lay out, set posts</h3>
            <p>Buried lines are marked, the line is strung tight from corner to corner, and the posts go in, with gate posts given the most care because they carry moving weight.</p>
          </li>
          <li class="reveal-up">
            <b aria-hidden="true">05</b>
            <h3>Build, hang gates, clean up</h3>
            <p>The fence goes up between the posts, gates are hung and adjusted to latch, and the site is cleared. Reviewers mention a clean job site at the end.</p>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<?php if ($fiReviews): ?>
<!-- ============ 6. PROOF: real Google reviews (live feed, filtered to gate / install jobs) ============ -->
<section class="section sp-proof fi-proof" aria-labelledby="proof-title">
  <div class="container">
    <div class="sp-head reveal-up">
      <span class="eyebrow">From Google reviews</span>
      <h2 id="proof-title">What do customers say about gate and fence installs from <?php echo h($siteName); ?>?</h2>
      <p class="answer-block">Customers on Google say their new fence and gate installs matched the quote and were finished as promised. Their jobs include sliding gates, large gates with openers and runs of several hundred feet. The reviews below are pulled live from the company's Google Business Profile, word for word.</p>
    </div>
    <div class="sp-quotes">
<?php foreach ($fiReviews['reviews'] as $fiRev): ?>
      <figure class="sp-quote reveal-up">
        <span class="review-stars" role="img" aria-label="<?php echo (int) $fiRev['rating']; ?> out of 5 stars"><?php echo str_repeat(icon('star', 16), (int) $fiRev['rating']); ?></span>
        <blockquote><p><?php echo nl2br(h($fiRev['text'])); ?></p></blockquote>
        <figcaption><b><?php echo h($fiRev['name']); ?></b><span>Google review · <?php echo h(p1_google_reviews_ago($fiRev['date'] ?? '')); ?></span></figcaption>
      </figure>
<?php endforeach; ?>
    </div>
    <div class="sp-proof__foot">
<?php if ($fiReviews['url'] !== ''): ?>
      <a href="<?php echo h($fiReviews['url']); ?>" target="_blank" rel="noopener nofollow">Read all <?php echo (int) $fiReviews['count']; ?> Google reviews ↗</a>
<?php endif; ?>
      <span>Had a fence installed by us? <a href="<?php echo h($gbp['review_url']); ?>" target="_blank" rel="noopener nofollow">Leave a Google review</a>.</span>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ 7. FAQ (research-brief questions, installation-specific answers) ============ -->
<section class="section sp-faq fi-faq" aria-labelledby="faq-title">
  <div class="container-narrow">
    <div class="sp-head reveal-down">
      <span class="eyebrow">Installation questions</span>
      <h2 id="faq-title">What do property owners ask before a new fence installation?</h2>
      <p class="answer-block">Property owners ask four things before a new fence installation. They want to know the cost, whether a permit or HOA sign-off is needed, how long the work takes and under what warranty, and who settles the property line. <?php echo h($siteName); ?> answers each one below.</p>
    </div>
    <div class="faq-grid">
<?php foreach ($fiFaqs as $fiIdx => $fiFaq): ?>
      <details class="faq"<?php echo $fiIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo h($fiFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo h($fiFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>

</article>

<!-- ============ RELATED SERVICES (required services component, 3 cards) ============ -->
<section class="section sp-related" aria-label="Related fence services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which <span class="text-accent">fence types</span> do new installations use most?</h2>
      <p class="hero-answer">Most new installations around Ennis and Waxahachie use one of three fence types. A wood privacy fence closes off the backyard, chain link holds pets and long property lines, and wrought iron suits front yards, pools and entry gates. <?php echo h($siteName); ?> plans and installs each one, gates included.</p>
      <span class="section-subtitle">Privacy · Chain link · Wrought iron</span>
    </div>
    <div class="services-grid">
<?php foreach ($fiRelated as $fiI => $fiSlug):
        $fiRel  = serviceBySlug($fiSlug);
        $fiCard = $fiCards[$fiSlug];
        $fiTint = ($fiI % 3) + 1; ?>
      <article class="service-card-with-image card-tint-<?php echo $fiTint; ?> reveal-up reveal-delay-<?php echo $fiTint; ?>">
        <div class="service-card__body">
          <div class="service-card__head">
            <div class="service-card__icon"><?php echo icon($fiCard['icon'], 24); ?></div>
            <h3><?php echo h($fiRel['name']); ?></h3>
          </div>
          <p class="service-card__desc"><?php echo h($fiCard['desc']); ?></p>
          <ul>
<?php foreach ($fiCard['bullets'] as $fiBullet): ?>
            <li><?php echo h($fiBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($fiSlug); ?>/" class="service-card__cta">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <a class="btn btn-secondary sp-hub-link" href="/services/">View All Services →</a>
  </div>
</section>

<!-- ============ 8. FINAL CTA (wave edge) ============ -->
<section class="cta-banner texture-grain edge-wave-top sp-cta fi-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-copy reveal-scale">
      <span class="eyebrow">New fence estimate</span>
      <h2 id="cta-title">Ready to plan a new fence and gates for your property?</h2>
      <p>Tell <?php echo h($siteName); ?> the town, the rough length and the gates you need, and the next step is a visit to measure the line.</p>
    </div>
    <div class="actions reveal-scale reveal-delay-2">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a Free Fence Installation Estimate</button>
      <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
