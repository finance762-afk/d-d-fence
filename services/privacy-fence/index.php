<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/privacy-fence/ — D & D Fence (Phase 4, 2026-10-19). Premium editorial service page (interactive-patterns §2.8).
 * No client photos on file: type hero with a board-fence motif, and a sightline drawing as the page's signature visual.
 * Proof comes live from the Google reviews feed (serviceReviews), never hard-coded. Recent-work strip and before/after
 * are skipped until photos exist. Facts the page wanted but intake lacks are listed in /content-confirmations.json.
 */
$svc            = serviceBySlug('privacy-fence');
$pageTitle      = 'Privacy Fences in Ennis & Waxahachie, TX | ' . $siteName;
$pageDescription = 'Privacy fences from D & D Fence for backyards in Ennis, Waxahachie and Ellis County: height, board layout and gates planned to your lot. Call (469) 321-7783.';
$canonicalUrl   = $siteUrl . '/services/privacy-fence/';
$ogImage        = defaultOgImage();
$currentPage    = 'services';
$pageType       = 'service';
$serviceSlug    = 'privacy-fence';

$pfFaqs = [
    ['q' => 'How much does a privacy fence cost in Ennis or Waxahachie?',
     'a' => 'A privacy fence is priced by the linear foot, and the total depends on the height, the board layout, how many gates go in, the ground along the line and whether an old fence has to come out first. D & D Fence measures the run on site and puts the materials and labor in a written estimate.'],
    ['q' => 'Do I need a permit or HOA approval for a privacy fence?',
     'a' => 'Often, yes. Cities set height limits and may require a permit, and HOAs commonly control height, board style, stain color and which side of the fence faces the street. D & D Fence can check the rules for your address before the layout is final, so nobody asks for changes after the boards are up.'],
    ['q' => 'How long does it take to build a privacy fence?',
     'a' => 'Most residential privacy fence runs take one to three days, depending on the length, the ground and the weather. One Google reviewer had more than 90 feet of fence with a sliding gate built and stained in a matter of days.'],
    ['q' => 'How do I know where my property line is before the fence goes up?',
     'a' => 'Start with the survey or plat in your closing papers. A privacy fence usually runs close to the line, so if the corner pins cannot be found, a licensed surveyor can mark them before any post hole is dug. That small cost heads off a dispute with the neighbor later.'],
];

$schemaMarkup = servicePageSchema(
    $svc,
    'Privacy Fence Installation in Ennis & Waxahachie, TX',
    'Privacy fence installation by D & D Fence for backyards and property lines in Ennis, Waxahachie and the surrounding Ellis County area: layout, posts, rails, boards, gates and old fence removal.',
    generateFAQSchema($pfFaqs),
    ['serviceType' => 'Privacy fence installation']
);

$pfReviews = serviceReviews('low spot|corner|stain|privacy|backyard|move in|height', 3);
$pfCards   = serviceCards();
$pfRelated = ['cedar-fence', 'fence-installation', 'fence-repair'];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?>

/* ==========================================================================
   Privacy fence — page-specific composition: board-run hero motif, sightline drawing (signature),
   privacy meters in the layout table, warm pull-quote rule. Tokens only.
   ========================================================================== */
.pf-hero .sp-hero__motif { opacity: .075; }
.pf-hero .eyebrow::before { width: 34px; }

/* Signs: pull quote sits on a board-texture rule */
.pf-signs .pull-quote { position: relative; padding-left: var(--space-6); }
.pf-signs .pull-quote::after {
  content: "";
  position: absolute;
  left: 0;
  top: var(--space-1);
  bottom: var(--space-1);
  width: 6px;
  border-radius: var(--radius-full);
  background: repeating-linear-gradient(180deg, var(--color-accent) 0 22px, var(--color-accent-dark) 22px 26px);
}

/* Signature: sightline drawing */
.pf-sightline {
  margin: var(--space-4) 0 0;
  padding: var(--space-5) var(--space-5) var(--space-4);
  background: var(--color-surface);
  border: 1px solid var(--color-line);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow);
}
.pf-sightline svg { width: 100%; height: auto; display: block; }
.pf-sightline figcaption { margin-top: var(--space-3); font-size: .88rem; line-height: 1.5; color: var(--color-ink-2); }
.pf-sightline .sl-ground { stroke: var(--color-ink); stroke-width: 2; }
.pf-sightline .sl-grid { stroke: var(--color-line); stroke-width: 1; }
.pf-sightline .sl-panel { fill: var(--color-card-tint-3); stroke: var(--color-accent-dark); stroke-width: 1.5; }
.pf-sightline .sl-board { stroke: color-mix(in srgb, var(--color-accent-dark) 45%, transparent); stroke-width: 1; }
.pf-sightline .sl-panel--low { fill: var(--color-card-tint-2); stroke: var(--color-secondary); }
.pf-sightline .sl-eye { stroke: var(--color-accent); stroke-width: 2; stroke-dasharray: 7 6; }
.pf-sightline .sl-person { fill: var(--color-primary); }
.pf-sightline .sl-label { font-family: var(--font-accent); font-weight: 700; font-size: 14px; letter-spacing: .12em; fill: var(--color-ink); }
.pf-sightline .sl-label--accent { fill: var(--color-accent-dark); }
.pf-sightline .sl-label--muted { fill: var(--color-muted); font-size: 12px; }

/* Expert band: the figure gets a stacked-board edge */
.pf-expert .sp-figure { overflow: hidden; }
.pf-expert .sp-figure::after {
  content: "";
  position: absolute;
  right: 0;
  top: 0;
  bottom: 0;
  width: 18px;
  background: repeating-linear-gradient(180deg, color-mix(in srgb, var(--color-accent) 55%, transparent) 0 30px, transparent 30px 36px);
  opacity: .6;
}
.pf-expert .floating-ring { left: -140px; bottom: -160px; }

/* Scope: included list sits on a board-gap background */
.pf-scope .sp-included { background: repeating-linear-gradient(90deg, var(--color-paper) 0 46px, var(--color-paper-2) 46px 48px); }

/* Layout table: privacy meter */
.pf-meter { display: inline-flex; gap: 3px; vertical-align: middle; margin-right: var(--space-2); }
.pf-meter i { width: 10px; height: 18px; border-radius: 2px; background: var(--color-line); }
.pf-meter i.on { background: var(--color-accent); }
.pf-compare .sp-sheet::before {
  content: "";
  position: absolute;
  top: var(--space-5);
  right: var(--space-5);
  width: 14px;
  height: 14px;
  border-radius: 50%;
  border: 3px solid var(--color-line);
  background: var(--color-paper-2);
}
.pf-compare .sp-sheet__head { padding-right: var(--space-12); }
.pf-compare .sp-compare__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.5fr); gap: clamp(2rem, 5vw, 4rem); align-items: start; }
@media (max-width: 960px) { .pf-compare .sp-compare__grid { grid-template-columns: 1fr; } }

/* Proof: warmer paper and a ruled header line */
.pf-proof .sp-head { border-bottom: 1px solid var(--color-line); padding-bottom: var(--space-6); max-width: none; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); align-items: end; column-gap: clamp(2rem, 5vw, 4rem); }
.pf-proof .sp-head .eyebrow, .pf-proof .sp-head h2 { grid-column: 1; }
.pf-proof .sp-head .answer-block { grid-column: 2; grid-row: 1 / span 2; }
@media (max-width: 900px) {
  .pf-proof .sp-head { grid-template-columns: 1fr; }
  .pf-proof .sp-head .answer-block { grid-column: 1; grid-row: auto; }
}

.pf-cta .floating-ring { opacity: .08; }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ 1. HERO (type hero, board-run motif; no client photo on file yet) ============ -->
<section class="hero hero--interior sp-hero pf-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="sp-hero__motif" aria-hidden="true">
    <svg viewBox="0 0 720 420" preserveAspectRatio="xMaxYMax slice" focusable="false">
      <defs>
        <pattern id="pf-boards" width="34" height="420" patternUnits="userSpaceOnUse">
          <path d="M2 46 l6 -9 h18 l6 9 V420 H2 Z" fill="currentColor"/>
        </pattern>
      </defs>
      <rect x="0" y="0" width="720" height="420" fill="url(#pf-boards)"/>
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
            <li><span aria-current="page">Privacy Fence</span></li>
          </ol>
        </nav>
        <span class="eyebrow">Privacy fencing · Ennis &amp; Waxahachie, TX</span>
        <h1 class="hero-title" id="hero-title">Privacy Fence Installation in <span class="text-accent">Ennis &amp; Waxahachie</span>, TX</h1>
        <p class="hero-answer"><?php echo h($siteName); ?> builds solid board privacy fences for backyards and property lines in Ennis, Waxahachie and the towns within about <?php echo (int) $serviceRadiusMiles; ?> miles. Each fence is laid out around your lot's grade, corners and gates, so the line runs clean and closes off the view from the street and the yard next door.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
          <li><?php echo icon('fence', 16); ?>Worked to your grade &amp; corners</li>
          <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Want a free privacy fence estimate?</h2>
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

<!-- ============ 2. PROBLEM: when a yard needs one (pull quote + bento) ============ -->
<section class="section sp-signs pf-signs" aria-labelledby="signs-title">
  <div class="container-wide">
    <div class="sp-signs__layout">
      <div class="sp-signs__intro reveal-left">
        <span class="eyebrow">Is it time for one?</span>
        <h2 id="signs-title">When does a backyard in Ennis or Waxahachie need a <span class="text-accent">privacy fence</span>?</h2>
        <p class="answer-block">A privacy fence pays off when a yard has to be closed off: a dog that must stay in, a patio or pool in view of the street, or a new house with open neighbors on three sides. Solid boards block the view and mark the property line in a single build.</p>
        <p class="pull-quote">The right height is set by the eye line next door, not by the tape measure.</p>
        <figure class="pf-sightline">
          <svg viewBox="0 0 520 300" role="img" aria-labelledby="sightline-title" focusable="false">
            <title id="sightline-title">Drawing comparing 4-foot, 6-foot and 8-foot fences against the eye line of a 5-foot-9 adult, about 5 feet 4 inches off the ground: the 4-foot fence sits below the eye line, the 6-foot and 8-foot fences sit above it</title>
<?php for ($slY = 30; $slY < 270; $slY += 30): ?>
            <line class="sl-grid" x1="20" y1="<?php echo $slY; ?>" x2="500" y2="<?php echo $slY; ?>"/>
<?php endfor; ?>
<?php foreach ([[50, 150, '4 FT', true], [190, 90, '6 FT', false], [330, 30, '8 FT', false]] as [$slX, $slTop, $slLabel, $slLow]): ?>
            <rect class="sl-panel<?php echo $slLow ? ' sl-panel--low' : ''; ?>" x="<?php echo $slX; ?>" y="<?php echo $slTop; ?>" width="100" height="<?php echo 270 - $slTop; ?>" rx="2"/>
<?php for ($slB = $slX + 12; $slB < $slX + 100; $slB += 12): ?>
            <line class="sl-board" x1="<?php echo $slB; ?>" y1="<?php echo $slTop + 2; ?>" x2="<?php echo $slB; ?>" y2="268"/>
<?php endfor; ?>
            <text class="sl-label" x="<?php echo $slX + 50; ?>" y="<?php echo $slTop - 8; ?>" text-anchor="middle"><?php echo $slLabel; ?></text>
<?php endforeach; ?>
            <line class="sl-eye" x1="20" y1="110" x2="500" y2="110"/>
            <text class="sl-label sl-label--accent" x="24" y="102">EYE LINE</text>
            <text class="sl-label sl-label--muted" x="24" y="128">≈ 5′4″</text>
            <circle class="sl-person" cx="478" cy="108" r="11"/>
            <rect class="sl-person" x="468" y="122" width="20" height="78" rx="8"/>
            <rect class="sl-person" x="469" y="196" width="8" height="74" rx="3"/>
            <rect class="sl-person" x="479" y="196" width="8" height="74" rx="3"/>
            <line class="sl-ground" x1="20" y1="270" x2="500" y2="270"/>
          </svg>
          <figcaption>On level ground, a 6-foot fence clears the eye line of a 5′9″ adult standing next door; 8 feet helps where the neighbor's yard sits higher than yours. Your city and HOA set the maximum, so check both before choosing.</figcaption>
        </figure>
      </div>

      <ul class="sp-bento" aria-label="Reasons owners add a privacy fence">
        <li class="reveal-up reveal-delay-1">
          <?php echo icon('home', 26); ?>
          <h3>A new house with an open yard</h3>
          <p>Plenty of newer houses around Ellis County come with no fence at all. A privacy fence is usually the first project, and one Google reviewer had theirs finished in time for move-in day so their dog could run and play.</p>
        </li>
        <li class="reveal-up reveal-delay-2">
          <?php echo icon('footprints', 26); ?>
          <h3>A dog that keeps getting out</h3>
          <p>Boards run close to the ground with no gaps to squeeze through, and a dog that cannot see the street usually barks at it less.</p>
        </li>
        <li class="reveal-up reveal-delay-3">
          <?php echo icon('sun', 26); ?>
          <h3>A patio or pool on display</h3>
          <p>A full-height board fence turns a back patio, pool deck or hot tub back into private space.</p>
        </li>
        <li class="reveal-up reveal-delay-1">
          <?php echo icon('car', 26); ?>
          <h3>A corner lot or busy street</h3>
          <p>Solid boards screen headlights and passing traffic, and they make the property line obvious to everyone.</p>
        </li>
        <li class="reveal-up reveal-delay-2">
          <?php echo icon('users', 26); ?>
          <h3>Neighbors close on every side</h3>
          <p>Where yards sit shoulder to shoulder, a privacy fence gives both households a clear line and their own space.</p>
        </li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ 3. EXPERT POSITIONING (dark band) ============ -->
<section class="section sp-expert pf-expert texture-grain slant-top" aria-labelledby="expert-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div class="sp-expert__grid">
      <div class="reveal-left">
        <span class="eyebrow">Built to the lot</span>
        <h2 id="expert-title">How does <?php echo h($siteName); ?> handle slopes, odd corners and gates on a privacy fence?</h2>
        <p class="answer-block"><?php echo h($siteName); ?> fits the fence to the ground and the lot instead of forcing a straight template onto them. Low spots are worked so the bottom line stays tight, corners that cannot be squared can be rounded, and gates go where you actually walk.</p>
        <div class="prose">
          <p>A privacy fence is a wall of boards, and in open Ellis County country it catches wind like a sail. Spring storms push straight-line winds across the prairie, and that load lands on the posts. Blackland clay adds its own push: it swells when it is wet and shrinks and cracks in August. Those two forces are why most privacy fences that fail here fail at the posts first, and why the post line gets the most attention on a <?php echo h($siteName); ?> build.</p>
          <p>Most privacy fences around Ennis and Waxahachie are wood. If you are choosing between woods, the <?php echo serviceLink('cedar-fence', 'cedar fence page'); ?> compares cedar with pressure-treated pine. If you already have a fence that leans or has gaps, <?php echo serviceLink('fence-repair', 'repairing the existing fence'); ?> may cost far less than starting over.</p>
        </div>
      </div>
      <div class="reveal-right">
        <div class="sp-figure">
          <b><?php echo (int) $yearsInBusiness; ?><span> yrs</span></b>
          <span>building and repairing fences around Ennis and Waxahachie under owner <?php echo h($ownerName); ?></span>
        </div>
        <ul class="sp-points">
          <li><?php echo icon('mountain', 22); ?><span><strong>Low spots handled.</strong> One Google reviewer had a steep drop beside a building and called the finished transition "beautiful."</span></li>
          <li><?php echo icon('route', 22); ?><span><strong>Out-of-square corners rounded.</strong> Where a lot could not take a square corner, the crew rounded it so the fence does not look crooked.</span></li>
          <li><?php echo icon('handshake', 22); ?><span><strong>Austin on the job.</strong> Reviewers name Austin and Paul as the people who measured, quoted and built their fences.</span></li>
          <li><?php echo icon('clipboard-list', 22); ?><span><strong>Fair on changes.</strong> A reviewer who added upgrades after the first quote said the pricing stayed fair.</span></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ============ 4. SERVICE BREAKDOWN: included + process timeline ============ -->
<section class="section sp-scope pf-scope" aria-labelledby="scope-title">
  <div class="container">
    <div class="sp-scope__grid">
      <div class="sp-scope__aside reveal-left">
        <span class="eyebrow">What the job covers</span>
        <h2 id="scope-title">What's included when <?php echo h($siteName); ?> builds a privacy fence?</h2>
        <p class="answer-block">A privacy fence job covers the layout, posts, rails, boards and any gates on the run, plus taking out an old fence if one is in the way. The written estimate lists materials and labor for your run, so you can compare it line by line with other bids.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span>The fence line walked and measured on your property</span></li>
          <li><?php echo icon('check', 18); ?><span>Property line checked against your plat or survey</span></li>
          <li><?php echo icon('check', 18); ?><span>Posts, rails and boards in the height and layout you choose</span></li>
          <li><?php echo icon('check', 18); ?><span>Walk gates or wide drive gates built into the run</span></li>
          <li><?php echo icon('check', 18); ?><span>Old fence removal when the new one replaces it</span></li>
          <li><?php echo icon('check', 18); ?><span>A cleaned-up yard when the crew leaves</span></li>
        </ul>
        <p class="footnote">Need a gate that slides or opens on its own? See <?php echo serviceLink('fence-installation', 'fence and gate installation'); ?>, or browse <a class="sp-link" href="/services/">all six fence services</a>.</p>
      </div>

      <div>
        <h3 class="sr-only">How a privacy fence job runs</h3>
        <ol class="sp-timeline">
          <li class="reveal-up">
            <h3>Walk the line together</h3>
            <p><?php echo h($siteName); ?> walks the yard with you, measures the run and notes the grade, low spots, trees, utility boxes and where the gates need to go. This is also when you talk through height and board layout.</p>
          </li>
          <li class="reveal-up">
            <h3>Check the rules and the line</h3>
            <p>Your plat or survey settles where the fence sits, and the city and HOA rules for your address settle how tall it can be and which side faces out. Sorting both before the build keeps the fence from being moved later.</p>
          </li>
          <li class="reveal-up">
            <h3>Mark utilities, string the line</h3>
            <p>Buried lines are located before any digging. Two Google reviewers mentioned that the underground utility check was done before work started on their fences. Then the fence line is strung so the posts land straight.</p>
          </li>
          <li class="reveal-up">
            <h3>Posts, rails, then boards</h3>
            <p>Posts go in first along the string line, rails follow, and the boards are hung last and worked to the grade so the bottom stays tight to the ground across dips and rises.</p>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 6. COMPARISON: board layouts (real table) ============ -->
<section class="section sp-compare pf-compare" aria-labelledby="compare-title">
  <div class="container-wide">
    <div class="sp-compare__grid">
      <div class="sp-head reveal-left">
        <span class="eyebrow">Board layouts</span>
        <h2 id="compare-title">Side-by-side, board-on-board or shadowbox: which privacy layout fits your yard?</h2>
        <p class="answer-block">Board-on-board gives the most complete privacy because the boards overlap, so no gaps open as the wood dries. Side-by-side uses the fewest boards and looks clean but can show thin gaps over time. Shadowbox looks finished from both yards and lets wind through.</p>
        <p>Wind matters more than most owners expect. A fully solid fence takes the whole force of a storm gust on its posts, while a shadowbox fence lets some of it pass between the boards.</p>
      </div>

      <div class="sp-sheet reveal-right">
        <div class="sp-sheet__head"><span>Layout guide</span><b>Three ways to hang privacy boards</b></div>
        <div class="table-scroll" role="region" aria-label="Privacy fence board layout comparison" tabindex="0">
          <table class="sp-table">
            <caption class="sr-only">Comparison of side-by-side, board-on-board and shadowbox privacy fence layouts by privacy, appearance from each side, wind and board count</caption>
            <thead>
              <tr><th scope="col">Layout</th><th scope="col">Privacy</th><th scope="col">From the neighbor's side</th><th scope="col">In high wind</th><th scope="col">Boards used</th></tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">Side-by-side<small>Boards butted edge to edge</small></th>
                <td><span class="pf-meter" aria-hidden="true"><i class="on"></i><i class="on"></i><i></i></span>Good; thin gaps can open as boards dry</td>
                <td>Rails and posts show on one side</td>
                <td>Solid, full load on the posts</td>
                <td>Fewest</td>
              </tr>
              <tr>
                <th scope="row">Board-on-board<small>Overlapping boards</small></th>
                <td><span class="pf-meter" aria-hidden="true"><i class="on"></i><i class="on"></i><i class="on"></i></span>Full; overlaps cover any shrinkage</td>
                <td>Rails and posts show on one side</td>
                <td>Solid, full load on the posts</td>
                <td>Most</td>
              </tr>
              <tr>
                <th scope="row">Shadowbox<small>Boards alternate sides of the rail</small></th>
                <td><span class="pf-meter" aria-hidden="true"><i class="on"></i><i class="on"></i><i></i></span>Good head-on; you can see through at an angle</td>
                <td>Looks the same from both yards</td>
                <td>Some air passes between boards</td>
                <td>Between the two</td>
              </tr>
            </tbody>
          </table>
        </div>
        <p class="sp-sheet__foot">General comparison of common layouts. Your estimate prices the layout, height and gates you choose for your run.</p>
      </div>
    </div>
  </div>
</section>

<?php if ($pfReviews): ?>
<!-- ============ 5. PROOF: real Google reviews (live feed, filtered to privacy/backyard jobs) ============ -->
<section class="section sp-proof pf-proof" aria-labelledby="proof-title">
  <div class="container">
    <div class="sp-head reveal-up">
      <span class="eyebrow">From Google reviews</span>
      <h2 id="proof-title">What do backyard fence customers say about <?php echo h($siteName); ?>?</h2>
      <p class="answer-block">Google reviewers say <?php echo h($siteName); ?> finished their backyard fences on schedule and handled low spots and odd corners cleanly. Several mention dogs, move-in dates and fence height. These reviews come straight from the company's Google Business Profile and are shown exactly as written.</p>
    </div>
    <div class="sp-quotes">
<?php foreach ($pfReviews['reviews'] as $pfRev): ?>
      <figure class="sp-quote reveal-up">
        <span class="review-stars" role="img" aria-label="<?php echo (int) $pfRev['rating']; ?> out of 5 stars"><?php echo str_repeat(icon('star', 16), (int) $pfRev['rating']); ?></span>
        <blockquote><p><?php echo nl2br(h($pfRev['text'])); ?></p></blockquote>
        <figcaption><b><?php echo h($pfRev['name']); ?></b><span>Google review · <?php echo h(p1_google_reviews_ago($pfRev['date'] ?? '')); ?></span></figcaption>
      </figure>
<?php endforeach; ?>
    </div>
    <div class="sp-proof__foot">
<?php if ($pfReviews['url'] !== ''): ?>
      <a href="<?php echo h($pfReviews['url']); ?>" target="_blank" rel="noopener nofollow">Read all <?php echo (int) $pfReviews['count']; ?> Google reviews ↗</a>
<?php endif; ?>
      <span>Built a fence with us? <a href="<?php echo h($gbp['review_url']); ?>" target="_blank" rel="noopener nofollow">Leave a Google review</a>.</span>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ 7. FAQ (research-brief questions, privacy-specific answers) ============ -->
<section class="section sp-faq" aria-labelledby="faq-title">
  <div class="container-narrow">
    <div class="sp-head reveal-down">
      <span class="eyebrow">Privacy fence questions</span>
      <h2 id="faq-title">What do Ennis and Waxahachie homeowners ask before building a privacy fence?</h2>
      <p class="answer-block">Homeowners planning a privacy fence in Ennis or Waxahachie usually ask about four things: cost, permits and HOA rules, how long the build takes, and where the property line sits. The answers below come from <?php echo h($siteName); ?>; call <?php echo phoneLink(); ?> for anything specific to your yard.</p>
    </div>
    <div class="faq-grid">
<?php foreach ($pfFaqs as $pfIdx => $pfFaq): ?>
      <details class="faq"<?php echo $pfIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo h($pfFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo h($pfFaq['a']); ?></p>
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
      <h2>Which other <span class="text-accent">fence services</span> go with a privacy fence?</h2>
      <p class="hero-answer">Most privacy fence projects touch one of three other jobs: choosing cedar for the boards, adding a gate or a longer run, or fixing an older fence that already stands on part of the line. <?php echo h($siteName); ?> handles all three across Ennis, Waxahachie and the surrounding area.</p>
      <span class="section-subtitle">Cedar · Gates &amp; new runs · Repairs</span>
    </div>
    <div class="services-grid">
<?php foreach ($pfRelated as $pfI => $pfSlug):
        $pfRel  = serviceBySlug($pfSlug);
        $pfCard = $pfCards[$pfSlug];
        $pfTint = ($pfI % 3) + 1; ?>
      <article class="service-card-with-image card-tint-<?php echo $pfTint; ?> reveal-up reveal-delay-<?php echo $pfTint; ?>">
        <div class="service-card__body">
          <div class="service-card__head">
            <div class="service-card__icon"><?php echo icon($pfCard['icon'], 24); ?></div>
            <h3><?php echo h($pfRel['name']); ?></h3>
          </div>
          <p class="service-card__desc"><?php echo h($pfCard['desc']); ?></p>
          <ul>
<?php foreach ($pfCard['bullets'] as $pfBullet): ?>
            <li><?php echo h($pfBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($pfSlug); ?>/" class="service-card__cta">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <a class="btn btn-secondary sp-hub-link" href="/services/">View All Services →</a>
  </div>
</section>

<!-- ============ 8. FINAL CTA ============ -->
<section class="cta-banner texture-grain edge-curve-top sp-cta pf-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-copy reveal-scale">
      <span class="eyebrow">Privacy fence estimate</span>
      <h2 id="cta-title">Ready to price a privacy fence for your yard?</h2>
      <p>Send the rough length, the height you want and the town, and <?php echo h($siteName); ?> will set up a time to walk the line with you.</p>
    </div>
    <div class="actions reveal-scale reveal-delay-2">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a Free Privacy Fence Estimate</button>
      <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
