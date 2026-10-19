<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/wrought-iron/ — D & D Fence (Phase 4, 2026-10-19). Premium editorial service page (interactive-patterns §2.8).
 * No client photos on file: type hero with a spear-top picket motif; the signature visual is a pool-barrier spec drawing
 * (IRC Appendix G / ISPSC numbers, flagged "confirm with the city"). Proof comes live from the Google reviews feed
 * (serviceReviews), never hard-coded. Section order differs from the other service pages: uses → pool barrier →
 * material table → proof of work → scope/process → reviews → FAQ. Unconfirmed facts are in /content-confirmations.json.
 */
$svc            = serviceBySlug('wrought-iron');
$pageTitle      = 'Wrought Iron Fencing in Ennis & Waxahachie, TX | ' . $siteName;
$pageDescription = 'Wrought iron and ornamental steel fencing by D & D Fence for front yards, pools and secure perimeters in Ennis and Waxahachie, TX. Call (469) 321-7783.';
$canonicalUrl   = $siteUrl . '/services/wrought-iron/';
$ogImage        = defaultOgImage();
$currentPage    = 'services';
$pageType       = 'service';
$serviceSlug    = 'wrought-iron';

$wiFaqs = [
    ['q' => 'How much does a wrought iron fence cost in Ennis or Waxahachie?',
     'a' => 'An iron fence is priced by the linear foot, and the total moves with the height, the picket and top style, the number of gates, any gate opener and the ground along the run. D & D Fence measures on site and itemizes panels, posts, gates and labor in a written estimate. One Google reviewer compared it against three other bids on a steel fence and chose D & D Fence.'],
    ['q' => 'Does a wrought iron fence last longer than wood?',
     'a' => 'Coated metal generally outlasts wood with less upkeep, because it does not rot, warp or need restaining. The weak point is the finish: once paint or powder coat is scratched through, steel can rust from that spot. Touching up chips each spring and keeping sprinklers off the bottom rail keeps an iron fence looking right for years.'],
    ['q' => 'Do I need a permit or HOA approval for an iron or pool fence?',
     'a' => 'Usually. A fence that serves as a pool barrier is normally inspected against the city code, and many HOAs set rules for front-yard height, color and picket style. D & D Fence can check the requirements for your address before the order is placed, so the panels match what the city and the HOA will accept.'],
    ['q' => 'How long does it take to install a wrought iron fence?',
     'a' => 'Most residential iron fence runs go in within one to three days, depending on length, gates and ground. One Google reviewer with three young children had a pool fence and an iron fence along the deck finished in a day and a half.'],
];

$schemaMarkup = servicePageSchema(
    $svc,
    'Wrought Iron Fencing in Ennis & Waxahachie, TX',
    'Wrought iron and ornamental steel fence installation by D & D Fence for front yards, entries, pool barriers, decks and security perimeters in Ennis, Waxahachie and the surrounding Ellis County area, with matching gates.',
    generateFAQSchema($wiFaqs),
    ['serviceType' => 'Wrought iron fence installation']
);

$wiReviews = serviceReviews('iron|steel|pool', 3);
$wiCards   = serviceCards();
$wiRelated = ['fence-installation', 'chain-link', 'privacy-fence'];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?>

/* ==========================================================================
   Wrought iron — page-specific composition: spear-top picket hero motif, four-up use strip,
   pool-barrier spec drawing on a dark wave-edged band (signature), material table,
   dark proof-of-work band, scope on paper-2. Tokens only.
   ========================================================================== */
.wi-hero .sp-hero__motif { opacity: .08; width: min(60%, 780px); }
.wi-hero .hero-title { max-width: 19ch; }

/* ---------- Uses: four-up strip with numbered top rule ---------- */
.wi-uses { background: var(--color-paper); }
.wi-uses .sp-head { max-width: 64ch; }
.wi-uses__grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-5); margin: 0; padding: 0; list-style: none; counter-reset: wi-use; }
.wi-uses__grid > li {
  counter-increment: wi-use;
  position: relative;
  display: grid;
  gap: var(--space-3);
  align-content: start;
  padding: var(--space-8) var(--space-5) var(--space-6);
  background: var(--color-surface);
  border: 1px solid var(--color-line);
  border-top: 4px solid var(--color-primary);
  border-radius: 0 0 var(--radius-lg) var(--radius-lg);
  box-shadow: var(--shadow-sm);
  transition: transform var(--transition-slow), box-shadow var(--transition-slow), border-color var(--transition);
}
.wi-uses__grid > li:nth-child(even) { margin-top: var(--space-8); border-top-color: var(--color-accent); }
.wi-uses__grid > li:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
.wi-uses__grid > li::before {
  content: counter(wi-use, decimal-leading-zero);
  position: absolute;
  top: var(--space-3);
  right: var(--space-4);
  font-family: var(--font-accent);
  font-weight: 700;
  font-size: 1.6rem;
  line-height: 1;
  color: var(--color-line);
}
.wi-uses__grid > li > svg { color: var(--color-accent-dark); }
.wi-uses__grid h3 { font-size: 1.08rem; }
.wi-uses__grid p { margin: 0; font-size: .94rem; color: var(--color-ink-2); }
.wi-uses__grid a { color: var(--color-primary); font-weight: 600; }
@media (max-width: 1000px) {
  .wi-uses__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .wi-uses__grid > li:nth-child(even) { margin-top: 0; }
}
@media (max-width: 600px) { .wi-uses__grid { grid-template-columns: 1fr; } }

/* ---------- Signature: pool barrier spec (dark band, wave edge) ---------- */
.wi-pool .wi-pool__grid { display: grid; grid-template-columns: minmax(0, .95fr) minmax(0, 1.25fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.wi-pool .wi-pool__intro { display: grid; gap: var(--space-4); position: sticky; top: calc(var(--nav-height) + var(--space-6)); }
.wi-pool .answer-block {
  margin: 0;
  background: color-mix(in srgb, var(--color-white) 6%, transparent);
  border-left-color: var(--color-accent-bright);
  color: color-mix(in srgb, var(--color-white) 90%, transparent);
}
.wi-pool .wi-pool__intro > p:not(.answer-block) { margin: 0; color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.wi-pool .floating-ring { right: -120px; top: 20%; }
.wi-spec {
  position: relative;
  margin: 0;
  background: var(--color-surface);
  color: var(--color-ink);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg);
  overflow: hidden;
}
.wi-spec__head { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: baseline; gap: var(--space-2) var(--space-4); padding: var(--space-5) var(--space-6) var(--space-4); background: var(--color-paper); border-bottom: 2px dashed var(--color-line); }
.wi-spec__head span { font-family: var(--font-accent); font-weight: 700; font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.wi-spec__head b { font-family: var(--font-heading); font-size: 1.1rem; }
.wi-spec__drawing { padding: var(--space-5) var(--space-5) 0; background-image: linear-gradient(var(--color-line) 1px, transparent 1px), linear-gradient(90deg, var(--color-line) 1px, transparent 1px); background-size: 24px 24px; background-position: -1px -1px; }
.wi-spec__drawing svg { width: 100%; height: auto; display: block; }
.wi-spec .bd-ground { stroke: var(--color-ink); stroke-width: 2; }
.wi-spec .bd-post { fill: var(--color-primary); }
.wi-spec .bd-rail { fill: var(--color-primary); }
.wi-spec .bd-picket { stroke: var(--color-primary); stroke-width: 3; }
.wi-spec .bd-spear { fill: var(--color-primary); }
.wi-spec .bd-gate { stroke: var(--color-accent-dark); stroke-width: 3; }
.wi-spec .bd-gate-frame { fill: none; stroke: var(--color-accent-dark); stroke-width: 3; }
.wi-spec .bd-latch { fill: var(--color-accent); }
.wi-spec .bd-dim { stroke: var(--color-accent-dark); stroke-width: 1.5; fill: none; }
.wi-spec .bd-ball { fill: color-mix(in srgb, var(--color-accent) 35%, transparent); stroke: var(--color-accent-dark); stroke-width: 1.5; }
.wi-spec .bd-label { font-family: var(--font-accent); font-weight: 700; font-size: 13px; letter-spacing: .1em; fill: var(--color-ink); }
.wi-spec .bd-label--accent { fill: var(--color-accent-dark); }
.wi-spec__rules { display: grid; gap: 0; margin: 0; padding: var(--space-2) var(--space-6) var(--space-4); }
.wi-spec__rules > div { display: grid; grid-template-columns: minmax(7.5rem, auto) 1fr; gap: var(--space-4); padding: var(--space-3) 0; border-bottom: 1px solid var(--color-line); }
.wi-spec__rules > div:last-child { border-bottom: 0; }
.wi-spec__rules dt { font-family: var(--font-accent); font-weight: 700; font-size: 1.05rem; letter-spacing: .04em; text-transform: uppercase; color: var(--color-accent-dark); }
.wi-spec__rules dd { margin: 0; font-size: .93rem; color: var(--color-ink-2); }
.wi-spec__foot { margin: 0; padding: var(--space-4) var(--space-6); font-size: var(--fs-small); color: var(--color-muted); background: var(--color-paper); border-top: 1px solid var(--color-line); }
@media (max-width: 960px) {
  .wi-pool .wi-pool__grid { grid-template-columns: 1fr; }
  .wi-pool .wi-pool__intro { position: static; }
}
@media (max-width: 520px) { .wi-spec__rules > div { grid-template-columns: 1fr; gap: var(--space-1); } }

/* ---------- Material table on paper ---------- */
.wi-compare { background: var(--color-paper); }
.wi-compare .sp-head { max-width: 66ch; }
.wi-compare .sp-sheet { border-top: 5px solid var(--color-primary); }
.wi-compare .wi-compare__note { max-width: 62ch; margin: var(--space-8) 0 0; color: var(--color-ink-2); }
.wi-compare .wi-compare__note + .wi-compare__note { margin-top: var(--space-4); }
.wi-tag { display: inline-block; margin-top: var(--space-2); padding: var(--space-1) var(--space-2); font-family: var(--font-accent); font-weight: 700; font-size: var(--font-size-xs); letter-spacing: .1em; text-transform: uppercase; border-radius: var(--radius-sm); background: var(--color-card-tint-3); color: var(--color-accent-dark); }

/* ---------- Proof of work (dark expert band): figure left, copy right ---------- */
.wi-expert .sp-expert__grid { grid-template-columns: minmax(0, 1fr) minmax(0, 1.45fr); }
.wi-expert .sp-figure { border-color: color-mix(in srgb, var(--color-accent) 45%, transparent); }
.wi-expert .sp-figure b { font-size: clamp(3.2rem, 1.8rem + 5.5vw, 6rem); }
.wi-expert .floating-ring { left: -130px; bottom: -150px; }
@media (max-width: 900px) { .wi-expert .sp-expert__grid > :first-child { order: 2; } }

/* ---------- Scope on paper-2 ---------- */
.wi-scope { background: var(--color-paper-2); }
.wi-scope .sp-included { background: var(--color-surface); border-style: solid; }
.wi-scope .sp-timeline > li::before { content: ""; width: 30px; height: 30px; left: calc(-1 * var(--space-12) + 5px); top: 5px; border-radius: var(--radius-sm); transform: rotate(45deg); }
.wi-scope .sp-timeline > li > .wi-num { position: absolute; left: calc(-1 * var(--space-12)); top: 0; width: 40px; height: 40px; display: grid; place-items: center; font-family: var(--font-accent); font-weight: 700; font-size: 1.05rem; color: var(--color-accent-dark); pointer-events: none; transition: color var(--transition); }
.wi-scope .sp-timeline > li:hover > .wi-num { color: var(--color-white); }

/* ---------- Reviews, FAQ, related ---------- */
.wi-proof { background: var(--color-paper); }
.wi-proof .sp-quote { border-top: 4px solid var(--color-accent); }
.wi-related { background: var(--color-paper); }
.wi-cta .floating-ring { opacity: .08; }

@media (prefers-reduced-motion: reduce) {
  .wi-uses__grid > li, .wi-scope .sp-timeline > li > .wi-num { transition: none; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ 1. HERO (type hero, spear-top picket motif; no client photo on file yet) ============ -->
<section class="hero hero--interior sp-hero wi-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="sp-hero__motif" aria-hidden="true">
    <svg viewBox="0 0 720 420" preserveAspectRatio="xMaxYMax slice" focusable="false">
      <defs>
        <pattern id="wi-pickets" width="30" height="420" patternUnits="userSpaceOnUse">
          <path d="M15 40 l7 18 h-4 V420 h-6 V58 h-4 Z" fill="currentColor"/>
        </pattern>
      </defs>
      <rect x="0" y="0" width="720" height="420" fill="url(#wi-pickets)"/>
      <rect x="0" y="92" width="720" height="8" fill="currentColor"/>
      <rect x="0" y="380" width="720" height="8" fill="currentColor"/>
<?php for ($wiRx = 15; $wiRx < 720; $wiRx += 60): ?>
      <circle cx="<?php echo $wiRx + 15; ?>" cy="118" r="9" fill="none" stroke="currentColor" stroke-width="3"/>
<?php endfor; ?>
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
            <li><span aria-current="page">Wrought Iron</span></li>
          </ol>
        </nav>
        <span class="eyebrow">Iron &amp; ornamental steel · Ellis County, TX</span>
        <h1 class="hero-title" id="hero-title">Wrought Iron Fencing in <span class="text-accent">Ennis &amp; Waxahachie</span>, TX</h1>
        <p class="hero-answer"><?php echo h($siteName); ?> installs wrought iron and ornamental steel fencing in Ennis, Waxahachie and the towns within about <?php echo (int) $serviceRadiusMiles; ?> miles, from decorative front-yard runs to pool barriers and secure perimeters with matching gates. Open pickets mark the line and keep people and pets where they belong without hiding the house or the view.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
          <li><?php echo icon('waves', 16); ?>Pool barriers &amp; entry gates</li>
          <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Want a free wrought iron estimate?</h2>
        <p class="hero-form-tagline">No obligation. <b>Ennis, Waxahachie &amp; nearby.</b></p>
        <form action="<?php echo h($formAction); ?>" method="POST" class="hero-form">
          <input type="hidden" name="_next" value="<?php echo h($siteUrl); ?>/thank-you">
          <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">
          <input type="hidden" name="form_location" value="hero">
          <input type="hidden" name="consent_version" value="v2.1">
          <input type="hidden" name="consent_page" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
          <input type="hidden" name="_consent_version" value="v2.1">
          <input type="hidden" name="_consent_page" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
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

<!-- ============ 2. WHERE IT FITS (four-up use strip) ============ -->
<section class="section wi-uses" aria-labelledby="uses-title">
  <div class="container-wide">
    <div class="sp-head reveal-up">
      <span class="eyebrow">Where iron works</span>
      <h2 id="uses-title">Where does a <span class="text-accent">wrought iron fence</span> make sense on an Ennis or Waxahachie property?</h2>
      <p class="answer-block">A wrought iron fence makes sense wherever you need a firm boundary but want to keep the view: front yards, entry drives, pool enclosures, raised decks and security perimeters. The open pickets stop people and pets while leaving the house, the yard and the landscaping in plain sight.</p>
    </div>
    <ul class="wi-uses__grid">
      <li class="reveal-up reveal-delay-1">
        <?php echo icon('home', 26); ?>
        <h3>Front yards and entries</h3>
        <p>A short iron run along the front walk defines the yard without walling off the house. If your home sits in one of Waxahachie's historic districts, check with the city's planning department before settling on a front-yard style.</p>
      </li>
      <li class="reveal-up reveal-delay-2">
        <?php echo icon('waves', 26); ?>
        <h3>Pool enclosures</h3>
        <p>Open pickets let you watch the water from the patio while the fence does its job as a barrier. A reviewer with three young children had one built around the family pool.</p>
      </li>
      <li class="reveal-up reveal-delay-3">
        <?php echo icon('layers', 26); ?>
        <h3>Decks and drop-offs</h3>
        <p>A low iron fence along a raised deck edge keeps guests from stepping off the high side. The same reviewer had iron added on the deck so nobody could fall to the porch below.</p>
      </li>
      <li class="reveal-up reveal-delay-1">
        <?php echo icon('shield-check', 26); ?>
        <h3>Security perimeters</h3>
        <p>Tall steel pickets and a drive gate close off an acreage entrance, a shop yard or a long frontage. Swing, sliding and automatic gates are covered under <?php echo serviceLink('fence-installation', 'fence and gate installation'); ?>.</p>
      </li>
    </ul>
  </div>
</section>

<!-- ============ 3. SIGNATURE: POOL BARRIER SPEC (dark, wave edge) ============ -->
<section class="section wi-pool texture-grain edge-wave-top" aria-labelledby="pool-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container-wide">
    <div class="wi-pool__grid">
      <div class="wi-pool__intro reveal-left">
        <span class="eyebrow">Pool fence installation</span>
        <h2 id="pool-title">What does a pool fence need to pass inspection in Ennis or Waxahachie?</h2>
        <p class="answer-block">A pool fence typically needs to stand at least 48 inches tall, with gaps a 4-inch ball cannot pass and gates that close and latch themselves. Those numbers come from the International Residential Code pool barrier rules that many Texas cities adopt, sometimes with local changes.</p>
        <p>Ennis and Waxahachie building inspections have the final word on your address, so the barrier rules are confirmed before the panels are ordered. Iron is a natural fit for the job: the pickets read as a fence rather than a wall, and you can see a child in the water from the kitchen window.</p>
        <p>One detail catches iron fences in particular. When the horizontal rails sit closer together than 45 inches, a small child can use them as a ladder, so the code calls for the rails on the pool side and much tighter picket spacing. Panel choice matters as much as height.</p>
      </div>

      <figure class="wi-spec reveal-right">
        <div class="wi-spec__head"><span>Barrier spec</span><b>The numbers a pool fence is checked against</b></div>
        <div class="wi-spec__drawing">
          <svg viewBox="0 0 480 340" role="img" aria-labelledby="barrier-title" focusable="false">
            <title id="barrier-title">Elevation drawing of an iron pool fence and gate: fence at least 48 inches tall, picket gaps too narrow for a 4-inch ball, no more than 2 inches between the bottom and the ground, and a self-closing, self-latching gate with the latch release at least 54 inches above the ground</title>
            <line class="bd-ground" x1="10" y1="300" x2="470" y2="300"/>
            <!-- fence panel: posts, rails, spear-top pickets (4 px = 1 in) -->
            <rect class="bd-post" x="56" y="82" width="9" height="218" rx="1"/>
            <rect class="bd-post" x="286" y="82" width="9" height="218" rx="1"/>
            <rect class="bd-rail" x="56" y="106" width="239" height="5"/>
            <rect class="bd-rail" x="56" y="284" width="239" height="5"/>
<?php for ($wiPx = 76; $wiPx <= 278; $wiPx += 14): ?>
            <line class="bd-picket" x1="<?php echo $wiPx; ?>" y1="98" x2="<?php echo $wiPx; ?>" y2="292"/>
            <path class="bd-spear" d="M<?php echo $wiPx - 4; ?> 99 L<?php echo $wiPx; ?> 88 L<?php echo $wiPx + 4; ?> 99 Z"/>
<?php endfor; ?>
            <!-- gate with tall latch post -->
            <rect class="bd-gate-frame" x="302" y="98" width="88" height="194" rx="1"/>
<?php for ($wiGx = 316; $wiGx <= 378; $wiGx += 14): ?>
            <line class="bd-gate" x1="<?php echo $wiGx; ?>" y1="98" x2="<?php echo $wiGx; ?>" y2="292"/>
<?php endfor; ?>
            <rect class="bd-post" x="394" y="58" width="9" height="242" rx="1"/>
            <rect class="bd-latch" x="388" y="80" width="20" height="12" rx="2"/>
            <!-- height dimension -->
            <path class="bd-dim" d="M32 300 V100 M26 300 H38 M26 100 H38"/>
            <text class="bd-label bd-label--accent" x="22" y="200" transform="rotate(-90 22 200)" text-anchor="middle">≥ 48 IN</text>
            <!-- 4 in ball against the pickets -->
            <circle class="bd-ball" cx="153" cy="200" r="8"/>
            <path class="bd-dim" d="M153 191 V58 H166"/>
            <text class="bd-label" x="170" y="62">4 IN BALL CAN'T PASS</text>
            <!-- bottom clearance -->
            <path class="bd-dim" d="M120 292 V300 M120 296 H150 V318"/>
            <text class="bd-label" x="156" y="322">≤ 2 IN TO GROUND</text>
            <!-- latch -->
            <path class="bd-dim" d="M408 86 H428 V40"/>
            <text class="bd-label bd-label--accent" x="470" y="32" text-anchor="end">LATCH ≥ 54 IN</text>
            <text class="bd-label" x="346" y="322" text-anchor="middle">SELF-CLOSING GATE</text>
          </svg>
        </div>
        <dl class="wi-spec__rules">
          <div><dt>Height</dt><dd>At least 48 inches, measured on the side away from the pool.</dd></div>
          <div><dt>Openings</dt><dd>No gap a 4-inch ball can pass through. Where rails sit less than 45 inches apart, pickets close up to about 1¾ inches with the rails on the pool side.</dd></div>
          <div><dt>Bottom gap</dt><dd>No more than 2 inches between the ground and the bottom of the fence.</dd></div>
          <div><dt>Gates</dt><dd>Self-closing and self-latching, swinging outward, away from the pool.</dd></div>
          <div><dt>Latch</dt><dd>Release at least 54 inches off the ground, or mounted on the pool side near the top of the gate.</dd></div>
        </dl>
        <figcaption class="wi-spec__foot">Summary of the International Residential Code (Appendix G) and ISPSC barrier rules. Cities adopt and amend codes: confirm the current requirements with Ennis or Waxahachie building inspections before a pool fence is built.</figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ============ 4. MATERIAL TABLE: iron vs steel vs aluminum ============ -->
<section class="section wi-compare" aria-labelledby="compare-title">
  <div class="container">
    <div class="sp-head reveal-up">
      <span class="eyebrow">What you are actually buying</span>
      <h2 id="compare-title">Is a "wrought iron" fence really iron, or is it steel or aluminum?</h2>
      <p class="answer-block">Most fences sold as wrought iron today are ornamental steel: welded tubular pickets and rails with a painted or powder-coated finish. True hand-worked wrought iron is rare and mostly used in restoration. Aluminum looks similar and never rusts, but it is lighter and dents more easily.</p>
    </div>
    <div class="sp-sheet reveal-up">
      <div class="sp-sheet__head"><span>Material guide</span><b>Three metals sold under one name</b></div>
      <div class="table-scroll" role="region" aria-label="Wrought iron, ornamental steel and aluminum fence comparison" tabindex="0">
        <table class="sp-table">
          <caption class="sr-only">Comparison of true wrought iron, ornamental steel and aluminum fencing by construction, strength, rust and upkeep</caption>
          <thead>
            <tr><th scope="col">Material</th><th scope="col">How it is made</th><th scope="col">Strength</th><th scope="col">Rust</th><th scope="col">Upkeep</th></tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">True wrought iron<small>Hand-worked iron bar</small></th>
              <td>Heated and hammered or bent by a smith; made to order</td>
              <td>Very heavy and rigid</td>
              <td>Rusts wherever the paint fails</td>
              <td>Scrape and repaint as the finish wears</td>
            </tr>
            <tr>
              <th scope="row">Ornamental steel<small>Tubular pickets and rails</small><span class="wi-tag">Most "wrought iron" today</span></th>
              <td>Welded panels, painted or powder-coated, often over a galvanized base</td>
              <td>Strong; holds up to bumps and leaning</td>
              <td>Starts at scratches and welds once the coating is broken</td>
              <td>Touch up chips before rust spreads</td>
            </tr>
            <tr>
              <th scope="row">Aluminum<small>Extruded pickets and rails</small></th>
              <td>Powder-coated sections, bolted or welded</td>
              <td>Lightest; dents and bends more easily</td>
              <td>Does not rust</td>
              <td>Very little beyond washing</td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="sp-sheet__foot">General comparison of the three metals. Ask which material, picket gauge and finish your estimate is based on.</p>
    </div>
    <p class="wi-compare__note">For most yards around Ennis and Waxahachie the practical question is the finish, not the name. North Texas summers bake the coating, lawn sprinklers keep the bottom rail wet, and a mower blade can nick a picket. A steel fence with an intact coating looks the same year after year; one with an open chip starts to bleed rust down the picket.</p>
    <p class="wi-compare__note">If you need full privacy instead of an open view, a <?php echo serviceLink('privacy-fence', 'board privacy fence'); ?> suits the backyard better, and <?php echo serviceLink('chain-link', 'chain link'); ?> covers long, low-cost perimeters where looks matter less.</p>
  </div>
</section>

<!-- ============ 5. PROOF OF WORK (dark, slanted) ============ -->
<section class="section sp-expert wi-expert texture-grain slant-top" aria-labelledby="expert-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container">
    <div class="sp-expert__grid">
      <div class="reveal-left">
        <div class="sp-figure">
          <b>≈500<span> ft</span></b>
          <span>of wrought iron fencing with an automatic gate on one Google reviewer's property, who hired <?php echo h($siteName); ?> again the next year for another gate</span>
        </div>
      </div>
      <div class="reveal-right">
        <span class="eyebrow">Iron and steel jobs on record</span>
        <h2 id="expert-title">Why do Ellis County owners hire <?php echo h($siteName); ?> for iron and steel fencing?</h2>
        <p class="answer-block">Owners hire <?php echo h($siteName); ?> for iron and steel fencing because its reviews show long runs, multiple gates and pool work finished cleanly at a fair price. At least one of those customers came back a year later for another gate.</p>
        <ul class="sp-points">
          <li><?php echo icon('clipboard-list', 22); ?><span><strong>Priced against other bids.</strong> A project manager who quoted three other companies chose <?php echo h($siteName); ?> for a steel fence with three gates and roughly 250 linear feet.</span></li>
          <li><?php echo icon('waves', 22); ?><span><strong>Pool and deck work for a young family.</strong> A parent of three young children had a pool fence and an iron deck fence finished in a day and a half.</span></li>
          <li><?php echo icon('route', 22); ?><span><strong>Long runs with powered gates.</strong> The 500-foot job above ended at an automatic gate, which is where heavy iron gates earn an opener.</span></li>
          <li><?php echo icon('check', 22); ?><span><strong>A clean site at the end.</strong> The same project manager listed a clean job site among the reasons to recommend the crew.</span></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ 6. SCOPE + PROCESS ============ -->
<section class="section sp-scope wi-scope" aria-labelledby="scope-title">
  <div class="container">
    <div class="sp-scope__grid">
      <div class="sp-scope__aside reveal-left">
        <span class="eyebrow">From measure to latch</span>
        <h2 id="scope-title">What does a wrought iron fence job from <?php echo h($siteName); ?> include?</h2>
        <p class="answer-block">A wrought iron job covers measuring the run, choosing the height and picket style, setting posts, mounting panels and hanging the gates, plus removing an old fence if needed. The estimate spells out panels, posts, gates and labor so the price is clear before anything is ordered.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span>The run measured and every gate opening marked</span></li>
          <li><?php echo icon('check', 18); ?><span>Height, picket spacing and top style chosen with you</span></li>
          <li><?php echo icon('check', 18); ?><span>Posts set plumb at the exact panel spacing</span></li>
          <li><?php echo icon('check', 18); ?><span>Panels stepped or sloped to follow the ground</span></li>
          <li><?php echo icon('check', 18); ?><span>Walk and drive gates hung, with pool-gate hardware where required</span></li>
          <li><?php echo icon('check', 18); ?><span>Old fence taken out when the iron replaces it</span></li>
        </ul>
        <p class="footnote">Comparing every fence type first? Start with <a class="sp-link" href="/services/">all six fence services</a>.</p>
      </div>

      <div>
        <h3 class="sr-only">How a wrought iron fence job runs</h3>
        <ol class="sp-timeline">
          <li class="reveal-up">
            <span class="wi-num" aria-hidden="true">01</span>
            <h3>Measure the run and the gates</h3>
            <p><?php echo h($siteName); ?> measures the full line, marks each walk and drive gate, and notes slopes, trees and the corners of the house. Iron comes in fixed panel widths, so the measurements decide how the panels lay out.</p>
          </li>
          <li class="reveal-up">
            <span class="wi-num" aria-hidden="true">02</span>
            <h3>Pick the style and check the rules</h3>
            <p>You choose height, picket top and color. If the fence encloses a pool or faces the street, the city barrier rules and any HOA standards are checked against that choice before panels are ordered.</p>
          </li>
          <li class="reveal-up">
            <span class="wi-num" aria-hidden="true">03</span>
            <h3>Locate utilities, set the posts</h3>
            <p>Buried lines are marked before digging. Posts go in plumb at the exact panel spacing, since a welded panel cannot stretch to cover a post that drifted an inch.</p>
          </li>
          <li class="reveal-up">
            <span class="wi-num" aria-hidden="true">04</span>
            <h3>Hang panels, gates and hardware</h3>
            <p>Panels are mounted and stepped or sloped with the grade, gates are hung and adjusted until they swing and latch cleanly, and the site is cleared.</p>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<?php if ($wiReviews): ?>
<!-- ============ 7. REVIEWS (live feed, filtered to iron / steel / pool jobs) ============ -->
<section class="section sp-proof wi-proof" aria-labelledby="proof-title">
  <div class="container">
    <div class="sp-head sp-head--center reveal-up">
      <span class="eyebrow">From Google reviews</span>
      <h2 id="proof-title">What do iron, steel and pool fence customers say about <?php echo h($siteName); ?>?</h2>
      <p class="answer-block">Customers who had iron, steel and pool fences built describe long runs finished well, gates that work, and pricing that beat other bids. The reviews below are pulled from the <?php echo h($siteName); ?> Google Business Profile and printed exactly as each customer wrote them.</p>
    </div>
    <div class="sp-quotes">
<?php foreach ($wiReviews['reviews'] as $wiRev): ?>
      <figure class="sp-quote reveal-up">
        <span class="review-stars" role="img" aria-label="<?php echo (int) $wiRev['rating']; ?> out of 5 stars"><?php echo str_repeat(icon('star', 16), (int) $wiRev['rating']); ?></span>
        <blockquote><p><?php echo nl2br(h($wiRev['text'])); ?></p></blockquote>
        <figcaption><b><?php echo h($wiRev['name']); ?></b><span>Google review · <?php echo h(p1_google_reviews_ago($wiRev['date'] ?? '')); ?></span></figcaption>
      </figure>
<?php endforeach; ?>
    </div>
    <div class="sp-proof__foot">
<?php if ($wiReviews['url'] !== ''): ?>
      <a href="<?php echo h($wiReviews['url']); ?>" target="_blank" rel="noopener nofollow">Read all <?php echo (int) $wiReviews['count']; ?> Google reviews ↗</a>
<?php endif; ?>
      <span>Had an iron fence built by us? <a href="<?php echo h($gbp['review_url']); ?>" target="_blank" rel="noopener nofollow">Leave a Google review</a>.</span>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ 8. FAQ (research-brief questions, iron-specific answers) ============ -->
<section class="section sp-faq" aria-labelledby="faq-title">
  <div class="container-narrow">
    <div class="sp-head reveal-down">
      <span class="eyebrow">Wrought iron questions</span>
      <h2 id="faq-title">What do property owners ask before installing wrought iron fencing?</h2>
      <p class="answer-block">Property owners weighing wrought iron fencing ask about price, how long metal lasts compared with wood, permits for pool and front-yard fences, and how quickly it goes in. <?php echo h($siteName); ?> answers each below; call <?php echo phoneLink(); ?> about your own property.</p>
    </div>
    <div class="faq-grid">
<?php foreach ($wiFaqs as $wiIdx => $wiFaq): ?>
      <details class="faq"<?php echo $wiIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo h($wiFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo h($wiFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>

</article>

<!-- ============ RELATED SERVICES (required services component, 3 cards) ============ -->
<section class="section sp-related wi-related" aria-label="Related fence services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which other <span class="text-accent">fence services</span> pair with wrought iron?</h2>
      <p class="hero-answer">Iron fencing often leads to a second job on the same property. That might be a new gate or a longer run, chain link along a back pasture or side yard, or a board privacy fence behind the house. <?php echo h($siteName); ?> builds each of them for owners in Ennis, Waxahachie and the surrounding towns.</p>
      <span class="section-subtitle">Gates &amp; new runs · Chain link · Privacy</span>
    </div>
    <div class="services-grid">
<?php foreach ($wiRelated as $wiI => $wiSlug):
        $wiRel  = serviceBySlug($wiSlug);
        $wiCard = $wiCards[$wiSlug];
        $wiTint = ($wiI % 3) + 1; ?>
      <article class="service-card-with-image card-tint-<?php echo $wiTint; ?> reveal-up reveal-delay-<?php echo $wiTint; ?>">
        <div class="service-card__body">
          <div class="service-card__head">
            <div class="service-card__icon"><?php echo icon($wiCard['icon'], 24); ?></div>
            <h3><?php echo h($wiRel['name']); ?></h3>
          </div>
          <p class="service-card__desc"><?php echo h($wiCard['desc']); ?></p>
          <ul>
<?php foreach ($wiCard['bullets'] as $wiBullet): ?>
            <li><?php echo h($wiBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($wiSlug); ?>/" class="service-card__cta">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <a class="btn btn-secondary sp-hub-link" href="/services/">View All Services →</a>
  </div>
</section>

<!-- ============ 9. FINAL CTA (torn edge) ============ -->
<section class="cta-banner texture-grain edge-torn-top sp-cta wi-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-copy reveal-scale">
      <span class="eyebrow">Iron &amp; pool fence estimate</span>
      <h2 id="cta-title">Ready to price an iron or pool fence?</h2>
      <p>Tell <?php echo h($siteName); ?> the rough length, how many gates you need and whether the fence surrounds a pool, and a time will be set to measure the run.</p>
    </div>
    <div class="actions reveal-scale reveal-delay-2">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a Free Wrought Iron Estimate</button>
      <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
