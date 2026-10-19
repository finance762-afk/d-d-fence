<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /services/cedar-fence/ — D & D Fence (Phase 4, 2026-10-19). Premium editorial service page (interactive-patterns §2.8).
 * No client photos on file: type hero with a wood-grain motif; the signature visual is the cedar finish strip
 * (fresh cut → weathered silver, or held by stain). Section order differs from the privacy page: the cedar vs pine
 * table comes first, proof sits before the scope. Proof is the live Google reviews feed (serviceReviews), never hard-coded.
 * Cedar grade, board size, post type and stain products are not in intake — see /content-confirmations.json.
 */
$svc             = serviceBySlug('cedar-fence');
$pageTitle       = 'Cedar Fences in Ennis & Waxahachie, TX | ' . $siteName;
$pageDescription = 'Cedar fences by D & D Fence in Ennis, Waxahachie and nearby Ellis County towns: how cedar compares with pine, natural or stained finish. Call (469) 321-7783.';
$canonicalUrl    = $siteUrl . '/services/cedar-fence/';
$ogImage         = defaultOgImage();
$currentPage     = 'services';
$pageType        = 'service';
$serviceSlug     = 'cedar-fence';

$cfFaqs = [
    ['q' => 'How much does a cedar fence cost compared with a pine fence?',
     'a' => 'Cedar costs more per board than pressure-treated pine, so a cedar fence prices higher for the same length and height. The total also depends on the run, the gates, the ground and any old fence removal. D & D Fence measures on site and lists cedar materials and labor in a written estimate.'],
    ['q' => 'How long does a cedar fence last in North Texas?',
     'a' => 'A cedar fence lasts longest when the posts stay solid and the boards are kept stained or sealed. Cedar resists rot and insects better than most wood, but Texas sun and wet clay still wear on it. Re-coating the boards from time to time and fixing a loose post early add the most years.'],
    ['q' => 'Will my HOA approve a cedar fence and stain color?',
     'a' => 'Most HOAs around Ennis and Waxahachie allow cedar, but many set the height, the board style and an approved list of stain colors. Get the color approved before the stain goes on. D & D Fence can check the rules that apply to your address before the estimate is final.'],
    ['q' => 'How long does it take to install a cedar fence?',
     'a' => 'A typical residential cedar fence goes up in one to three days, depending on its length, the ground and the weather. If you want it stained, plan on that step coming after the build, once the boards are ready to take the finish.'],
];

$schemaMarkup = servicePageSchema(
    $svc,
    'Cedar Fence Installation in Ennis & Waxahachie, TX',
    'Cedar fence installation by D & D Fence in Ennis, Waxahachie and the surrounding Ellis County area: cedar privacy and backyard fences, gates, old fence removal, and natural or stained finishes.',
    generateFAQSchema($cfFaqs),
    ['serviceType' => 'Cedar fence installation']
);

$cfReviews = serviceReviews('stain|cedar|wood|materials|sturdy', 3);
$cfCards   = serviceCards();
$cfRelated = ['privacy-fence', 'fence-repair', 'fence-installation'];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?>

/* ==========================================================================
   Cedar fence — page-specific composition: wood-grain hero motif, cedar vs pine table up front,
   finish strip (signature, dark band), proof before scope, stained-board accents. Tokens only.
   Local tones: cedar = accent mixed toward paper; weathered = secondary mixed toward paper.
   ========================================================================== */
.cf-page {
  --cf-cedar: color-mix(in srgb, var(--color-accent) 62%, var(--color-paper));
  --cf-cedar-deep: color-mix(in srgb, var(--color-accent) 70%, var(--color-dark));
  --cf-honey: color-mix(in srgb, var(--color-warning) 55%, var(--color-accent) 25%);
  --cf-silver: color-mix(in srgb, var(--color-secondary) 45%, var(--color-paper));
}
.cf-hero .sp-hero__motif { color: var(--color-accent-bright); opacity: .09; width: min(60%, 780px); }
.cf-hero::before { inset: -20% auto auto -15%; width: 70%; }

/* Comparison first: paper band, table leads, copy follows */
.cf-compare { background: var(--color-paper); }
.cf-compare .cf-compare__grid { display: grid; grid-template-columns: minmax(0, 1.45fr) minmax(0, .85fr); gap: clamp(2rem, 5vw, 4rem); align-items: start; }
.cf-compare .sp-head { position: sticky; top: calc(var(--nav-height) + var(--space-6)); margin-bottom: 0; }
.cf-compare .sp-table thead th:nth-child(2) { color: var(--cf-cedar-deep); }
.cf-compare .sp-table thead th:nth-child(2)::before {
  content: "";
  display: inline-block;
  width: 10px;
  height: 10px;
  margin-right: var(--space-2);
  border-radius: 2px;
  background: var(--cf-cedar);
  vertical-align: baseline;
}
.cf-compare .sp-table thead th:nth-child(3)::before {
  content: "";
  display: inline-block;
  width: 10px;
  height: 10px;
  margin-right: var(--space-2);
  border-radius: 2px;
  background: color-mix(in srgb, var(--color-success) 40%, var(--color-warning) 30%);
  vertical-align: baseline;
}
.cf-compare .sp-table tbody th { width: 22%; }
.cf-compare .sp-table tbody td:nth-of-type(1) { background: color-mix(in srgb, var(--color-accent) 4%, transparent); }
.cf-compare .sp-sheet { border-top: 6px solid var(--cf-cedar); }
@media (max-width: 960px) {
  .cf-compare .cf-compare__grid { grid-template-columns: 1fr; }
  .cf-compare .sp-head { position: static; order: -1; }
}

/* Signature: finish strip */
.cf-finish .cf-finish__head { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: clamp(2rem, 5vw, 4rem); align-items: end; margin-bottom: clamp(2rem, 4vw, 3rem); }
.cf-finish .answer-block {
  margin: 0;
  background: color-mix(in srgb, var(--color-white) 6%, transparent);
  border-left-color: var(--color-accent-bright);
  color: color-mix(in srgb, var(--color-white) 90%, transparent);
}
.cf-strip { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 0; margin: 0; padding: 0; list-style: none; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-lg); }
.cf-strip > li { position: relative; display: grid; grid-template-rows: 150px auto; background: var(--color-surface); color: var(--color-ink); }
.cf-strip > li + li { border-left: 1px solid var(--color-line); }
.cf-swatch { position: relative; overflow: hidden; }
.cf-swatch::after {
  content: "";
  position: absolute;
  inset: 0;
  opacity: .35;
  background: repeating-linear-gradient(92deg, transparent 0 9px, color-mix(in srgb, var(--color-dark) 22%, transparent) 9px 10px, transparent 10px 23px, color-mix(in srgb, var(--color-dark) 14%, transparent) 23px 24px);
}
.cf-swatch--fresh { background: linear-gradient(180deg, var(--cf-cedar) 0%, color-mix(in srgb, var(--cf-cedar) 80%, var(--color-paper)) 100%); }
.cf-swatch--sun { background: linear-gradient(180deg, color-mix(in srgb, var(--cf-cedar) 55%, var(--cf-silver)) 0%, color-mix(in srgb, var(--cf-cedar) 35%, var(--cf-silver)) 100%); }
.cf-swatch--silver { background: linear-gradient(180deg, var(--cf-silver) 0%, color-mix(in srgb, var(--cf-silver) 75%, var(--color-paper)) 100%); }
.cf-swatch--stain { background: linear-gradient(180deg, var(--cf-cedar-deep) 0%, color-mix(in srgb, var(--cf-cedar-deep) 80%, var(--cf-cedar)) 100%); }
.cf-swatch--stain::before {
  content: "";
  position: absolute;
  inset: 0;
  z-index: 1;
  background: linear-gradient(115deg, transparent 30%, color-mix(in srgb, var(--color-white) 22%, transparent) 45%, transparent 60%);
}
.cf-strip__body { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-5) var(--space-5) var(--space-6); }
.cf-strip__body span { font-family: var(--font-accent); font-weight: 700; font-size: var(--fs-eyebrow); letter-spacing: .14em; text-transform: uppercase; color: var(--color-accent-dark); }
.cf-strip .cf-strip__body h3 { font-size: 1.08rem; color: var(--color-ink); }
.texture-grain .cf-strip__body p { margin: 0; font-size: .92rem; color: var(--color-ink-2); }
.cf-strip > li:last-child { outline: 3px solid var(--color-accent); outline-offset: -3px; }
.cf-finish__note { margin: var(--space-6) 0 0; max-width: 70ch; font-size: .95rem; }
@media (max-width: 960px) {
  .cf-finish .cf-finish__head { grid-template-columns: 1fr; }
  .cf-strip { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .cf-strip > li:nth-child(3) { border-left: 0; }
  .cf-strip > li:nth-child(n + 3) { border-top: 1px solid var(--color-line); }
}
@media (max-width: 520px) {
  .cf-strip { grid-template-columns: 1fr; }
  .cf-strip > li { grid-template-rows: 96px auto; }
  .cf-strip > li + li { border-left: 0; border-top: 1px solid var(--color-line); }
}

/* Proof (white) and scope (paper) swap their default backgrounds */
.cf-proof { background: var(--color-surface); }
.cf-proof .sp-quote { border-top: 4px solid var(--cf-cedar); }
.cf-scope { background: var(--color-paper); }
.cf-scope .sp-included { background: var(--color-surface); border-style: solid; border-left: 6px solid var(--cf-cedar); }
.cf-scope .sp-timeline > li::before { border-color: var(--cf-cedar-deep); }

/* Expert band: wave top, figure on the left this time */
.cf-expert .sp-expert__grid { grid-template-columns: minmax(0, 1fr) minmax(0, 1.5fr); }
.cf-expert .sp-figure { border-color: color-mix(in srgb, var(--color-accent) 40%, transparent); }
.cf-expert .sp-figure b span { font-size: .45em; }
.cf-expert .floating-ring { right: -120px; top: -100px; }
@media (max-width: 900px) {
  .cf-expert .sp-expert__grid { grid-template-columns: 1fr; }
  .cf-expert .cf-expert__copy { order: -1; }
}

.cf-faq .faq summary::before { content: ""; flex: 0 0 auto; width: 8px; height: 22px; margin-right: var(--space-3); border-radius: 2px; background: var(--cf-cedar); }
.cf-faq .faq summary { justify-content: flex-start; }
.cf-faq .faq summary::after { margin-left: auto; }

.cf-cta .floating-ring { opacity: .07; }

@media (prefers-reduced-motion: reduce) {
  .cf-swatch--stain::before { display: none; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>
<div class="cf-page">

<!-- ============ 1. HERO (type hero, wood-grain motif; no client photo on file yet) ============ -->
<section class="hero hero--interior sp-hero cf-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="sp-hero__motif" aria-hidden="true">
    <svg viewBox="0 0 720 420" preserveAspectRatio="xMaxYMid slice" fill="none" stroke="currentColor" stroke-width="1.4" focusable="false">
<?php for ($cfG = 0; $cfG < 15; $cfG++): $cfX = 20 + $cfG * 48; ?>
      <path d="M<?php echo $cfX; ?> 0 C <?php echo $cfX + 18; ?> 70, <?php echo $cfX - 14; ?> 140, <?php echo $cfX + 6; ?> 210 S <?php echo $cfX - 10; ?> 350, <?php echo $cfX + 12; ?> 420"/>
      <path d="M<?php echo $cfX + 16; ?> 0 C <?php echo $cfX + 30; ?> 90, <?php echo $cfX + 2; ?> 160, <?php echo $cfX + 22; ?> 240 S <?php echo $cfX + 8; ?> 360, <?php echo $cfX + 26; ?> 420"/>
<?php endfor; ?>
      <ellipse cx="236" cy="150" rx="9" ry="22"/><ellipse cx="236" cy="150" rx="4" ry="11"/>
      <ellipse cx="524" cy="300" rx="10" ry="25"/><ellipse cx="524" cy="300" rx="4" ry="12"/>
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
            <li><span aria-current="page">Cedar Fence</span></li>
          </ol>
        </nav>
        <span class="eyebrow">Cedar fencing · Ennis &amp; Waxahachie, TX</span>
        <h1 class="hero-title" id="hero-title">Cedar Fence Installation in <span class="text-accent">Ennis &amp; Waxahachie</span>, TX</h1>
        <p class="hero-answer"><?php echo h($siteName); ?> installs cedar wood fences for homes in Ennis, Waxahachie and nearby towns within about <?php echo (int) $serviceRadiusMiles; ?> miles. Cedar resists rot without chemical treatment, stays straighter than pine as it dries, and can be left to weather silver or stained to hold its warm red-brown color.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
          <li><?php echo icon('paint-bucket', 16); ?>Natural or stained finish</li>
          <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title">Want a free cedar fence estimate?</h2>
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

<!-- ============ 2. COMPARISON FIRST: cedar vs pressure-treated pine (real table) ============ -->
<section class="section sp-compare cf-compare" aria-labelledby="compare-title">
  <div class="container-wide">
    <div class="cf-compare__grid">
      <div class="sp-sheet reveal-left">
        <div class="sp-sheet__head"><span>Wood guide</span><b>Cedar and pressure-treated pine, line by line</b></div>
        <div class="table-scroll" role="region" aria-label="Cedar versus pressure-treated pine comparison" tabindex="0">
          <table class="sp-table">
            <caption class="sr-only">Comparison of cedar and pressure-treated pine fence boards by rot resistance, movement, weight, look, staining and relative cost</caption>
            <thead>
              <tr><th scope="col">What matters</th><th scope="col">Cedar</th><th scope="col">Pressure-treated pine</th></tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">Rot and insects<small>Where the protection comes from</small></th>
                <td>Natural oils and tannins in the wood itself</td>
                <td>Chemical preservative pressed into the wood at the mill</td>
              </tr>
              <tr>
                <th scope="row">Movement<small>As boards dry in the sun</small></th>
                <td>Stays fairly flat and straight; less cupping and twisting</td>
                <td>Often arrives wet from treatment, so it can shrink, cup or twist as it dries</td>
              </tr>
              <tr>
                <th scope="row">Weight<small>Per board</small></th>
                <td>Light, which puts less dead load on the posts</td>
                <td>Heavier, especially while still wet</td>
              </tr>
              <tr>
                <th scope="row">Look<small>Out of the bundle</small></th>
                <td>Warm red-brown to tan, with a cedar smell</td>
                <td>Pale yellow with a green or brown tint from treatment</td>
              </tr>
              <tr>
                <th scope="row">Stain<small>When it can take a finish</small></th>
                <td>Once the surface is dry; generally sooner than pine</td>
                <td>Only after the treatment moisture dries out, which takes longer</td>
              </tr>
              <tr>
                <th scope="row">Material cost<small>Relative</small></th>
                <td>Higher</td>
                <td>Lower</td>
              </tr>
            </tbody>
          </table>
        </div>
        <p class="sp-sheet__foot">General properties of the two woods. Below ground, treated wood or steel is often used for posts even on a cedar fence, because constant soil moisture is hard on any untreated wood.</p>
      </div>

      <div class="sp-head reveal-right">
        <span class="eyebrow">Cedar or pine?</span>
        <h2 id="compare-title">Is a cedar fence worth the extra cost over pressure-treated pine?</h2>
        <p class="answer-block">A cedar fence is worth the extra cost when you want boards that stay straight and look good with little fuss. Pine costs less up front, but treated boards often shrink, cup or twist as they dry, and they take stain later than cedar does.</p>
        <p>The difference shows most along a long, sunny run. In an Ellis County summer the south face of a fence bakes all afternoon, and a pine board that twists pulls its fasteners and opens a gap. Cedar moves less, so the fence line holds its shape.</p>
        <p>If budget decides it, pine still builds a sound fence. The question to settle at the estimate is how you want the fence to look in a few summers, not just on the day it goes up.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ 3. SIGNATURE: the cedar finish strip (dark band, slant top) ============ -->
<section class="section cf-finish texture-grain slant-top" aria-labelledby="finish-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container">
    <div class="cf-finish__head">
      <div class="reveal-left">
        <span class="eyebrow">Color over time</span>
        <h2 id="finish-title">What happens to cedar's color if you leave it bare instead of staining it?</h2>
      </div>
      <p class="answer-block reveal-right">Bare cedar starts red-brown, fades as the sun works on it, and settles into a soft silver-gray. That gray is surface color, not rot. Stain or sealer holds the warm tone instead, but it needs a fresh coat from time to time to keep it.</p>
    </div>

    <ol class="cf-strip" aria-label="How a cedar fence changes color">
      <li class="reveal-up reveal-delay-1">
        <div class="cf-swatch cf-swatch--fresh" aria-hidden="true"></div>
        <div class="cf-strip__body">
          <span>Install day</span>
          <h3>Fresh-cut cedar</h3>
          <p>Red-brown to tan boards, with color shifting from board to board the way natural wood does.</p>
        </div>
      </li>
      <li class="reveal-up reveal-delay-2">
        <div class="cf-swatch cf-swatch--sun" aria-hidden="true"></div>
        <div class="cf-strip__body">
          <span>First hot summer</span>
          <h3>Sun-faded</h3>
          <p>UV light bleaches the surface first, so the side facing south and west lightens fastest.</p>
        </div>
      </li>
      <li class="reveal-up reveal-delay-3">
        <div class="cf-swatch cf-swatch--silver" aria-hidden="true"></div>
        <div class="cf-strip__body">
          <span>Left bare</span>
          <h3>Weathered silver</h3>
          <p>An even silver-gray that many owners like; the wood underneath keeps its natural rot resistance.</p>
        </div>
      </li>
      <li class="reveal-up reveal-delay-4">
        <div class="cf-swatch cf-swatch--stain" aria-hidden="true"></div>
        <div class="cf-strip__body">
          <span>Stained or sealed</span>
          <h3>Color held</h3>
          <p>A tinted stain or sealer keeps the warm tone and slows water uptake; plan on re-coating as it wears.</p>
        </div>
      </li>
    </ol>
    <p class="cf-finish__note">Already have a gray cedar fence with a few loose boards? A Google reviewer said <?php echo h($siteName); ?> honestly told them to just stain their existing fence and hold off on replacing it. When the boards are sound, <?php echo serviceLink('fence-repair', 'a repair and a fresh finish'); ?> is often the better spend.</p>
  </div>
</section>

<?php if ($cfReviews): ?>
<!-- ============ 4. PROOF: real Google reviews (live feed, filtered to stain / wood / materials) ============ -->
<section class="section sp-proof cf-proof" aria-labelledby="proof-title">
  <div class="container">
    <div class="sp-head sp-head--center reveal-up">
      <span class="eyebrow">From Google reviews</span>
      <h2 id="proof-title">What do customers say about the wood fences <?php echo h($siteName); ?> builds?</h2>
      <p class="answer-block">Customers on Google describe <?php echo h($siteName); ?> fences as sturdy and straight, built from quality materials, and finished with a stain they were proud of. One compared several quotes and found the best price. The reviews here come from the company's Google Business Profile, word for word.</p>
    </div>
    <div class="sp-quotes">
<?php foreach ($cfReviews['reviews'] as $cfRev): ?>
      <figure class="sp-quote reveal-up">
        <span class="review-stars" role="img" aria-label="<?php echo (int) $cfRev['rating']; ?> out of 5 stars"><?php echo str_repeat(icon('star', 16), (int) $cfRev['rating']); ?></span>
        <blockquote><p><?php echo nl2br(h($cfRev['text'])); ?></p></blockquote>
        <figcaption><b><?php echo h($cfRev['name']); ?></b><span>Google review · <?php echo h(p1_google_reviews_ago($cfRev['date'] ?? '')); ?></span></figcaption>
      </figure>
<?php endforeach; ?>
    </div>
    <div class="sp-proof__foot">
<?php if ($cfReviews['url'] !== ''): ?>
      <a href="<?php echo h($cfReviews['url']); ?>" target="_blank" rel="noopener nofollow">Read all <?php echo (int) $cfReviews['count']; ?> Google reviews ↗</a>
<?php endif; ?>
      <span>Had a fence built by us? <a href="<?php echo h($gbp['review_url']); ?>" target="_blank" rel="noopener nofollow">Leave a Google review</a>.</span>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ============ 5. SERVICE BREAKDOWN: included + process timeline ============ -->
<section class="section sp-scope cf-scope" aria-labelledby="scope-title">
  <div class="container">
    <div class="sp-scope__grid">
      <div class="sp-scope__aside reveal-left">
        <span class="eyebrow">The cedar job, start to finish</span>
        <h2 id="scope-title">What does a cedar fence installation from <?php echo h($siteName); ?> include?</h2>
        <p class="answer-block">A cedar fence installation includes measuring the run, setting the posts, hanging rails and cedar boards, building any gates, and hauling off an old fence it replaces. You choose a natural or stained finish, and the written estimate spells out the materials and labor.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span>A site visit to measure the run and talk through height</span></li>
          <li><?php echo icon('check', 18); ?><span>Fence placement matched to your plat or survey</span></li>
          <li><?php echo icon('check', 18); ?><span>Posts, rails and cedar boards for the full run</span></li>
          <li><?php echo icon('check', 18); ?><span>Walk gates or a wider gate for a mower or trailer</span></li>
          <li><?php echo icon('check', 18); ?><span>Tear-out of the old fence when cedar replaces it</span></li>
          <li><?php echo icon('check', 18); ?><span>Natural cedar or a stained finish, your call</span></li>
        </ul>
        <p class="footnote">Planning a tall backyard screen? The <?php echo serviceLink('privacy-fence', 'privacy fence guide'); ?> covers heights and board layouts. Comparing every option? See <a class="sp-link" href="/services/">the full list of fence services</a>.</p>
      </div>

      <div>
        <h3 class="sr-only">How a cedar fence job runs</h3>
        <ol class="sp-timeline">
          <li class="reveal-up">
            <h3>Measure and choose the finish</h3>
            <p>The visit covers the length of the run, the height, where gates go and whether you want the cedar left natural or stained. Settling the finish now keeps the estimate complete.</p>
          </li>
          <li class="reveal-up">
            <h3>Confirm the line and the rules</h3>
            <p>The plat or survey fixes where the fence goes. If an HOA governs your street, its height and stain color rules get checked before any material is ordered.</p>
          </li>
          <li class="reveal-up">
            <h3>Locate utilities, set posts</h3>
            <p>Buried lines are marked before digging, then posts are set along a straight string line. The posts carry the cedar, so they get set first and set right.</p>
          </li>
          <li class="reveal-up">
            <h3>Hang rails and cedar boards</h3>
            <p>Rails run between the posts and the cedar boards go on last, kept even across the top and close to the ground along the bottom.</p>
          </li>
          <li class="reveal-up">
            <h3>Stain, if you chose it</h3>
            <p>A stained fence gets its finish once the boards are ready to take it. Left natural, the cedar starts its slow fade toward silver from day one.</p>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 6. EXPERT POSITIONING (dark band, wave top) ============ -->
<section class="section sp-expert cf-expert texture-grain edge-wave-top" aria-labelledby="expert-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div class="sp-expert__grid">
      <div class="reveal-left">
        <div class="sp-figure">
          <b>90<span>+ ft</span></b>
          <span>of stained fence with a sliding gate, built in a matter of days for one Google reviewer</span>
        </div>
        <ul class="sp-points">
          <li><?php echo icon('paint-bucket', 22); ?><span><strong>Stained to finish.</strong> That reviewer called the result "beautifully stained."</span></li>
          <li><?php echo icon('ruler', 22); ?><span><strong>Straight and sturdy.</strong> Another reviewer described the fence as sturdy and straight, with the job site kept clean.</span></li>
          <li><?php echo icon('award', 22); ?><span><strong>Materials people notice.</strong> One customer says other construction companies compliment the fence's height and materials.</span></li>
          <li><?php echo icon('thumbs-up', 22); ?><span><strong>Priced to compete.</strong> A reviewer who collected several quotes said <?php echo h($siteName); ?> came in with the best price.</span></li>
        </ul>
      </div>
      <div class="cf-expert__copy reveal-right">
        <span class="eyebrow">Why cedar is a craft job</span>
        <h2 id="expert-title">Why does the build quality of a cedar fence matter as much as the wood?</h2>
        <p class="answer-block">Build quality matters because good cedar on a weak frame still fails. Boards fastened unevenly, posts out of line or a gate hung without support will sag or gap no matter how good the wood is. The care in the build decides how long the cedar looks right.</p>
        <div class="prose">
          <p>Cedar is the softer of the two common fence woods, which is part of why it stays flat, and also why fasteners and spacing matter. Boards need room to move a little with humidity and still sit tight against the rails. Gates are the hardest-working part of any wood fence, so they get the most bracing.</p>
          <p>Ground matters too. The Blackland clay under Ennis and Waxahachie swells when wet and pulls back in drought, and that slow push shows up first at the posts. If an older cedar fence on your lot has started to lean, that is usually where to look, and it is often fixable without new boards. For a brand-new run with gates or across acreage, <?php echo serviceLink('fence-installation', 'fence and gate installation'); ?> covers the layout side in more detail.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ 7. FAQ (research-brief questions, cedar-specific answers) ============ -->
<section class="section sp-faq cf-faq" aria-labelledby="faq-title">
  <div class="container-narrow">
    <div class="sp-head reveal-down">
      <span class="eyebrow">Cedar fence questions</span>
      <h2 id="faq-title">What do homeowners ask before choosing a cedar fence?</h2>
      <p class="answer-block">Homeowners choosing a cedar fence in Ennis or Waxahachie mostly ask about price against pine, how long cedar lasts here, HOA stain colors and how long installation takes. <?php echo h($siteName); ?> answers each below; call <?php echo phoneLink(); ?> for questions about your own yard.</p>
    </div>
    <div class="faq-grid">
<?php foreach ($cfFaqs as $cfIdx => $cfFaq): ?>
      <details class="faq"<?php echo $cfIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo h($cfFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo h($cfFaq['a']); ?></p>
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
      <h2>What other <span class="text-accent">fence work</span> do cedar fence owners ask about?</h2>
      <p class="hero-answer">Cedar fence owners usually ask about three related jobs: a full-height privacy layout for the backyard, repairs to an older fence that has started to lean, and new runs with gates on larger properties. <?php echo h($siteName); ?> builds and repairs all three in Ennis, Waxahachie and nearby.</p>
      <span class="section-subtitle">Privacy · Repairs · New runs &amp; gates</span>
    </div>
    <div class="services-grid">
<?php foreach ($cfRelated as $cfI => $cfSlug):
        $cfRel  = serviceBySlug($cfSlug);
        $cfCard = $cfCards[$cfSlug];
        $cfTint = ($cfI % 3) + 1; ?>
      <article class="service-card-with-image card-tint-<?php echo $cfTint; ?> reveal-up reveal-delay-<?php echo $cfTint; ?>">
        <div class="service-card__body">
          <div class="service-card__head">
            <div class="service-card__icon"><?php echo icon($cfCard['icon'], 24); ?></div>
            <h3><?php echo h($cfRel['name']); ?></h3>
          </div>
          <p class="service-card__desc"><?php echo h($cfCard['desc']); ?></p>
          <ul>
<?php foreach ($cfCard['bullets'] as $cfBullet): ?>
            <li><?php echo h($cfBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($cfSlug); ?>/" class="service-card__cta">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
    <a class="btn btn-secondary sp-hub-link" href="/services/">View All Services →</a>
  </div>
</section>

<!-- ============ 8. FINAL CTA ============ -->
<section class="cta-banner texture-grain edge-parallelogram-top sp-cta cf-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-copy reveal-scale">
      <span class="eyebrow">Cedar fence estimate</span>
      <h2 id="cta-title">Ready to see what a cedar fence would cost for your yard?</h2>
      <p>Tell <?php echo h($siteName); ?> the rough length, the height and whether you want it stained, and a time gets set to measure the run.</p>
    </div>
    <div class="actions reveal-scale reveal-delay-2">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a Free Cedar Fence Estimate</button>
      <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
    </div>
  </div>
</section>

</div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
