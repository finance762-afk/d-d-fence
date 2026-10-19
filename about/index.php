<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /about/ — About D & D Fence (Phase 5, 2026-10-19).
 * No client photos exist (build-plan assets.images is empty), so the story split carries an inline-SVG plan drawing of a fence line
 * instead of a photo — swap in a real job-site photo when the photo gate clears. Every fact here is in build-plan.json / config.php or
 * already live on the homepage; no founding story, crew size, licence, insurance or certification is invented (none is in intake).
 * Credentials block therefore points to the Google Business Profile reviews, the one verifiable record. Questions for the owner: /content-confirmations.json.
 * Section order: hero → story + plan drawing → cta-band (mid-page form) → approach cards → facts band (dark) → Google proof → closing CTA.
 */
$pageTitle       = 'About ' . $siteName . ' | Fence Contractor in Ennis & Waxahachie, TX';
$pageDescription = $siteName . ' is a fence contractor owned by ' . $ownerName . ', building and repairing privacy, cedar, chain link and wrought iron fences near Ennis and Waxahachie.';
$canonicalUrl    = $siteUrl . '/about/';
$ogImage         = defaultOgImage();
$currentPage     = 'about';
$pageType        = 'about';

$abYears = (int) $yearsInBusiness;

$abApproach = [
    ['icon' => 'ruler',          'tint' => 1, 'title' => 'Measure before quoting',
     'text' => $siteName . ' walks and measures the fence line first, noting the ground, the gate spots and any old fence that has to come out, so the quote matches the actual run.'],
    ['icon' => 'clipboard-list', 'tint' => 2, 'title' => 'Price it in writing',
     'text' => 'The quote comes back in writing, with the materials and labor for the run, before any work starts. The estimate itself is free.'],
    ['icon' => 'map-pin',        'tint' => 3, 'title' => 'Settle the line and the rules',
     'text' => 'The property line is confirmed from your plat or survey, and city and HOA rules are checked, before any post hole is dug.'],
    ['icon' => 'hammer',         'tint' => 'neutral', 'title' => 'Treat the post as the fence',
     'text' => 'Blackland clay swells and shrinks, so a leaning section is usually a post problem. Posts get the attention first, then rails and boards.'],
];

$abFacts = [
    [$abYears . ' years', 'building and repairing fences around Ennis and Waxahachie'],
    [count($services) . ' services', 'four fence types, fence repair and new installation'],
    [(int) $serviceRadiusMiles . ' miles', 'service radius around Ennis and Waxahachie'],
    ['Mon–Fri', '7 AM to 6 PM, closed Saturday and Sunday'],
];

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
$abReviews = p1_google_reviews($slug, ['heading' => '', 'limit' => 6]);

$abBase   = rtrim($siteUrl, '/');
$abCrumbs = generateBreadcrumbSchema([['name' => 'Home', 'url' => '/'], ['name' => 'About', 'url' => '/about/']]);
unset($abCrumbs['@context']);
$abCrumbs['@id'] = $canonicalUrl . '#breadcrumb';
$schemaMarkup = ['@context' => 'https://schema.org', '@graph' => [
    ['@type' => 'AboutPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => 'About ' . $siteName, 'description' => $pageDescription,
     'isPartOf' => ['@id' => $abBase . '/#website'], 'about' => ['@id' => $abBase . '/#organization'], 'breadcrumb' => ['@id' => $abCrumbs['@id']],
     'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']]],
    ['@type' => 'Person', '@id' => $abBase . '/#owner', 'name' => $ownerName, 'jobTitle' => 'Owner', 'worksFor' => ['@id' => $abBase . '/#organization']],
    $abCrumbs,
]];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   /about/ — page-specific composition (D & D Fence, rustic, no photos yet).
   Type hero, story + plan drawing (asymmetric), approach cards, dark facts band, Google proof, closing CTA. Tokens only (var()).
   ========================================================================== */

/* ---------- Hero ---------- */
.ab-hero {
  background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 125%);
  padding-bottom: clamp(2.5rem, 5vw, 3.75rem);
}
.ab-hero::before {
  content: "";
  position: absolute;
  inset: -30% -10% auto 45%;
  height: 140%;
  z-index: -1;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 72%);
  pointer-events: none;
}
.ab-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  opacity: .07;
  pointer-events: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='g'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23g)'/%3E%3C/svg%3E");
}
.ab-hero .breadcrumb { align-items: center; color: color-mix(in srgb, var(--color-white) 62%, transparent); margin-bottom: var(--space-2); }
.ab-hero .breadcrumb a:hover { color: var(--color-white); }
.ab-hero .breadcrumb [aria-current] { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.ab-hero .hero-copy { display: grid; gap: var(--space-4); max-width: 46rem; }
.ab-hero .hero-title { color: var(--color-white); text-wrap: balance; }
.ab-hero .hero-title .text-accent { color: var(--color-accent-bright); }
.ab-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); text-wrap: pretty; max-width: 42rem; }
.ab-hero .hero-chips li { background: color-mix(in srgb, var(--color-white) 7%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.ab-hero .hero-chips svg { color: var(--color-accent-bright); }
.ab-hero .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.ab-hero .link-call svg { color: var(--color-accent-bright); }
.ab-hero .link-call:hover { color: var(--color-white); }

/* ---------- Story: asymmetric split, copy + plan drawing ---------- */
.ab-story { background: var(--color-surface); }
.ab-story__grid { display: grid; grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr); gap: clamp(2.5rem, 6vw, 6rem); align-items: start; }
.ab-story__copy { display: grid; gap: var(--space-4); }
.ab-story__copy h2 { text-wrap: balance; }
.ab-story__copy p { margin: 0; color: var(--color-ink-2); max-width: 62ch; }
.ab-story__copy a { color: var(--color-primary); font-weight: 600; text-decoration: underline; text-underline-offset: .18em; }
.ab-story__copy .answer-block { color: var(--color-ink); }
.ab-story__fig { position: relative; margin: var(--space-10) 0 0; }
.ab-story__fig::before { content: ""; position: absolute; inset: -1rem 1rem 1rem -1rem; border: 2px solid var(--color-accent); opacity: .5; border-radius: var(--radius-lg); }
.ab-plan { position: relative; display: grid; gap: var(--space-3); padding: var(--space-4); border-radius: var(--radius-lg); background: var(--color-paper); border: 1px solid var(--color-line); box-shadow: var(--shadow-lg); }
.ab-plan figcaption { font-size: .88rem; color: var(--color-ink-2); line-height: 1.45; }
.ab-plan svg { width: 100%; height: auto; display: block; }
.ab-plan .grid-line { stroke: color-mix(in srgb, var(--color-ink) 7%, transparent); stroke-width: 1; }
.ab-plan .lot { fill: color-mix(in srgb, var(--color-primary) 5%, transparent); stroke: var(--color-secondary); stroke-width: 1.5; stroke-dasharray: 6 5; }
.ab-plan .house { fill: var(--color-paper-2); stroke: var(--color-ink-2); stroke-width: 2; }
.ab-plan .rail { fill: none; stroke: var(--color-primary); stroke-width: 5; stroke-linejoin: round; }
.ab-plan .post { fill: var(--color-surface); stroke: var(--color-primary); stroke-width: 3; }
.ab-plan .post--gate { fill: var(--color-accent); stroke: var(--color-accent-dark); }
.ab-plan .swing { fill: none; stroke: var(--color-accent-dark); stroke-width: 2; stroke-dasharray: 4 4; }
.ab-plan .leader { fill: none; stroke: var(--color-ink-2); stroke-width: 1; }
.ab-plan .label { font-family: var(--font-accent); font-weight: 700; font-size: 12px; letter-spacing: .12em; fill: var(--color-ink-2); }
.ab-plan .label--accent { fill: var(--color-accent-dark); }
.ab-stat-card { position: relative; z-index: 2; width: fit-content; margin: var(--space-5) 0 0 calc(-1 * var(--space-5)); display: grid; gap: var(--space-1); padding: .9rem 1.1rem; background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius); box-shadow: var(--shadow-lg); max-width: 15rem; }
.ab-stat-card b { font-family: var(--font-accent); font-size: 2.2rem; line-height: 1; color: var(--color-accent-dark); }
.ab-stat-card span { font-size: .85rem; line-height: 1.35; color: var(--color-ink-2); }
@media (max-width: 900px) {
  .ab-story__grid { grid-template-columns: 1fr; }
  .ab-story__fig { margin: var(--space-6) var(--space-6) var(--space-10) var(--space-4); }
  .ab-stat-card { margin-left: calc(-1 * var(--space-3)); }
}

/* ---------- Approach cards ---------- */
.ab-approach { background: var(--color-paper); }
.ab-approach .section-head { display: grid; gap: var(--space-3); max-width: 62ch; margin-bottom: var(--space-10); }
.ab-approach .section-head h2 { text-wrap: balance; }
.ab-approach .answer-block { margin: 0; }
.ab-cards { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-5); margin: 0; padding: 0; list-style: none; }
.ab-card { position: relative; display: grid; gap: var(--space-3); align-content: start; padding: var(--space-6) var(--space-5) var(--space-6); border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); transition: transform var(--transition-slow), box-shadow var(--transition-slow); }
.ab-card:nth-child(even) { margin-top: var(--space-8); }
.ab-card:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
.ab-card__icon { display: grid; place-items: center; width: 52px; height: 52px; border-radius: var(--radius); background: var(--color-surface); color: var(--color-accent-dark); box-shadow: var(--shadow); }
.ab-card h3 { font-size: 1.15rem; text-wrap: balance; }
.ab-card p { margin: 0; font-size: .95rem; color: var(--color-ink-2); }
@media (max-width: 1000px) { .ab-cards { grid-template-columns: repeat(2, minmax(0, 1fr)); } .ab-card:nth-child(even) { margin-top: 0; } }
@media (max-width: 560px) { .ab-cards { grid-template-columns: 1fr; } }

/* ---------- Facts band (dark, slanted, grain) ---------- */
.ab-facts .ab-facts__head { display: grid; gap: var(--space-2); margin-bottom: var(--space-8); }
.ab-facts__grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); margin: 0; }
.ab-facts__item { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-2) var(--space-6); border-left: 1px solid color-mix(in srgb, var(--color-white) 16%, transparent); }
.ab-facts__item:first-child { border-left: 0; padding-left: 0; }
.ab-facts__item dt { font-family: var(--font-accent); font-weight: 700; font-size: clamp(1.8rem, 3.4vw, 2.6rem); line-height: 1; color: var(--color-white); }
.ab-facts__item dd { margin: 0; font-size: .92rem; color: color-mix(in srgb, var(--color-white) 76%, transparent); }
.ab-facts .floating-ring { right: -110px; bottom: -150px; }
@media (max-width: 900px) {
  .ab-facts__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); row-gap: var(--space-6); }
  .ab-facts__item:nth-child(3) { border-left: 0; padding-left: 0; }
}

/* ---------- Google proof ---------- */
.ab-proof { background: var(--color-paper); }
.ab-proof__head { display: grid; gap: var(--space-3); max-width: 62ch; margin-bottom: var(--space-8); }
.ab-proof__head h2 { text-wrap: balance; }
.ab-proof__head .answer-block { margin: 0; }
.ab-proof__links { display: flex; flex-wrap: wrap; gap: var(--space-3); margin-bottom: var(--space-8); }

/* ---------- Closing CTA ---------- */
.ab-cta.cta-banner { background: linear-gradient(125deg, var(--color-primary-deep) -10%, var(--color-dark) 45%, var(--color-dark-alt) 100%); }
.ab-cta .cta-copy { display: grid; gap: var(--space-3); max-width: 58ch; }
.ab-cta .cta-copy p { margin: 0; }
.ab-cta .actions { align-items: center; }
.ab-cta .btn-accent { color: var(--color-white); }
.ab-cta .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.ab-cta .link-call svg { color: var(--color-accent-bright); }
.ab-cta .floating-ring { left: -100px; top: -130px; }

@media (prefers-reduced-motion: reduce) { .ab-card { transition: none; } }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ HERO ============ -->
<section class="hero hero--interior ab-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-copy">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="breadcrumb-sep" aria-hidden="true">/</li>
          <li><span aria-current="page">About</span></li>
        </ol>
      </nav>
      <span class="eyebrow">About <?php echo h($siteName); ?></span>
      <h1 class="hero-title" id="hero-title">A Fence Contractor Built on <span class="text-accent">Ennis &amp; Waxahachie</span> Ground</h1>
      <p class="hero-answer"><?php echo h($siteName); ?> is a fence contractor owned by <?php echo h($ownerName); ?>, serving Ennis, Waxahachie and Ellis County, Texas, and building and repairing fences there for <?php echo $abYears; ?> years.</p>
      <div class="hero-actions">
        <?php echo estimateLink('btn btn-primary btn-lg', 'Get a free estimate'), "\n"; ?>
        <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
      </div>
      <ul class="hero-chips">
        <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
        <li><?php echo icon('fence', 16); ?><?php echo $abYears; ?> years building fences</li>
        <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ STORY (asymmetric: long copy + plan drawing) ============ -->
<section class="section ab-story" aria-labelledby="story-title">
  <div class="container-wide">
    <div class="ab-story__grid">
      <div class="ab-story__copy reveal-left">
        <span class="eyebrow">The company</span>
        <h2 id="story-title">Who is <?php echo h($siteName); ?>, and what does it build around Ennis and Waxahachie?</h2>
        <p class="answer-block"><?php echo h($siteName); ?> is a fence contractor owned by <?php echo h($ownerName); ?>. It has built and repaired fences around Ennis and Waxahachie for <?php echo $abYears; ?> years, from <?php echo serviceLink('privacy-fence', 'privacy fences'); ?> and <?php echo serviceLink('cedar-fence', 'cedar fences'); ?> to <?php echo serviceLink('chain-link', 'chain link'); ?>, <?php echo serviceLink('wrought-iron', 'wrought iron'); ?> and <?php echo serviceLink('fence-repair', 'repairs to fences'); ?> that are already standing.</p>
        <p>The work runs from a backyard privacy run to <?php echo serviceLink('fence-installation', 'new fence and gate installation'); ?> on residential and farm properties. Each service has its own page on this site, with what the job includes, how it runs, and the questions owners ask before they call.</p>
        <p>The ground shapes the way <?php echo h($siteName); ?> builds. Ennis and Waxahachie sit on Blackland Prairie clay, which swells after heavy rain and shrinks and cracks in a dry summer. That movement works fence posts out of line, so <?php echo h($siteName); ?> treats a leaning section as a post problem first, and a board problem second.</p>
        <p>An estimate starts at the property. The fence line is walked and measured, the ground, the gate spots and any old fence are noted, and the quote comes back in writing. Before any digging, the property line is confirmed from your plat or survey and the city and HOA rules for the address are checked.</p>
        <p>The office answers <?php echo phoneLink(); ?> Monday through Friday, 7 AM to 6 PM, and the estimate form on the <a href="/contact/">contact page</a> reaches <?php echo h($siteName); ?> at any hour. <?php echo h($siteName); ?> works within about <?php echo (int) $serviceRadiusMiles; ?> miles of Ennis and Waxahachie.</p>
      </div>

      <div class="ab-story__fig reveal-right">
        <figure class="ab-plan">
          <svg viewBox="0 0 400 400" role="img" aria-labelledby="plan-title" focusable="false">
            <title id="plan-title">Plan-view drawing of a fenced yard: a dashed property line, a house, a fence line with posts every few feet, and a gate on the front side with its swing marked</title>
<?php for ($abG = 20; $abG < 400; $abG += 40): ?>
            <line class="grid-line" x1="<?php echo $abG; ?>" y1="0" x2="<?php echo $abG; ?>" y2="400"/>
            <line class="grid-line" x1="0" y1="<?php echo $abG; ?>" x2="400" y2="<?php echo $abG; ?>"/>
<?php endfor; ?>
            <rect class="lot" x="30" y="50" width="340" height="320"/>
            <rect class="house" x="120" y="85" width="160" height="100" rx="3"/>
            <text class="label" x="168" y="140">HOUSE</text>
            <path class="rail" d="M170 350 H50 V70 H350 V350 H230"/>
<?php
$abPosts = [];
for ($abX = 50; $abX <= 350; $abX += 50) $abPosts[] = [$abX, 70];            // back run
for ($abY = 120; $abY <= 350; $abY += 50) { $abPosts[] = [50, $abY]; $abPosts[] = [350, $abY]; }   // sides
$abPosts[] = [100, 350]; $abPosts[] = [150, 350]; $abPosts[] = [250, 350]; $abPosts[] = [300, 350]; // front run
foreach ($abPosts as $abPost): ?>
            <circle class="post" cx="<?php echo $abPost[0]; ?>" cy="<?php echo $abPost[1]; ?>" r="6"/>
<?php endforeach; ?>
            <circle class="post post--gate" cx="170" cy="350" r="8"/>
            <circle class="post post--gate" cx="230" cy="350" r="8"/>
            <path class="swing" d="M230 350 A60 60 0 0 0 170 290"/>
            <path class="leader" d="M200 372 V384"/>
            <text class="label label--accent" x="177" y="396">GATE</text>
            <path class="leader" d="M50 70 L20 30 H70"/>
            <text class="label" x="76" y="34">POST</text>
            <text class="label" x="250" y="44">PROPERTY LINE</text>
          </svg>
          <figcaption>A fence line on paper: the property line, the posts and the gate are settled before the first hole is dug.</figcaption>
        </figure>
        <div class="ab-stat-card">
          <b><?php echo $abYears; ?> years</b>
          <span>building and repairing fences around Ennis and Waxahachie</span>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
$ctaBandTitle = 'Want a fence estimate from ' . $siteName . '?';
$ctaBandCopy  = 'Send the fence type, a rough length and the town. The office calls back during business hours to set a time to walk the fence line.';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php';
?>

<!-- ============ APPROACH (tinted cards, staggered) ============ -->
<section class="section ab-approach" aria-labelledby="approach-title">
  <div class="container-wide">
    <div class="section-head reveal-up">
      <span class="eyebrow">How the work is done</span>
      <h2 id="approach-title">How does <?php echo h($siteName); ?> approach a fence job?</h2>
      <p class="answer-block"><?php echo h($siteName); ?> approaches every fence job in the same order: measure the line, put the price in writing, settle the property line and local rules, and treat the posts as the part of the fence that has to be right.</p>
    </div>
    <ul class="ab-cards">
<?php foreach ($abApproach as $abI => $abCard): ?>
      <li class="ab-card card-tint-<?php echo h($abCard['tint']); ?> <?php echo ['reveal-up', 'reveal-down', 'reveal-up', 'reveal-scale'][$abI]; ?> reveal-delay-<?php echo $abI + 1; ?>">
        <span class="ab-card__icon"><?php echo icon($abCard['icon'], 26); ?></span>
        <h3><?php echo h($abCard['title']); ?></h3>
        <p><?php echo h($abCard['text']); ?></p>
      </li>
<?php endforeach; ?>
    </ul>
  </div>
</section>

<!-- ============ FACTS (dark, slanted) ============ -->
<section class="section ab-facts texture-grain slant-top" aria-labelledby="facts-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div class="ab-facts__head reveal-up">
      <span class="eyebrow">At a glance</span>
      <h2 id="facts-title"><?php echo h($siteName); ?> in four facts</h2>
    </div>
    <dl class="ab-facts__grid">
<?php foreach ($abFacts as $abI => $abFact): ?>
      <div class="ab-facts__item reveal-up reveal-delay-<?php echo $abI + 1; ?>">
        <dt><?php echo h($abFact[0]); ?></dt>
        <dd><?php echo h($abFact[1]); ?></dd>
      </div>
<?php endforeach; ?>
    </dl>
  </div>
</section>

<!-- ============ PROOF: Google Business Profile (the verifiable record) ============ -->
<section class="section ab-proof" aria-labelledby="proof-title">
  <div class="container">
    <div class="ab-proof__head reveal-up">
      <span class="eyebrow">Check the record</span>
      <h2 id="proof-title">Where can you check what customers say about <?php echo h($siteName); ?>?</h2>
      <p class="answer-block">The place to check <?php echo h($siteName); ?> is its Google Business Profile, where customers in Ennis and Waxahachie post written reviews. Anything shown below is copied from that profile exactly as the customer wrote it.</p>
    </div>
    <div class="ab-proof__links">
<?php if (!empty($gbp['url'])): ?>
      <a class="btn btn-secondary" href="<?php echo h($gbp['url']); ?>" target="_blank" rel="noopener"><?php echo icon('external-link', 18); ?>Read the reviews on Google</a>
<?php endif; ?>
<?php if (!empty($gbp['review_url'])): ?>
      <a class="btn btn-outline" href="<?php echo h($gbp['review_url']); ?>" target="_blank" rel="noopener"><?php echo icon('star', 18); ?>Leave a Google review</a>
<?php endif; ?>
    </div>
<?php if ($abReviews !== ''): ?>
    <?php echo $abReviews; ?>
<?php endif; ?>
  </div>
</section>

<!-- ============ CLOSING CTA ============ -->
<section class="cta-banner texture-grain edge-curve-top ab-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-copy reveal-scale">
      <span class="eyebrow">Free estimate</span>
      <h2 id="cta-title">Ready to see what your fence line needs?</h2>
      <p>Call <?php echo h($siteName); ?> or send the form, and the office will set a time to walk the line with you and put the price in writing.</p>
    </div>
    <div class="actions reveal-scale reveal-delay-2">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a Free Fence Estimate</button>
      <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
