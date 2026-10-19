<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/fence-repair/ — D & D Fence (Phase 4, 2026-10-19). Premium editorial service page (interactive-patterns §2.8).
 * No client photos on file: type hero with a leaning-section motif; the signature section is a symptom finder table.
 * Section order differs from the other service pages: finder → repair-or-replace (dark) → repair visit → gates → proof → FAQ.
 * Proof comes live from the Google reviews feed (serviceReviews), never hard-coded. Facts the page wanted but intake
 * lacks (warranty terms, response times, other builders' fences) are listed in /content-confirmations.json, not written here.
 */
$svc             = serviceBySlug('fence-repair');
$pageTitle       = 'Fence & Gate Repair in Ennis & Waxahachie, TX | ' . $siteName;
$pageDescription = 'Fence and gate repair from D & D Fence in Ennis, Waxahachie and Ellis County: leaning posts, broken boards, storm damage and sagging gates. Call (469) 321-7783.';
$canonicalUrl    = $siteUrl . '/services/fence-repair/';
$ogImage         = defaultOgImage();
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = 'fence-repair';

$frFaqs = [
    ['q' => 'How much does fence repair cost in Ennis or Waxahachie?',
     'a' => 'The cost of a fence repair depends on how many posts have failed, how much board, rail or chain link fabric needs replacing, whether a gate has to be reset, and the ground along the damaged run. D & D Fence looks at the damage first and puts the repair price in writing before any work starts.'],
    ['q' => 'Is a fence repair covered by a warranty?',
     'a' => 'Coverage depends on the material and on who built the fence. For fences D & D Fence builds, the warranty terms come in writing with the estimate, and one Google reviewer had storm damage on a just-finished fence repaired as warranty work at no charge. Ask what applies to your repair when you get the price.'],
    ['q' => 'Which fence material needs the fewest repairs?',
     'a' => 'Coated metal, such as galvanized chain link and powder-coated ornamental steel, usually needs the fewest repairs because its posts do not rot. Wood fences need the most attention at the posts and boards, although cedar holds up to rot better than most woods. If the same wood posts keep failing, compare one more repair with a rebuild.'],
];

$schemaMarkup = servicePageSchema(
    $svc,
    'Fence Repair in Ennis & Waxahachie, TX',
    'Fence and gate repair by D & D Fence in Ennis, Waxahachie and the surrounding Ellis County area: leaning and rotted posts reset or replaced, broken boards and rails replaced, storm-damaged sections rebuilt and sagging gates squared and rehung.',
    generateFAQSchema($frFaqs),
    ['serviceType' => 'Fence and gate repair']
);

$frReviews = serviceReviews('repair|warranty|storm|issue with the gate|stain the fence', 3);
$frCards   = serviceCards();
$frRelated = ['privacy-fence', 'cedar-fence', 'fence-installation'];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?>

/* ==========================================================================
   Fence repair — page-specific composition: leaning-section hero motif, symptom finder (signature table
   with repair/rebuild tags), dark repair-or-replace verdict cards on a torn edge, gate bento on a
   parallelogram edge, wave-topped closing band. Tokens only.
   ========================================================================== */
.fr-hero .sp-hero__motif { opacity: .08; width: min(60%, 760px); }
.fr-hero .eyebrow { color: var(--color-accent-bright); }

/* ---------- Signature: symptom finder ---------- */
.fr-finder { background: var(--color-paper); }
.fr-finder .sp-head { max-width: 68ch; }
.fr-finder .sp-sheet { box-shadow: var(--shadow-lg); }
.fr-finder .sp-sheet__head { background: var(--color-dark); border-bottom-color: color-mix(in srgb, var(--color-white) 18%, transparent); }
.fr-finder .sp-sheet__head span { color: var(--color-accent-bright); }
.fr-finder .sp-sheet__head b { color: var(--color-white); }
.fr-finder .sp-table { min-width: 760px; }
.fr-finder .sp-table tbody th { width: 21%; }
.fr-finder .sp-table tbody th svg { display: block; margin-bottom: var(--space-2); color: var(--color-accent-dark); }
.fr-finder .sp-table td:last-child { width: 15%; }
.fr-finder .sp-table tbody tr:nth-child(even) { background: color-mix(in srgb, var(--color-paper) 60%, transparent); }
.fr-finder .sp-table tbody tr:nth-child(even):hover { background: color-mix(in srgb, var(--color-accent) 5%, transparent); }
.fr-tag {
  display: inline-flex;
  align-items: center;
  gap: var(--space-1);
  padding: var(--space-1) var(--space-3);
  border-radius: var(--radius-full);
  font-family: var(--font-accent);
  font-weight: 700;
  font-size: var(--fs-eyebrow);
  letter-spacing: .1em;
  text-transform: uppercase;
  white-space: nowrap;
  background: var(--color-card-tint-1);
  color: var(--color-ink);
  border: 1px solid var(--color-line);
}
.fr-tag--watch { background: var(--color-card-tint-3); color: var(--color-accent-dark); border-color: color-mix(in srgb, var(--color-accent) 35%, transparent); }
.fr-finder__note {
  display: grid;
  grid-template-columns: auto 1fr;
  gap: var(--space-4);
  align-items: start;
  margin-top: var(--space-8);
  max-width: 70ch;
  padding: var(--space-5) var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-surface);
  border: 1px solid var(--color-line);
  box-shadow: var(--shadow-sm);
}
.fr-finder__note svg { color: var(--color-accent-dark); margin-top: 2px; }
.fr-finder__note p { margin: 0; font-size: .95rem; color: var(--color-ink-2); }
.fr-finder__note p + p { margin-top: var(--space-3); }

/* ---------- Repair or replace (dark, torn top) ---------- */
.fr-verdict .sp-head { max-width: 64ch; }
.fr-verdict .answer-block {
  background: color-mix(in srgb, var(--color-white) 6%, transparent);
  border-left-color: var(--color-accent-bright);
  color: color-mix(in srgb, var(--color-white) 90%, transparent);
}
.fr-verdict__cols { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: var(--space-6); }
.fr-col {
  position: relative;
  padding: var(--space-8) var(--space-6) var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid color-mix(in srgb, var(--color-white) 16%, transparent);
  background: color-mix(in srgb, var(--color-white) 4%, transparent);
  backdrop-filter: blur(6px);
}
.fr-col--replace { border-color: color-mix(in srgb, var(--color-accent-bright) 45%, transparent); background: color-mix(in srgb, var(--color-accent) 9%, transparent); }
.fr-col h3 { display: flex; align-items: center; gap: var(--space-3); color: var(--color-white); font-size: 1.2rem; margin-bottom: var(--space-4); }
.fr-col h3 svg { color: var(--color-accent-bright); }
.fr-col ul { display: grid; gap: var(--space-3); margin: 0; padding: 0; list-style: none; }
.fr-col li { position: relative; padding-left: var(--space-6); font-size: .96rem; color: color-mix(in srgb, var(--color-white) 80%, transparent); }
.fr-col li::before { content: ""; position: absolute; left: 0; top: .6em; width: 10px; height: 2px; background: var(--color-accent-bright); }
.fr-verdict .prose { margin-top: var(--space-8); }
.fr-verdict .prose p { color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.fr-verdict .prose a { color: var(--color-white); }
.fr-verdict .floating-ring { right: -120px; bottom: -150px; }
@media (max-width: 800px) { .fr-verdict__cols { grid-template-columns: 1fr; } }

/* ---------- Repair visit: timeline first, aside second (mirrors the other pages) ---------- */
.fr-visit .sp-scope__grid { grid-template-columns: minmax(0, 1.25fr) minmax(0, 1fr); }
.fr-visit .sp-scope__aside { order: 2; }
.fr-visit .sp-included { background: var(--color-card-tint-2); border-style: solid; }
@media (max-width: 900px) {
  .fr-visit .sp-scope__grid { grid-template-columns: 1fr; }
  .fr-visit .sp-scope__aside { order: 0; }
}

/* ---------- Gates (paper-2, parallelogram edge) ---------- */
.fr-gates { background: var(--color-paper-2); }
.fr-gates .sp-bento > li:first-child { background: var(--color-surface); border-left: 4px solid var(--color-accent); }
.fr-gates .sp-bento a { color: var(--color-primary); font-weight: 600; }

/* ---------- Proof ---------- */
.fr-proof .sp-quote { border-top: 4px solid var(--color-accent); }

/* ---------- FAQ ---------- */
.fr-faq .faq summary::after { color: var(--color-accent); }

/* ---------- Closing band (wave top) ---------- */
.fr-cta.edge-wave-top { padding-top: calc(var(--section-pad) + var(--space-8)); }
.fr-cta .floating-ring { left: -100px; right: auto; top: auto; bottom: -160px; opacity: .08; }

@media (prefers-reduced-motion: reduce) {
  .fr-finder .sp-table tbody tr { transition: none; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ 1. HERO (type hero, leaning-section motif; no client photo on file yet) ============ -->
<section class="hero hero--interior sp-hero fr-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="sp-hero__motif" aria-hidden="true">
    <svg viewBox="0 0 760 420" preserveAspectRatio="xMaxYMax slice" focusable="false">
      <defs>
        <pattern id="fr-boards" width="30" height="300" patternUnits="userSpaceOnUse">
          <rect x="2" y="0" width="25" height="300" fill="currentColor"/>
        </pattern>
      </defs>
      <!-- straight run -->
      <rect x="0" y="120" width="380" height="300" fill="url(#fr-boards)"/>
      <rect x="370" y="90" width="22" height="330" fill="currentColor"/>
      <!-- leaning section, pivoting at its base -->
      <g transform="rotate(9 392 420)">
        <rect x="392" y="120" width="340" height="300" fill="url(#fr-boards)"/>
        <rect x="722" y="90" width="22" height="330" fill="currentColor"/>
      </g>
      <rect x="0" y="414" width="760" height="6" fill="currentColor"/>
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
            <li><span aria-current="page">Fence Repair</span></li>
          </ol>
        </nav>
        <span class="eyebrow">Fence &amp; gate repair · Ennis &amp; Waxahachie, TX</span>
        <h1 class="hero-title" id="hero-title">Fence Repair in <span class="text-accent">Ennis &amp; Waxahachie</span>, TX</h1>
        <p class="hero-answer"><?php echo h($siteName); ?> repairs fences that are already standing around Ennis, Waxahachie and the towns within about <?php echo (int) $serviceRadiusMiles; ?> miles: leaning sections, broken boards and rails, storm damage, and gates that sag or no longer latch. Every repair starts at the posts, because a fence that leans almost always has a post problem underneath.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a repair estimate</button>
          <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
          <li><?php echo icon('wrench', 16); ?>Posts, boards, rails &amp; gates</li>
          <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Need a fence or gate repair priced?</h2>
        <p class="hero-form-tagline">Tell us what it's doing. <b>Ennis, Waxahachie &amp; nearby.</b></p>
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

<!-- ============ 2. SIGNATURE: symptom finder (real table) ============ -->
<section class="section fr-finder" aria-labelledby="finder-title">
  <div class="container-wide">
    <div class="sp-head reveal-up">
      <span class="eyebrow">Symptom finder</span>
      <h2 id="finder-title">What is wrong with my <span class="text-accent">fence</span>, and which fix does it usually need?</h2>
      <p class="answer-block">Most fence problems come from five causes: loose or rotted posts, a sagging gate post, failed rails or fasteners, storm damage, or soil lost under the fence. The symptom you can see from the yard usually points to the fix, so match what your fence is doing in the table below.</p>
    </div>

    <div class="sp-sheet reveal-up">
      <div class="sp-sheet__head"><span>Fence repair guide</span><b>What you see, what causes it, what fixes it</b></div>
      <div class="table-scroll" role="region" aria-label="Fence symptom, cause and repair table" tabindex="0">
        <table class="sp-table">
          <caption class="sr-only">Common fence and gate symptoms, their likely causes, the usual repair, and whether the fence can usually be repaired or may need rebuilding</caption>
          <thead>
            <tr><th scope="col">What you see</th><th scope="col">Likely cause</th><th scope="col">Usual fix</th><th scope="col">Outlook</th></tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row"><?php echo icon('fence', 22); ?>A section leans or waves out of line</th>
              <td>Posts working loose as clay ground swells in wet weather and pulls away in dry spells; on wood posts, rot right at the ground line</td>
              <td>Reset or replace the failed posts, then pull the panels back to a straight line</td>
              <td><span class="fr-tag">Repair</span></td>
            </tr>
            <tr>
              <th scope="row"><?php echo icon('home', 22); ?>The gate sags, drags or will not latch</th>
              <td>The hinge post tipping toward the weight of the gate, or the gate frame racked out of square</td>
              <td>Straighten or reset the hinge post, then square and brace the gate and line the latch back up</td>
              <td><span class="fr-tag">Repair</span></td>
            </tr>
            <tr>
              <th scope="row"><?php echo icon('hammer', 22); ?>Loose, cracked or missing boards</th>
              <td>Nails or screws backing out or rusting through, or a rail that has split along its length</td>
              <td>Refasten or replace the boards; swap out any split rails they hang from</td>
              <td><span class="fr-tag">Repair</span></td>
            </tr>
            <tr>
              <th scope="row"><?php echo icon('wind', 22); ?>A section blown down after a storm</th>
              <td>Straight-line wind snapping posts or levering them out of the ground</td>
              <td>Replace the broken posts and rehang or rebuild the panels between them</td>
              <td><span class="fr-tag fr-tag--watch">Repair or rebuild</span></td>
            </tr>
            <tr>
              <th scope="row"><?php echo icon('link', 22); ?>Chain link fabric loose or bowed</th>
              <td>Tension bands or the bottom tension wire loosened or broken, or a line post or top rail bent</td>
              <td>Retension the fabric and replace bent posts or rail sections</td>
              <td><span class="fr-tag">Repair</span></td>
            </tr>
            <tr>
              <th scope="row"><?php echo icon('footprints', 22); ?>A gap opening under the fence</th>
              <td>Soil settling or washing out along the line, or a dog digging at the same spot</td>
              <td>Fill and regrade the low spot, or close it off with a bottom board along the gap</td>
              <td><span class="fr-tag">Repair</span></td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="sp-sheet__foot">General guide only. What the posts look like at and just below the ground line decides the real fix for your fence.</p>
    </div>

    <div class="fr-finder__note reveal-up">
      <?php echo icon('info', 22); ?>
      <div>
        <p><strong>Why the ground line matters.</strong> A wood post rots fastest in the band just above and below the soil surface, where it stays damp longest. Push on a leaning section: if the post rocks in its hole, the post needs resetting; if it flexes at the soil, the wood has likely rotted through there.</p>
        <p>Ellis County's black clay makes this worse. It grips a post tightly while wet, then dries and cracks open around it, so a post that was snug in spring can wobble by late summer.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ 3. REPAIR OR REPLACE (dark band, torn edge) ============ -->
<section class="section fr-verdict texture-grain edge-torn-top" aria-labelledby="verdict-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div class="sp-head reveal-left">
      <span class="eyebrow">Repair or replace</span>
      <h2 id="verdict-title">Should I repair my fence or replace it?</h2>
      <p class="answer-block">Repair the fence when most posts are still solid and the damage is limited to a few sections, boards or a gate. Replace it when posts are rotted at the ground along much of the run, or when section after section leans. The posts decide it, not the boards.</p>
    </div>

    <div class="fr-verdict__cols">
      <div class="fr-col reveal-left reveal-delay-1">
        <h3><?php echo icon('wrench', 24); ?>Usually worth repairing</h3>
        <ul>
          <li>A handful of broken boards or pickets on an otherwise sound run</li>
          <li>One or two leaning posts in a fence that is straight everywhere else</li>
          <li>A gate that sags while its hinge post can be reset</li>
          <li>Storm damage limited to one or two sections</li>
          <li>Gray, weathered wood that is still firm (stain it rather than rebuild)</li>
        </ul>
      </div>
      <div class="fr-col fr-col--replace reveal-right reveal-delay-2">
        <h3><?php echo icon('hammer', 24); ?>Usually time to replace</h3>
        <ul>
          <li>Wood posts soft or rotted at the soil along much of the line</li>
          <li>Several sections leaning in different directions at once</li>
          <li>Rails splitting in bay after bay, not just one</li>
          <li>A repair that would replace most of the posts anyway</li>
        </ul>
      </div>
    </div>

    <div class="prose reveal-up">
      <p>An honest answer here saves money either way. One Google reviewer wrote that the crew told them plainly to stain the fence and hold off on repairs until after the next storm, instead of selling work the fence did not need yet. When the posts are gone, though, patching boards onto them only buys a season or two.</p>
      <p>If the verdict is replacement, the same visit can price <?php echo serviceLink('fence-installation', 'a new fence installation'); ?> on the existing line, and the <?php echo serviceLink('cedar-fence', 'cedar fence page'); ?> explains why many owners rebuild in cedar. You can also compare every option on the <a href="/services/">fence services overview</a>.</p>
    </div>
  </div>
</section>

<!-- ============ 4. THE REPAIR VISIT: included + process timeline ============ -->
<section class="section sp-scope fr-visit" aria-labelledby="visit-title">
  <div class="container">
    <div class="sp-scope__grid">
      <div class="sp-scope__aside reveal-right">
        <span class="eyebrow">On a repair visit</span>
        <h2 id="visit-title">What happens when <?php echo h($siteName); ?> comes out to repair a fence?</h2>
        <p class="answer-block">A fence repair visit starts with a look at the posts, the gate hardware and the ground along the damaged run. You get the price in writing before work begins, then posts are fixed first, rails and boards or fabric next, and the gate last.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span>Leaning or rotted posts reset or replaced</span></li>
          <li><?php echo icon('check', 18); ?><span>Broken boards, pickets and split rails replaced</span></li>
          <li><?php echo icon('check', 18); ?><span>Loose <?php echo serviceLink('chain-link', 'chain link'); ?> fabric retensioned, bent rail sections swapped</span></li>
          <li><?php echo icon('check', 18); ?><span>Gates squared, rehung and latched again</span></li>
          <li><?php echo icon('check', 18); ?><span>Storm-damaged sections rebuilt between sound posts</span></li>
          <li><?php echo icon('check', 18); ?><span>Gaps under the fence filled or closed off</span></li>
        </ul>
      </div>
      <div>
        <h3 class="sr-only">How a fence repair runs</h3>
        <ol class="sp-timeline">
          <li class="reveal-up">
            <h3>Tell us what the fence is doing</h3>
            <p>Call or send the form with the symptom, roughly how many sections or gates are involved, and the town the property is in.</p>
          </li>
          <li class="reveal-up">
            <h3>Check the posts before the boards</h3>
            <p>At the property, the damaged run is checked at and below the ground line, and the gate is swung and latched to find where it binds or drops.</p>
          </li>
          <li class="reveal-up">
            <h3>Price the fix in writing</h3>
            <p>You get the repair price before any work starts. If posts across the whole run are failing, you hear that too, along with what a rebuild would involve.</p>
          </li>
          <li class="reveal-up">
            <h3>Posts, then panels, then the gate</h3>
            <p>Failed posts are reset or replaced first, rails and boards or fabric go back on next, and the gate is hung and latched last so it closes on a post that will stay put.</p>
          </li>
        </ol>
      </div>

    </div>
  </div>
</section>

<!-- ============ 5. GATES (paper-2, parallelogram edge) ============ -->
<section class="section fr-gates edge-parallelogram-top" aria-labelledby="gates-title">
  <div class="container-wide">
    <div class="sp-signs__layout">
      <div class="sp-signs__intro reveal-left">
        <span class="eyebrow">Gate repair</span>
        <h2 id="gates-title">Why does a fence gate sag, drag or stop latching?</h2>
        <p class="answer-block">A gate sags because its weight levers the hinge post over, or because the gate frame has racked out of square. Either way the latch side drops, the bottom drags and the latch misses its catch. Fixing the post or squaring the frame usually brings the latch back.</p>
        <p class="pull-quote">A gate that will not latch is usually a post problem wearing a hardware costume.</p>
      </div>

      <ul class="sp-bento" aria-label="Common gate problems">
        <li class="reveal-up reveal-delay-1">
          <?php echo icon('fence', 26); ?>
          <h3>Hinge post leaning toward the opening</h3>
          <p>A wide gate hangs its whole weight off one post. In clay that dries and pulls away from that post, it tips toward the opening a little more each season. Resetting or replacing the hinge post is the real fix; moving the latch only hides the lean for a while.</p>
        </li>
        <li class="reveal-up reveal-delay-2">
          <?php echo icon('pencil-ruler', 26); ?>
          <h3>Frame racked out of square</h3>
          <p>A wood gate with no diagonal brace, or a brace running the wrong way, folds into a slant. A brace from the low hinge corner up to the high latch corner holds it square.</p>
        </li>
        <li class="reveal-up reveal-delay-3">
          <?php echo icon('wrench', 26); ?>
          <h3>Latch that no longer lines up</h3>
          <p>When the post and frame are both sound, a missed latch is often hardware that has worked loose and only needs resetting.</p>
        </li>
        <li class="reveal-up reveal-delay-1">
          <?php echo icon('mountain', 26); ?>
          <h3>Bottom edge catching the ground</h3>
          <p>Sometimes the post is fine and the yard is simply higher in the gate's swing. Trimming the grade or rehanging the gate higher clears it.</p>
        </li>
        <li class="reveal-up reveal-delay-2">
          <?php echo icon('route', 26); ?>
          <h3>Sliding and opener-driven gates</h3>
          <p>Tracks, rollers and openers add moving parts. One Google reviewer with a sliding gate wrote that when an issue came up, the crew came out the next day and fixed it. Planning a new gate instead? See <?php echo serviceLink('fence-installation', 'gate installation'); ?>.</p>
        </li>
      </ul>
    </div>
  </div>
</section>

<?php if ($frReviews): ?>
<!-- ============ 6. PROOF: real Google reviews (live feed, filtered to repairs and warranty work) ============ -->
<section class="section sp-proof fr-proof" aria-labelledby="proof-title">
  <div class="container">
    <div class="sp-head reveal-up">
      <span class="eyebrow">From Google reviews</span>
      <h2 id="proof-title">What do customers say about <?php echo h($siteName); ?> coming back to fix a fence?</h2>
      <p class="answer-block">Google reviewers describe <?php echo h($siteName); ?> returning to fix a fence instead of disappearing after the job. One had storm damage on a just-finished fence repaired at no charge as warranty work, and another had a gate issue fixed the next day. These reviews are shown exactly as written on Google.</p>
    </div>
    <div class="sp-quotes">
<?php foreach ($frReviews['reviews'] as $frRev): ?>
      <figure class="sp-quote reveal-up">
        <span class="review-stars" role="img" aria-label="<?php echo (int) $frRev['rating']; ?> out of 5 stars"><?php echo str_repeat(icon('star', 16), (int) $frRev['rating']); ?></span>
        <blockquote><p><?php echo nl2br(h($frRev['text'])); ?></p></blockquote>
        <figcaption><b><?php echo h($frRev['name']); ?></b><span>Google review · <?php echo h(p1_google_reviews_ago($frRev['date'] ?? '')); ?></span></figcaption>
      </figure>
<?php endforeach; ?>
    </div>
    <div class="sp-proof__foot">
<?php if ($frReviews['url'] !== ''): ?>
      <a href="<?php echo h($frReviews['url']); ?>" target="_blank" rel="noopener nofollow">Read all <?php echo (int) $frReviews['count']; ?> Google reviews ↗</a>
<?php endif; ?>
      <span>Had a fence fixed by us? <a href="<?php echo h($gbp['review_url']); ?>" target="_blank" rel="noopener nofollow">Leave a Google review</a>.</span>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ 7. FAQ (research-brief questions, repair-specific answers) ============ -->
<section class="section sp-faq fr-faq" aria-labelledby="faq-title">
  <div class="container-narrow">
    <div class="sp-head reveal-down">
      <span class="eyebrow">Fence repair questions</span>
      <h2 id="faq-title">What do Ennis and Waxahachie owners ask before a fence repair?</h2>
      <p class="answer-block">Owners weighing a fence repair in Ennis or Waxahachie usually ask three things: what the repair will cost, whether a warranty covers it, and which material saves them from repeat repairs. <?php echo h($siteName); ?> answers each below; call <?php echo phoneLink(); ?> about your own fence.</p>
    </div>
    <div class="faq-grid">
<?php foreach ($frFaqs as $frIdx => $frFaq): ?>
      <details class="faq"<?php echo $frIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo h($frFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo h($frFaq['a']); ?></p>
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
      <h2>Which other <span class="text-accent">fence services</span> come up during a repair?</h2>
      <p class="hero-answer">A repair visit often turns into one of three conversations: rebuilding a worn-out privacy run, choosing cedar for new boards, or replacing a fence that is past saving with a new installation and gates. <?php echo h($siteName); ?> handles each of them around Ennis, Waxahachie and the nearby towns.</p>
      <span class="section-subtitle">Privacy · Cedar · New fences &amp; gates</span>
    </div>
    <div class="services-grid">
<?php foreach ($frRelated as $frI => $frSlug):
        $frRel  = serviceBySlug($frSlug);
        $frCard = $frCards[$frSlug];
        $frTint = ($frI % 3) + 1; ?>
      <article class="service-card-with-image card-tint-<?php echo $frTint; ?> reveal-up reveal-delay-<?php echo $frTint; ?>">
        <div class="service-card__body">
          <div class="service-card__head">
            <div class="service-card__icon"><?php echo icon($frCard['icon'], 24); ?></div>
            <h3><?php echo h($frRel['name']); ?></h3>
          </div>
          <p class="service-card__desc"><?php echo h($frCard['desc']); ?></p>
          <ul>
<?php foreach ($frCard['bullets'] as $frBullet): ?>
            <li><?php echo h($frBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($frSlug); ?>/" class="service-card__cta">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <a class="btn btn-secondary sp-hub-link" href="/services/">View All Services →</a>
  </div>
</section>

<!-- ============ 8. FINAL CTA (wave edge) ============ -->
<section class="cta-banner texture-grain edge-wave-top sp-cta fr-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-copy reveal-scale">
      <span class="eyebrow">Fence repair estimate</span>
      <h2 id="cta-title">Need a leaning fence or sagging gate looked at?</h2>
      <p>Tell <?php echo h($siteName); ?> what the fence is doing, how many sections are affected and the town, and the office will set up a time to look at the posts.</p>
    </div>
    <div class="actions reveal-scale reveal-delay-2">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a Free Fence Repair Estimate</button>
      <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
