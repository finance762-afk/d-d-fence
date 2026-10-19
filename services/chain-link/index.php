<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/chain-link/ — D & D Fence (Phase 4, 2026-10-19). Premium editorial service page (interactive-patterns §2.8).
 * No client photos on file: type hero with a diamond-mesh motif; the signature visual is a labeled chain link anatomy drawing.
 * Section order differs from the other service pages: anatomy (signature) → uses → finishes & gauge (dark) → scope/process
 * → proof → FAQ → related → CTA. No chain-link-specific Google reviews exist, so the proof block shows reviews from
 * customers who fenced for dogs (live feed via serviceReviews) and never claims those fences were chain link.
 * Coatings, gauges and heights D & D Fence stocks are unconfirmed — the page explains them as general facts only.
 */
$svc            = serviceBySlug('chain-link');
$pageTitle      = 'Chain Link Fence Installation in Ennis & Waxahachie, TX | ' . $siteName;
$pageDescription = 'Chain link fencing from D & D Fence for backyards, dog runs, side yards and property perimeters in Ennis, Waxahachie and Ellis County. Call (469) 321-7783.';
$canonicalUrl   = $siteUrl . '/services/chain-link/';
$ogImage        = defaultOgImage();
$currentPage    = 'services';
$pageType       = 'service';
$serviceSlug    = 'chain-link';

$clFaqs = [
    ['q' => 'How much does a chain link fence cost in Ennis or Waxahachie?',
     'a' => 'Chain link is priced by the linear foot and is usually the least expensive fence per foot to put in. The total moves with the height, the wire gauge, a galvanized or vinyl-coated finish, how many gates and corner posts the run needs, and the ground. D & D Fence measures the run and itemizes materials and labor in a written estimate.'],
    ['q' => 'Do I need a permit or HOA approval for a chain link fence?',
     'a' => 'Possibly for both. Cities can require a permit and cap fence height, and some HOAs restrict chain link or ban it anywhere it faces the street. D & D Fence can look up the rules for your address before you settle on chain link, so the fence type is approved before any post goes in.'],
    ['q' => 'Does chain link last longer than a wood fence?',
     'a' => 'Usually, yes. Galvanized steel does not rot, warp or need stain, so chain link typically outlasts a wood fence with far less upkeep. When a chain link fence does need attention, it is most often a post pushed out of line or fabric bent by a fallen limb, and both can be fixed without replacing the run.'],
    ['q' => 'How long does chain link installation take?',
     'a' => 'A typical backyard chain link job is finished in one to three days. Long perimeters, extra gates and wet weather stretch that, because every end, corner and gate opening needs its own heavy terminal post set before the fabric can be stretched.'],
];

$schemaMarkup = servicePageSchema(
    $svc,
    'Chain Link Fence Installation in Ennis & Waxahachie, TX',
    'Chain link fence installation by D & D Fence for backyards, dog runs, side yards and property perimeters in Ennis, Waxahachie and the surrounding Ellis County area: layout, terminal and line posts, top rail, fabric, tension wire, gates and old fence removal.',
    generateFAQSchema($clFaqs),
    ['serviceType' => 'Chain link fence installation']
);

$clReviews = serviceReviews('canine|pupp|our dogs', 3);
$clCards   = serviceCards();
$clRelated = ['fence-installation', 'wrought-iron', 'fence-repair'];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?>

/* ==========================================================================
   Chain link — page-specific composition: diamond-mesh hero motif, labeled anatomy drawing (signature),
   dark finishes-and-gauge band with two spec sheets, light evidence list in the scope. Tokens only.
   ========================================================================== */
.cl-hero .sp-hero__motif { opacity: .08; width: min(60%, 820px); }
.cl-hero h1, .cl-related h2, .cl-cta h2 { text-wrap: balance; }

/* ---------- Signature: anatomy drawing (white band, figure left) ---------- */
.cl-anatomy { background: var(--color-surface); }
.cl-anatomy__grid { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(0, 1fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: center; }
.cl-anatomy__copy { display: grid; gap: var(--space-4); }
.cl-anatomy__copy .answer-block { margin: 0; }
.cl-drawing {
  position: relative;
  margin: 0;
  padding: var(--space-6) var(--space-6) var(--space-5);
  background:
    linear-gradient(var(--color-line) 1px, transparent 1px) 0 0 / 24px 24px,
    linear-gradient(90deg, var(--color-line) 1px, transparent 1px) 0 0 / 24px 24px,
    var(--color-paper);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg);
}
.cl-drawing::before {
  content: "Section · not to scale";
  position: absolute;
  top: var(--space-3);
  right: var(--space-4);
  font-family: var(--font-accent);
  font-weight: 700;
  font-size: var(--fs-eyebrow);
  letter-spacing: .14em;
  text-transform: uppercase;
  color: var(--color-muted);
}
.cl-drawing svg { width: 100%; height: auto; display: block; }
.cl-drawing figcaption { margin-top: var(--space-4); padding-top: var(--space-4); border-top: 2px dashed var(--color-line); font-size: .9rem; line-height: 1.55; color: var(--color-ink-2); }
.cl-drawing .an-clay { fill: var(--color-card-tint-3); }
.cl-drawing .an-grade { stroke: var(--color-ink); stroke-width: 2; }
.cl-drawing .an-post { fill: var(--color-secondary); }
.cl-drawing .an-post--terminal { fill: var(--color-primary); }
.cl-drawing .an-footing { fill: none; stroke: var(--color-accent-dark); stroke-width: 1.5; stroke-dasharray: 5 4; }
.cl-drawing .an-rail { fill: var(--color-primary); }
.cl-drawing .an-mesh { stroke: var(--color-secondary); stroke-width: 1.2; fill: none; }
.cl-drawing .an-bar { fill: var(--color-accent); }
.cl-drawing .an-band { fill: var(--color-accent-dark); }
.cl-drawing .an-tie { stroke: var(--color-accent); stroke-width: 2.5; stroke-linecap: round; }
.cl-drawing .an-wire { stroke: var(--color-ink); stroke-width: 2.5; }
.cl-drawing .an-leader { stroke: var(--color-ink-2); stroke-width: 1; fill: none; }
.cl-drawing .an-label { font-family: var(--font-accent); font-weight: 700; font-size: 13px; letter-spacing: .12em; fill: var(--color-ink); }
.cl-drawing .an-label--accent { fill: var(--color-accent-dark); }
.cl-drawing .an-label--halo { paint-order: stroke; stroke: var(--color-paper); stroke-width: 6px; stroke-linejoin: round; }
@media (max-width: 960px) { .cl-anatomy__grid { grid-template-columns: 1fr; } }
@media (max-width: 600px) {
  .cl-drawing { padding: var(--space-3) var(--space-2) var(--space-4); }
  .cl-drawing::before { display: none; }
  .cl-drawing figcaption { padding-inline: var(--space-2); }
}

/* ---------- Uses: bento left, sticky intro right (mirrors the usual order) ---------- */
.cl-uses .sp-signs__layout { grid-template-columns: minmax(0, 1.3fr) minmax(0, .9fr); }
.cl-uses .sp-bento { order: 1; }
.cl-uses .sp-signs__intro { order: 2; }
.cl-uses .sp-bento > li:first-child { background: var(--color-card-tint-1); }
.cl-uses .sp-bento > li:nth-child(3n + 2) { background: var(--color-card-tint-3); }
.cl-uses .sp-bento > li > svg { color: var(--color-primary); }
.cl-uses .pull-quote { font-size: clamp(1.3rem, 1rem + 1.2vw, 1.9rem); border-top: 2px solid var(--color-accent); padding-top: var(--space-4); }
@media (max-width: 960px) {
  .cl-uses .sp-signs__layout { grid-template-columns: 1fr; }
  .cl-uses .sp-signs__intro { order: 0; }
}

/* ---------- Finishes & gauge: dark band, two sheets ---------- */
.cl-compare.texture-grain { background: linear-gradient(110deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 135%); }
.cl-compare .answer-block {
  background: color-mix(in srgb, var(--color-white) 6%, transparent);
  border-left-color: var(--color-accent-bright);
  color: color-mix(in srgb, var(--color-white) 90%, transparent);
}
.cl-compare .floating-ring { right: -120px; top: -100px; }
.cl-compare .cl-gauge { display: grid; grid-template-columns: minmax(0, .85fr) minmax(0, 1.15fr); gap: clamp(1.5rem, 4vw, 3.5rem); align-items: center; margin-top: clamp(2.5rem, 5vw, 4rem); }
.cl-compare .cl-gauge__copy { display: grid; gap: var(--space-3); }
.cl-compare .cl-gauge__copy h3 { color: var(--color-white); font-size: var(--fs-h3); }
.cl-compare .cl-gauge__copy p { margin: 0; color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.cl-compare .cl-gauge .sp-table { min-width: 480px; }
.cl-thick { display: inline-block; vertical-align: middle; width: 54px; margin-right: var(--space-2); border-radius: var(--radius-full); background: var(--color-secondary); }
.cl-thick--9 { height: 7px; }
.cl-thick--11 { height: 5px; }
.cl-thick--115 { height: 4px; }
.cl-compare .sp-sheet { box-shadow: var(--shadow-xl); color: var(--color-ink); }
.cl-compare .sp-sheet__head b { color: var(--color-ink); }
.cl-compare .sp-sheet .sp-sheet__foot { color: var(--color-muted); }
.cl-compare .sp-sheet__head { background: var(--color-paper-2); }
@media (max-width: 900px) { .cl-compare .cl-gauge { grid-template-columns: 1fr; } }

/* ---------- Scope: evidence list on light ---------- */
.cl-evidence { display: grid; gap: var(--space-3); margin: var(--space-10) 0 0; padding: var(--space-6); list-style: none; background: var(--color-paper); border-radius: var(--radius-lg); border-top: 4px solid var(--color-accent); box-shadow: var(--shadow-sm); }
.cl-evidence li { display: grid; grid-template-columns: 26px 1fr; gap: var(--space-3); font-size: .95rem; color: var(--color-ink-2); }
.cl-evidence li svg { color: var(--color-accent-dark); margin-top: 2px; }
.cl-evidence li strong { color: var(--color-ink); }
.cl-evidence__title { font-size: 1.05rem; margin-top: var(--space-10); }
.cl-evidence__title + .cl-evidence { margin-top: var(--space-3); }
.cl-scope .sp-included { border-style: solid; background: var(--color-card-tint-2); }

/* ---------- Proof: paper-2 band with slant ---------- */
.cl-proof { background: var(--color-paper-2); }
.cl-proof .sp-quote { background: var(--color-surface); }
.cl-proof .sp-quote:nth-child(2) { transform: rotate(-.5deg); }
.cl-proof .sp-quote:nth-child(3) { transform: rotate(.4deg); }

/* ---------- CTA: wave edge ---------- */
.cl-cta .floating-ring { opacity: .07; }

@media (prefers-reduced-motion: reduce) {
  .cl-proof .sp-quote:nth-child(n) { transform: none; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ 1. HERO (type hero, diamond-mesh motif; no client photo on file yet) ============ -->
<section class="hero hero--interior sp-hero cl-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="sp-hero__motif" aria-hidden="true">
    <svg viewBox="0 0 720 420" preserveAspectRatio="xMaxYMax slice" focusable="false">
      <defs>
        <pattern id="cl-mesh" width="36" height="36" patternUnits="userSpaceOnUse">
          <path d="M0 18 L18 0 L36 18 L18 36 Z" fill="none" stroke="currentColor" stroke-width="3"/>
        </pattern>
      </defs>
      <rect x="0" y="0" width="720" height="420" fill="url(#cl-mesh)"/>
      <rect x="0" y="22" width="720" height="10" fill="currentColor"/>
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
            <li><span aria-current="page">Chain Link</span></li>
          </ol>
        </nav>
        <span class="eyebrow">Chain link fencing · Ennis &amp; Waxahachie, TX</span>
        <h1 class="hero-title" id="hero-title">Chain Link Fence Installation in <span class="text-accent">Ennis &amp; Waxahachie</span>, TX</h1>
        <p class="hero-answer"><?php echo h($siteName); ?> installs chain link fencing for backyards, dog runs, side yards and property perimeters in Ennis, Waxahachie and the towns within about <?php echo (int) $serviceRadiusMiles; ?> miles. Chain link keeps pets and people where they belong for the lowest material cost per foot, and it leaves the view across the property wide open.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
          <li><?php echo icon('link', 16); ?>Galvanized wire mesh</li>
          <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Want a free chain link estimate?</h2>
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

<!-- ============ 2. SIGNATURE: chain link anatomy ============ -->
<section class="section cl-anatomy" aria-labelledby="anatomy-title">
  <div class="container-wide">
    <div class="cl-anatomy__grid">
      <figure class="cl-drawing reveal-left">
        <svg viewBox="0 0 640 380" role="img" aria-labelledby="anatomy-drawing-title" focusable="false">
          <title id="anatomy-drawing-title">Labeled drawing of a chain link fence section: heavy terminal posts at each end with tension bars and tension bands, two lighter line posts between them, a top rail across the posts, diamond-mesh fabric tied to the rail and line posts, a bottom tension wire along the ground, and post footings below grade</title>
          <defs>
            <pattern id="cl-fabric" width="18" height="18" patternUnits="userSpaceOnUse">
              <path class="an-mesh" d="M0 9 L9 0 L18 9 L9 18 Z"/>
            </pattern>
          </defs>
          <!-- below grade -->
          <rect class="an-clay" x="0" y="300" width="640" height="80"/>
          <!-- footings -->
          <rect class="an-footing" x="50" y="300" width="38" height="62" rx="4"/>
          <rect class="an-footing" x="216" y="300" width="28" height="50" rx="4"/>
          <rect class="an-footing" x="386" y="300" width="28" height="50" rx="4"/>
          <rect class="an-footing" x="552" y="300" width="38" height="62" rx="4"/>
          <!-- fabric -->
          <rect x="92" y="74" width="458" height="220" fill="url(#cl-fabric)"/>
          <!-- posts -->
          <rect class="an-post an-post--terminal" x="60" y="58" width="18" height="242" rx="3"/>
          <rect class="an-post an-post--terminal" x="562" y="58" width="18" height="242" rx="3"/>
          <rect class="an-post" x="225" y="66" width="10" height="234" rx="2"/>
          <rect class="an-post" x="395" y="66" width="10" height="234" rx="2"/>
          <!-- top rail -->
          <rect class="an-rail" x="69" y="66" width="502" height="7" rx="3"/>
          <!-- tension bars + bands -->
          <rect class="an-bar" x="86" y="76" width="5" height="216" rx="2"/>
          <rect class="an-bar" x="551" y="76" width="5" height="216" rx="2"/>
<?php foreach ([104, 156, 208, 260] as $clBandY): ?>
          <rect class="an-band" x="62" y="<?php echo $clBandY; ?>" width="31" height="5" rx="2"/>
          <rect class="an-band" x="549" y="<?php echo $clBandY; ?>" width="31" height="5" rx="2"/>
<?php endforeach; ?>
          <!-- ties on line posts and rail -->
<?php foreach ([230, 400] as $clTieX): foreach ([118, 178, 238] as $clTieY): ?>
          <line class="an-tie" x1="<?php echo $clTieX - 9; ?>" y1="<?php echo $clTieY; ?>" x2="<?php echo $clTieX + 9; ?>" y2="<?php echo $clTieY + 6; ?>"/>
<?php endforeach; endforeach; ?>
<?php foreach ([150, 312, 482] as $clRailTie): ?>
          <line class="an-tie" x1="<?php echo $clRailTie; ?>" y1="62" x2="<?php echo $clRailTie + 6; ?>" y2="80"/>
<?php endforeach; ?>
          <!-- bottom tension wire -->
          <line class="an-wire" x1="78" y1="292" x2="562" y2="292"/>
          <line class="an-grade" x1="0" y1="300" x2="640" y2="300"/>
          <!-- labels -->
          <path class="an-leader" d="M69 58 V36"/>
          <text class="an-label an-label--accent" x="14" y="30">TERMINAL POST</text>
          <path class="an-leader" d="M170 66 V46"/>
          <text class="an-label" x="150" y="40">TOP RAIL</text>
          <path class="an-leader" d="M400 66 V46"/>
          <text class="an-label" x="372" y="40">LINE POST</text>
          <path class="an-leader" d="M571 58 V36"/>
          <text class="an-label an-label--accent" x="512" y="30">CORNER POST</text>
          <text class="an-label an-label--halo" x="102" y="140">TENSION BAR</text>
          <text class="an-label an-label--halo" x="102" y="158">+ BANDS</text>
          <text class="an-label an-label--halo" x="244" y="196">TIE</text>
          <text class="an-label an-label--halo" x="440" y="196">FABRIC</text>
          <text class="an-label an-label--halo" x="270" y="284">BOTTOM TENSION WIRE</text>
          <text class="an-label" x="98" y="340">FOOTING</text>
          <text class="an-label" x="590" y="322" text-anchor="end">GRADE</text>
        </svg>
        <figcaption>Terminal posts sit at every end, corner and gate opening. The fabric is stretched tight between them, so they hold the pull of the whole run; that is why they are larger than line posts and set in heavier footings, and why one leaning corner post is enough to make a chain link fence sag.</figcaption>
      </figure>

      <div class="cl-anatomy__copy reveal-right">
        <span class="eyebrow">How it goes together</span>
        <h2 id="anatomy-title">What parts make up a chain link fence, and which ones carry the load?</h2>
        <p class="answer-block">A chain link fence is woven wire fabric stretched between heavy terminal posts, held up by lighter line posts and a top rail. The terminal posts at the ends, corners and gates carry the tension; the line posts, ties and bottom wire just keep the fabric straight and tight.</p>
        <div class="prose">
          <p>That split matters in Ellis County ground. Blackland clay swells after a soaking rain and pulls back in a dry spell, and a terminal post that shifts even slightly lets the whole stretch of fabric go slack. When an older chain link fence ripples or bows between posts, the fix is usually at a corner, which is a <?php echo serviceLink('fence-repair', 'fence repair job'); ?> rather than a new fence.</p>
          <p>Open mesh also changes how a fence handles wind. Air moves straight through chain link, so a spring storm that leans a solid board fence barely loads it. Add privacy slats and that changes: the mesh starts catching wind like a solid wall. If screening the yard is the real goal, a <?php echo serviceLink('privacy-fence', 'board privacy fence'); ?> is built for that load from the start.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ 3. PROBLEM: when chain link is the right call ============ -->
<section class="section sp-signs cl-uses" aria-labelledby="uses-title">
  <div class="container-wide">
    <div class="sp-signs__layout">
      <ul class="sp-bento" aria-label="Jobs where chain link fits">
        <li class="reveal-up reveal-delay-1">
          <?php echo icon('footprints', 26); ?>
          <h3>A yard that has to hold a dog</h3>
          <p>Chain link gives you a clear look at the dog from the porch and leaves nothing to chew. The bottom tension wire keeps the lower edge of the fabric pulled tight, so there is no loose curl for a nose or paw to work under.</p>
        </li>
        <li class="reveal-up reveal-delay-2">
          <?php echo icon('route', 26); ?>
          <h3>Long property lines</h3>
          <p>On a larger lot outside town, footage adds up fast. Chain link keeps the cost per foot down across a long perimeter.</p>
        </li>
        <li class="reveal-up reveal-delay-3">
          <?php echo icon('trees', 26); ?>
          <h3>A view worth keeping</h3>
          <p>A pond, a pasture or open prairie behind the house stays in sight. The fence marks the line without walling it off.</p>
        </li>
        <li class="reveal-up reveal-delay-1">
          <?php echo icon('truck', 26); ?>
          <h3>Side yards and equipment</h3>
          <p>Trailers, mowers, AC units and pool pumps stay behind a locked gate in a narrow side yard or storage area.</p>
        </li>
        <li class="reveal-up reveal-delay-2">
          <?php echo icon('users', 26); ?>
          <h3>Kids playing out back</h3>
          <p>A play area stays enclosed while parents can still see every corner of it from the kitchen window.</p>
        </li>
      </ul>

      <div class="sp-signs__intro reveal-right">
        <span class="eyebrow">Is chain link right?</span>
        <h2 id="uses-title">When is chain link the right fence for an Ennis or Waxahachie property?</h2>
        <p class="answer-block">Chain link is the right fence when the job is keeping things in rather than keeping eyes out. Dogs, kids, long property lines and equipment yards all fit it well, especially when the footage is long, the budget is fixed and you want to keep the view.</p>
        <p class="pull-quote">Pick chain link for containment and a clear view; pick boards when the point is privacy.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ 6. COMPARISON: finish + gauge (dark band) ============ -->
<section class="section sp-compare cl-compare texture-grain edge-parallelogram-top" aria-labelledby="compare-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container-wide">
    <div class="sp-head sp-head--center reveal-up">
      <span class="eyebrow">Finish &amp; wire</span>
      <h2 id="compare-title">Galvanized or black vinyl-coated: which chain link finish fits your yard?</h2>
      <p class="answer-block">Galvanized chain link is the plain silver finish and costs the least. Black vinyl-coated chain link wraps the same steel wire in a dark coating that fades into trees and lawn, which suits front yards and landscaped lots but costs more per foot.</p>
    </div>

    <div class="sp-sheet reveal-up">
      <div class="sp-sheet__head"><span>Finish guide</span><b>Two common chain link finishes</b></div>
      <div class="table-scroll" role="region" aria-label="Chain link finish comparison" tabindex="0">
        <table class="sp-table">
          <caption class="sr-only">Comparison of galvanized and black vinyl-coated chain link by look, rust protection, best use and relative cost</caption>
          <thead>
            <tr><th scope="col">Finish</th><th scope="col">Look</th><th scope="col">Rust protection</th><th scope="col">Best for</th><th scope="col">Relative cost</th></tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Galvanized<small>Zinc-coated steel wire</small></th>
              <td>Bright silver at first, dulling to gray over the years</td>
              <td>The zinc layer protects the steel; cut ends and deep scratches are where rust starts</td>
              <td>Dog runs, back lines, equipment yards and long perimeters</td>
              <td>Lower</td>
            </tr>
            <tr>
              <th scope="row">Black vinyl-coated<small>Polymer over galvanized wire</small></th>
              <td>Dark mesh that recedes against grass, shrubs and trees</td>
              <td>Coating seals the wire; a scuff that reaches the metal still has the zinc underneath</td>
              <td>Front and side yards, landscaped lots, anywhere looks matter</td>
              <td>Higher</td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="sp-sheet__foot">General comparison. Posts, rails and gates are usually finished to match the fabric, and your estimate prices the finish you choose.</p>
    </div>

    <div class="cl-gauge">
      <div class="cl-gauge__copy reveal-left">
        <h3>What does the gauge number mean?</h3>
        <p>Gauge is the thickness of the wire, and the scale runs backward: the lower the number, the thicker and stiffer the wire. Thicker wire resists bending when a large dog jumps on it or a limb comes down.</p>
        <p>On vinyl-coated fabric, ask whether a quoted gauge describes the steel core or the wire with its coating, since the coating adds thickness without adding strength. If you want an open fence that looks less utilitarian along the front, <?php echo serviceLink('wrought-iron', 'ornamental wrought iron'); ?> is the usual step up.</p>
      </div>
      <div class="sp-sheet reveal-right">
        <div class="sp-sheet__head"><span>Gauge guide</span><b>Common chain link wire</b></div>
        <div class="table-scroll" role="region" aria-label="Chain link wire gauge comparison" tabindex="0">
          <table class="sp-table">
            <caption class="sr-only">Common chain link wire gauges with approximate wire diameter and typical use</caption>
            <thead>
              <tr><th scope="col">Gauge</th><th scope="col">Wire (approx.)</th><th scope="col">Typical use</th></tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">11½ gauge</th>
                <td><span class="cl-thick cl-thick--115" aria-hidden="true"></span>0.113 in</td>
                <td>Light residential runs, small pets</td>
              </tr>
              <tr>
                <th scope="row">11 gauge</th>
                <td><span class="cl-thick cl-thick--11" aria-hidden="true"></span>0.120 in</td>
                <td>Heavier residential and light commercial</td>
              </tr>
              <tr>
                <th scope="row">9 gauge</th>
                <td><span class="cl-thick cl-thick--9" aria-hidden="true"></span>0.148 in</td>
                <td>Commercial, security and large-dog fencing</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ 4. SERVICE BREAKDOWN: included + process + evidence ============ -->
<section class="section sp-scope cl-scope" aria-labelledby="scope-title">
  <div class="container">
    <div class="sp-scope__grid">
      <div class="sp-scope__aside reveal-left">
        <span class="eyebrow">What the job covers</span>
        <h2 id="scope-title">What's included when <?php echo h($siteName); ?> installs a chain link fence?</h2>
        <p class="answer-block">A chain link installation covers every part of the fence: terminal and line posts, the top rail, the fabric, the bottom tension wire and any walk or drive gates. If an old fence is in the way, removing it is part of the job, and the written estimate itemizes each piece.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span>The run measured and every gate opening marked</span></li>
          <li><?php echo icon('check', 18); ?><span>Fence position checked against your plat or survey</span></li>
          <li><?php echo icon('check', 18); ?><span>Terminal posts at ends, corners and gates; line posts between</span></li>
          <li><?php echo icon('check', 18); ?><span>Top rail, fabric, tension bars and bottom tension wire</span></li>
          <li><?php echo icon('check', 18); ?><span>Walk gates and double drive gates hung on the run</span></li>
          <li><?php echo icon('check', 18); ?><span>Removal of the old fence it replaces</span></li>
        </ul>
        <p class="footnote">Planning a longer run with drive gates? <?php echo serviceLink('fence-installation', 'Fence and gate installation'); ?> covers gate types in detail, or compare <a class="sp-link" href="/services/">every fence D &amp; D builds</a>.</p>
      </div>

      <div>
        <h3 class="sr-only">How a chain link job runs</h3>
        <ol class="sp-timeline">
          <li class="reveal-up">
            <h3>Measure and count the corners</h3>
            <p>The estimate visit maps the run and counts terminal posts, since every end, corner and gate opening needs one. That count, along with height and finish, is what moves a chain link price most.</p>
          </li>
          <li class="reveal-up">
            <h3>Locate buried lines first</h3>
            <p>No post hole goes in until underground utilities are located. Two separate Google reviewers pointed out that this check happened before the crew started digging on their properties.</p>
          </li>
          <li class="reveal-up">
            <h3>Set terminal posts, then line posts</h3>
            <p>Ends, corners and gate posts go in first because the whole run is tensioned off them. Line posts follow along a string pulled between the terminals, so the fence runs true.</p>
          </li>
          <li class="reveal-up">
            <h3>Rail, fabric and stretch</h3>
            <p>The top rail goes on, the fabric is unrolled along the line, stretched tight with a tension bar at each terminal, then tied off to the rail and line posts. The bottom wire keeps the lower edge from curling.</p>
          </li>
          <li class="reveal-up">
            <h3>Hang and adjust the gates</h3>
            <p>Gates are hung last, once the posts beside them are solid, and set so they swing clear and latch without a shove.</p>
          </li>
        </ol>

        <h3 class="cl-evidence__title">What customers point out about the work</h3>
        <ul class="cl-evidence">
          <li><?php echo icon('handshake', 20); ?><span><strong>The same faces from quote to finish.</strong> Google reviewers name Austin and Paul as the people they dealt with on their jobs.</span></li>
          <li><?php echo icon('clipboard-list', 20); ?><span><strong>A tidy site.</strong> Reviewers mention a clean job site when the work wrapped up.</span></li>
          <li><?php echo icon('map-pin', 20); ?><span><strong>Rooted in <?php echo h(areaList()); ?>.</strong> <?php echo h($siteName); ?> has built and repaired fences here for <?php echo (int) $yearsInBusiness; ?> years.</span></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<?php if ($clReviews): ?>
<!-- ============ 5. PROOF: real Google reviews (live feed; dog and canine-facility jobs, fence type not stated) ============ -->
<section class="section sp-proof cl-proof slant-top" aria-labelledby="proof-title">
  <div class="container">
    <div class="sp-head reveal-up">
      <span class="eyebrow">From Google reviews</span>
      <h2 id="proof-title">What do customers who fenced for dogs say about <?php echo h($siteName); ?>?</h2>
      <p class="answer-block">Google reviewers who fenced for dogs and a canine training facility say <?php echo h($siteName); ?> was quick, careful around pets and stood behind the work. One training facility in Waco took storm damage the night after the job was finished, and the crew came back and repaired it as warranty work.</p>
    </div>
    <div class="sp-quotes">
<?php foreach ($clReviews['reviews'] as $clRev): ?>
      <figure class="sp-quote reveal-up">
        <span class="review-stars" role="img" aria-label="<?php echo (int) $clRev['rating']; ?> out of 5 stars"><?php echo str_repeat(icon('star', 16), (int) $clRev['rating']); ?></span>
        <blockquote><p><?php echo nl2br(h($clRev['text'])); ?></p></blockquote>
        <figcaption><b><?php echo h($clRev['name']); ?></b><span>Google review · <?php echo h(p1_google_reviews_ago($clRev['date'] ?? '')); ?></span></figcaption>
      </figure>
<?php endforeach; ?>
    </div>
    <div class="sp-proof__foot">
<?php if ($clReviews['url'] !== ''): ?>
      <a href="<?php echo h($clReviews['url']); ?>" target="_blank" rel="noopener nofollow">Read all <?php echo (int) $clReviews['count']; ?> Google reviews ↗</a>
<?php endif; ?>
      <span>Reviews are shown as written on Google. <a href="<?php echo h($gbp['review_url']); ?>" target="_blank" rel="noopener nofollow">Leave your own review</a>.</span>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ 7. FAQ (research-brief questions, chain-link-specific answers) ============ -->
<section class="section sp-faq" aria-labelledby="faq-title">
  <div class="container-narrow">
    <div class="sp-head reveal-down">
      <span class="eyebrow">Chain link questions</span>
      <h2 id="faq-title">What do property owners ask before choosing chain link fencing?</h2>
      <p class="answer-block">Property owners weighing chain link fencing ask about price, permits and HOA limits, how long it lasts against wood, and how fast it goes up. <?php echo h($siteName); ?> answers each below; for a question about your own property line or gate layout, call <?php echo phoneLink(); ?>.</p>
    </div>
    <div class="faq-grid">
<?php foreach ($clFaqs as $clIdx => $clFaq): ?>
      <details class="faq"<?php echo $clIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo h($clFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo h($clFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>

</article>

<!-- ============ RELATED SERVICES (required services component, 3 cards) ============ -->
<section class="section sp-related cl-related" aria-label="Related fence services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which other <span class="text-accent">fence services</span> pair with chain link?</h2>
      <p class="hero-answer">Chain link projects often lead to one of three other jobs. Some owners add a longer run with drive gates, some want decorative wrought iron along the front of the property, and some need repairs to an older fence on another side of the lot. <?php echo h($siteName); ?> handles each one across Ennis, Waxahachie and nearby towns.</p>
      <span class="section-subtitle">Gates &amp; new runs · Wrought iron · Repairs</span>
    </div>
    <div class="services-grid">
<?php foreach ($clRelated as $clI => $clSlug):
        $clRel  = serviceBySlug($clSlug);
        $clCard = $clCards[$clSlug];
        $clTint = ($clI % 3) + 1; ?>
      <article class="service-card-with-image card-tint-<?php echo $clTint; ?> reveal-up reveal-delay-<?php echo $clTint; ?>">
        <div class="service-card__body">
          <div class="service-card__head">
            <div class="service-card__icon"><?php echo icon($clCard['icon'], 24); ?></div>
            <h3><?php echo h($clRel['name']); ?></h3>
          </div>
          <p class="service-card__desc"><?php echo h($clCard['desc']); ?></p>
          <ul>
<?php foreach ($clCard['bullets'] as $clBullet): ?>
            <li><?php echo h($clBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($clSlug); ?>/" class="service-card__cta">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <a class="btn btn-secondary sp-hub-link" href="/services/">View All Services →</a>
  </div>
</section>

<!-- ============ 8. FINAL CTA ============ -->
<section class="cta-banner texture-grain edge-wave-top sp-cta cl-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-copy reveal-scale">
      <span class="eyebrow">Chain link estimate</span>
      <h2 id="cta-title">Ready to price chain link for your property?</h2>
      <p>Send the rough footage, the height you have in mind and how many gates you need, and <?php echo h($siteName); ?> will arrange a time to measure the run.</p>
    </div>
    <div class="actions reveal-scale reveal-delay-2">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a Free Chain Link Estimate</button>
      <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
