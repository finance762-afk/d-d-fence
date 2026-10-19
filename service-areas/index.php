<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/ — D & D Fence service area hub (Phase 6, 2026-10-19). URL form is /service-areas/ (plural, directory + index.php).
 * Premium hub: coverage schematic (two overlapping ~25-mile rings, 15 miles apart on US 287), two town cards, a comparison table
 * of how the two towns differ for a fence project, services strip, FAQ and CTA. Facts and source URLs are in the
 * ennis/ and waxahachie/ page headers; the hub restates only facts those pages carry. The hub has no hero form
 * (the lead-form placement rule covers home, service and city pages); the estimate dialog opens from the buttons.
 */
$pageTitle       = 'Fence Service Areas: Ennis & Waxahachie, TX | ' . $siteName;
$pageDescription = 'D & D Fence builds and repairs fences in Ennis and Waxahachie, TX and within about 25 miles. See each town\'s fence rules and request an estimate today.';
$canonicalUrl    = $siteUrl . '/service-areas/';
$ogImage         = defaultOgImage();
$currentPage     = 'service-areas';
$pageType        = 'other';

$saFaqs = [
    ['q' => 'Which towns does D & D Fence serve?',
     'a' => 'D & D Fence serves Ennis and Waxahachie, Texas, and the area within about 25 miles of both. The two towns are 15 miles apart on US 287, so a job in either one sits inside the same service area.'],
    ['q' => 'Does D & D Fence travel outside Ennis and Waxahachie?',
     'a' => 'Within about 25 miles of Ennis and Waxahachie, yes. Past that radius, call (469) 321-7783 and describe the job; the company can tell you on the phone whether it fits the schedule. Hours are Monday to Friday, 7 AM to 6 PM.'],
    ['q' => 'Are fence rules the same in Ennis and Waxahachie?',
     'a' => 'No. Waxahachie publishes a residential fence permit checklist with an 8-foot height limit, metal posts on privacy fences and a 20-foot setback for vehicle gates. The City of Ennis lists fences over 8 feet high as needing a permit and asks you to call Planning & Development at (972) 875-6442 for anything else. HOAs add their own rules in both towns.'],
];

$saTowns = [
    ['name' => 'Ennis', 'state' => 'TX', 'slug' => 'ennis', 'url' => '/service-areas/ennis/'],
    ['name' => 'Waxahachie', 'state' => 'TX', 'slug' => 'waxahachie', 'url' => '/service-areas/waxahachie/'],
];
$saItems = [];
foreach ($saTowns as $saI => $saT) {
    $saItems[] = ['@type' => 'ListItem', 'position' => $saI + 1, 'name' => 'Fence installation in ' . $saT['name'] . ', TX', 'url' => $siteUrl . $saT['url']];
}
$saCrumbs = generateBreadcrumbSchema([['name' => 'Home', 'url' => '/'], ['name' => 'Service Areas', 'url' => '/service-areas/']]);
unset($saCrumbs['@context']);
$saFaqNode = generateFAQSchema($saFaqs);
unset($saFaqNode['@context']);
$saCities = array_map(fn($saT) => ['@type' => 'City', 'name' => $saT['name'], 'containedInPlace' => ['@type' => 'State', 'name' => 'Texas']], $saTowns);
$schemaMarkup = [
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'      => 'CollectionPage',
            '@id'        => $canonicalUrl . '#webpage',
            'url'        => $canonicalUrl,
            'name'       => 'Fence Service Areas: Ennis and Waxahachie, TX',
            'isPartOf'   => ['@id' => $siteUrl . '/#website'],
            'about'      => ['@id' => $siteUrl . '/#organization'],
            'breadcrumb' => ['@id' => $canonicalUrl . '#breadcrumb'],
            'mainEntity' => ['@id' => $canonicalUrl . '#towns'],
            'speakable'  => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']],
        ],
        ['@type' => 'ItemList', '@id' => $canonicalUrl . '#towns', 'name' => 'D & D Fence service areas', 'itemListElement' => $saItems],
        ['@type' => 'HomeAndConstructionBusiness', '@id' => $siteUrl . '/#organization', 'name' => $siteName, 'url' => $siteUrl . '/', 'areaServed' => $saCities],
        $saCrumbs + ['@id' => $canonicalUrl . '#breadcrumb'],
        $saFaqNode + ['@id' => $canonicalUrl . '#faq'],
    ],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/area-page.css'; ?>

/* ==========================================================================
   Service areas hub — page-specific composition: survey-stake hero motif, overlapping-ring coverage schematic (signature),
   offset town cards, comparison sheet. Tokens only.
   ========================================================================== */
.sa-hero { padding-bottom: clamp(2.5rem, 5vw, 4rem); }
.sa-hero .sp-hero__motif { opacity: .07; }
.sa-hero .hero-copy { max-width: 46rem; }
.sa-hero .hero-title { max-width: 24ch; }
.sa-hero .hero-actions { display: flex; flex-wrap: wrap; align-items: center; gap: var(--space-4) var(--space-6); }

.sa-cover { background: var(--color-paper); }
.sa-cover__grid { display: grid; grid-template-columns: minmax(0, .85fr) minmax(0, 1.15fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: center; }
.sa-cover .ap-map { transform: rotate(.5deg); }
@media (max-width: 960px) { .sa-cover__grid { grid-template-columns: 1fr; } .sa-cover .ap-map { transform: none; } }

.sa-towns { background: var(--color-paper-2); }
.sa-compare { background: var(--color-surface); }
.sa-compare .sp-sheet { box-shadow: var(--shadow); }
.sa-compare .sp-table tbody th { width: 22%; }

.sa-svc { background: var(--color-paper); padding-block: clamp(2.25rem, 4vw, 3.5rem); }
.sa-svc__list { display: flex; flex-wrap: wrap; gap: var(--space-3); margin: var(--space-5) 0 0; padding: 0; list-style: none; }
.sa-svc__list a { display: inline-flex; align-items: center; gap: var(--space-2); padding: var(--space-2) var(--space-4); border: 1px solid var(--color-line); border-radius: var(--radius-full); background: var(--color-surface); font-weight: 600; font-size: .95rem; transition: border-color var(--transition), color var(--transition); }
.sa-svc__list a svg { color: var(--color-accent-dark); }
.sa-svc__list a:hover { border-color: var(--color-accent); color: var(--color-accent-dark); }

.sa-cta .floating-ring { opacity: .08; }
@media (prefers-reduced-motion: reduce) { .sa-cover .ap-map, .sa-svc__list a { transform: none; transition: none; } }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ 1. HERO (type hero, survey-stake motif; no form on the hub) ============ -->
<section class="hero hero--interior sp-hero sa-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="sp-hero__motif" aria-hidden="true">
    <svg viewBox="0 0 720 420" preserveAspectRatio="xMaxYMax slice" focusable="false">
      <defs>
        <pattern id="sa-stakes" width="96" height="420" patternUnits="userSpaceOnUse">
          <path d="M44 150 h8 v270 h-8 Z" fill="currentColor"/>
          <path d="M36 150 h24 l-12 -22 Z" fill="currentColor"/>
          <path d="M0 260 H96" stroke="currentColor" stroke-width="2" stroke-dasharray="6 8" fill="none"/>
        </pattern>
      </defs>
      <rect x="0" y="0" width="720" height="420" fill="url(#sa-stakes)"/>
    </svg>
  </div>
  <div class="container">
    <div class="hero-copy">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="breadcrumb-sep" aria-hidden="true">/</li>
          <li><span aria-current="page">Service Areas</span></li>
        </ol>
      </nav>
      <span class="eyebrow">Ellis County, Texas</span>
      <h1 class="hero-title" id="hero-title">Fence Contractor in <span class="text-accent">Ennis, Waxahachie</span> &amp; Surrounding Communities</h1>
      <p class="hero-answer"><?php echo h($siteName); ?> installs and repairs fences in Ennis and Waxahachie, TX, and within about <?php echo (int) $serviceRadiusMiles; ?> miles of both. Pick your town below for its fence rules and local conditions.</p>
      <div class="hero-actions">
        <button type="button" class="btn btn-primary btn-lg" data-open-estimate>Get a free estimate</button>
        <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
      </div>
      <ul class="hero-chips">
        <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
        <li><?php echo icon('map-pin', 16); ?>Ennis · Waxahachie · ~<?php echo (int) $serviceRadiusMiles; ?> miles</li>
        <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
      </ul>
    </div>
  </div>
</section>

<article class="sp-article" aria-labelledby="hero-title">

<!-- ============ 2. SIGNATURE: coverage schematic ============ -->
<section class="section sa-cover" aria-labelledby="cover-title">
  <div class="container-wide">
    <div class="sa-cover__grid">
      <div class="sp-head reveal-left">
        <span class="eyebrow">Where we work</span>
        <h2 id="cover-title">Which areas does <?php echo h($siteName); ?> cover for fence work?</h2>
        <p class="answer-block"><?php echo h($siteName); ?> covers Ennis and Waxahachie, 15 miles apart on US 287, and the area within about <?php echo (int) $serviceRadiusMiles; ?> miles of both. Because the two circles overlap, a property between the towns sits inside both of them.</p>
        <p>Outside the circles? Call <?php echo phoneLink(); ?> and describe the job. A phone call settles whether it fits the schedule faster than a map does.</p>
      </div>

      <figure class="ap-map reveal-right">
        <svg viewBox="0 0 560 340" role="img" aria-labelledby="cover-map-title" focusable="false">
          <title id="cover-map-title">Schematic map showing two overlapping circles, each with a radius of about 25 miles, centered on Waxahachie and Ennis, which are 15 miles apart on US 287</title>
          <circle class="m-ring" cx="228" cy="150" r="130"/>
          <circle class="m-ring m-ring--2" cx="306" cy="185" r="130"/>
          <path class="m-road" d="M228 150 Q 270 150 306 185"/>
          <line class="m-link" x1="228" y1="150" x2="306" y2="185"/>
          <circle class="m-dot m-dot--home" cx="228" cy="150" r="10"/>
          <circle class="m-dot m-dot--home" cx="306" cy="185" r="10"/>
          <text class="m-label m-label--big" x="116" y="150">WAXAHACHIE</text>
          <text class="m-label m-label--big" x="324" y="198">ENNIS</text>
          <text class="m-label m-label--muted" x="236" y="136">15 mi · US 287</text>
          <text class="m-label m-label--accent" x="108" y="70">~25 MI</text>
          <text class="m-label m-label--accent" x="406" y="296">~25 MI</text>
        </svg>
        <figcaption>Schematic drawn to one scale: the two towns are 15 miles apart and each dashed ring is about <?php echo (int) $serviceRadiusMiles; ?> miles. Roads other than US 287 are left off on purpose. This is a coverage guide, not a property map.</figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ============ 3. TOWN CARDS (every card links to a built page; anchors back the areaHref() fallback) ============ -->
<section class="section sa-towns edge-curve-top" aria-labelledby="towns-title">
  <div class="container-wide">
    <div class="sp-head reveal-up">
      <span class="eyebrow">Pick your town</span>
      <h2 id="towns-title">Which town page matches your <span class="text-accent">fence project</span>?</h2>
      <p class="answer-block">Ennis is the Blackland Prairie town where soil movement shapes the post line; Waxahachie is the county seat with a published fence permit checklist. Each page covers the rules, local details and questions for that town.</p>
    </div>
    <ul class="ap-towns">
      <li class="ap-town reveal-left" id="ennis">
        <span class="eyebrow">Eastern Ellis County</span>
        <h3>Fence installation in Ennis, TX</h3>
        <p>Ennis sits on Blackland Prairie, with I-45 along its east side and Lake Bardwell to the southwest. The Ennis page covers what clay that opens and closes with the weather does to posts, the Templeton-McCanless historic homes, acreage fencing and who to call at the City.</p>
        <ul class="ap-town__meta" aria-label="Ennis at a glance">
          <li>2020 population 20,159</li>
          <li>Blackland Prairie</li>
          <li>Acreage &amp; farm fencing</li>
        </ul>
        <a class="btn btn-primary" href="/service-areas/ennis/">Fence contractor in Ennis →</a>
      </li>
      <li class="ap-town reveal-right reveal-delay-2" id="waxahachie">
        <span class="eyebrow">Ellis County seat</span>
        <h3>Fence installation in Waxahachie, TX</h3>
        <p>Waxahachie has a published residential fence permit checklist, a courthouse square from 1897 and Victorian neighborhoods. The Waxahachie page lays the City's rules beside what they mean for your fence.</p>
        <ul class="ap-town__meta" aria-label="Waxahachie at a glance">
          <li>2020 population 41,140</li>
          <li>8-foot height limit</li>
          <li>Permit checklist</li>
        </ul>
        <a class="btn btn-primary" href="/service-areas/waxahachie/">Fence contractor in Waxahachie →</a>
      </li>
    </ul>
  </div>
</section>

<!-- ============ 4. COMPARISON: how the two towns differ for a fence (real table) ============ -->
<section class="section sp-compare sa-compare" aria-labelledby="compare-title">
  <div class="container-wide">
    <div class="sp-head reveal-up">
      <span class="eyebrow">Town by town</span>
      <h2 id="compare-title">How do fence rules and conditions differ between Ennis and Waxahachie?</h2>
      <p class="answer-block">Waxahachie publishes a fence permit checklist, while the City of Ennis lists only fences over 8 feet high as needing a permit and asks you to call. The ground is Blackland Prairie clay in both. Check the rules for your own address either way.</p>
    </div>
    <div class="sp-sheet ap-sheet reveal-up">
      <div class="sp-sheet__head"><span>Side by side</span><b>Ennis and Waxahachie for a fence project</b></div>
      <div class="table-scroll" role="region" aria-label="Ennis and Waxahachie fence comparison" tabindex="0">
        <table class="sp-table">
          <caption class="sr-only">Comparison of Ennis and Waxahachie by location, City fence permit information and local conditions</caption>
          <thead>
            <tr><th scope="col">Topic</th><th scope="col">Ennis</th><th scope="col">Waxahachie</th></tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">Where<small>Both in Ellis County</small></th>
              <td data-label="Ennis">Eastern Ellis County; I-45 on the east side, SH 34 through the center, Dallas 35 miles north.</td>
              <td data-label="Waxahachie">County seat; I-35E on the west side, US 287 on the north side, US 77 through downtown.</td>
            </tr>
            <tr>
              <th scope="row">City fence permit</th>
              <td data-label="Ennis">The City lists fences over 8 feet high as needing a permit. Planning &amp; Development: (972) 875-6442.</td>
              <td data-label="Waxahachie">Residential Fence/Retaining Wall permit with a site plan and at least 10 working days of review. Permit office: (469) 309-4020.</td>
            </tr>
            <tr>
              <th scope="row">Published fence rules</th>
              <td data-label="Ennis">Call Planning &amp; Development for height and setback questions before you start.</td>
              <td data-label="Waxahachie">8-foot maximum; metal posts on privacy fences; open, low fences in front yards; vehicle gates set back 20 feet.</td>
            </tr>
            <tr>
              <th scope="row">Ground &amp; setting</th>
              <td data-label="Ennis">Blackland Prairie, Kachina Prairie park, open county around Lake Bardwell.</td>
              <td data-label="Waxahachie">Level to rolling Ellis County ground, a little over 600 feet above sea level.</td>
            </tr>
            <tr>
              <th scope="row">Older homes</th>
              <td data-label="Ennis">Templeton-McCanless Residential Historic District, created in 1986.</td>
              <td data-label="Waxahachie">Gingerbread-style Victorian houses and five National Register historic districts.</td>
            </tr>
            <tr>
              <th scope="row">Full page</th>
              <td data-label="Ennis"><a class="sp-link" href="/service-areas/ennis/">Ennis fence page →</a></td>
              <td data-label="Waxahachie"><a class="sp-link" href="/service-areas/waxahachie/">Waxahachie fence page →</a></td>
            </tr>
          </tbody>
        </table>
      </div>
      <p class="sp-sheet__foot">Compiled from the City of Ennis permit page, the City of Waxahachie permit checklist (revision dated 05/24), Wikipedia and the Texas State Historical Association. Rules change; confirm with the City.</p>
    </div>
  </div>
</section>

<!-- ============ 5. SERVICES AVAILABLE IN BOTH TOWNS ============ -->
<section class="sa-svc" aria-labelledby="svc-title">
  <div class="container">
    <div class="sp-head reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2 id="svc-title">Which fence services are available in Ennis and Waxahachie?</h2>
      <p class="answer-block"><?php echo h($siteName); ?> offers the same six services in both towns: privacy fences, cedar fences, chain link, wrought iron, fence repair and new fence and gate installation.</p>
    </div>
    <ul class="sa-svc__list">
<?php foreach ($services as $saSvc): ?>
      <li><a href="/services/<?php echo h($saSvc['slug']); ?>/"><?php echo icon(serviceCards()[$saSvc['slug']]['icon'], 18); ?><?php echo h($saSvc['name']); ?></a></li>
<?php endforeach; ?>
      <li><a href="/services/"><?php echo icon('layers', 18); ?>All services</a></li>
    </ul>
  </div>
</section>

<!-- ============ 6. FAQ ============ -->
<section class="section sp-faq" aria-labelledby="faq-title">
  <div class="container-narrow">
    <div class="sp-head reveal-down">
      <span class="eyebrow">Service area questions</span>
      <h2 id="faq-title">What do property owners ask about <?php echo h($siteName); ?>'s service area?</h2>
      <p class="answer-block">Owners mostly ask which towns are covered, how far the crew travels and whether fence rules match from town to town. The answers below come from <?php echo h($siteName); ?> and the two City pages linked from each town page.</p>
    </div>
    <div class="faq-grid">
<?php foreach ($saFaqs as $saIdx => $saFaq): ?>
      <details class="faq"<?php echo $saIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo h($saFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo h($saFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>

</article>

<!-- ============ 7. FINAL CTA ============ -->
<section class="cta-banner texture-grain slant-top sp-cta sa-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-copy reveal-scale">
      <span class="eyebrow">Free estimate</span>
      <h2 id="cta-title">Get a Free Fence Estimate Near Ennis or Waxahachie</h2>
      <p>Tell <?php echo h($siteName); ?> your town, the rough length and the fence type, and the crew will set up a time to walk the line with you.</p>
    </div>
    <div class="actions reveal-scale reveal-delay-2">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a Free Estimate</button>
      <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
