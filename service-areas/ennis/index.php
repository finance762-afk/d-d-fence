<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/ennis/ — D & D Fence (Phase 6, 2026-10-19). Premium city page. Opening angle: the GROUND (Blackland Prairie clay),
 * then the road map. Signature section: a road-distance schematic of Ennis and the 25-mile service radius.
 * No client photos on file: type hero with a wire-and-post motif; recent-work strip skipped until photos exist.
 *
 * RESEARCH (2026-10-19) — every local claim below traces to one of these sources:
 *   https://en.wikipedia.org/wiki/Ennis,_Texas  — eastern Ellis County; Blackland Prairie; I-45 on the east side, US 287 around the south
 *       side (15 mi NW to Waxahachie), SH 34 through the center (26 mi NE to Kaufman, 20 mi SW to Italy); Dallas 35 mi north; pop. 20,159
 *       (2020); Lake Bardwell (USACE reservoir southwest of town); Kachina Prairie city park preserving untouched Blackland Prairie, first
 *       Ennis bluebonnet trail marked there 1938; Templeton-McCanless Residential Historic District (1986, National Register: Neoclassical,
 *       American Craftsman, Folk Victorian homes); Houston & Texas Central Railroad reached Ennis 1871; Ennis Railroad and Cultural Heritage
 *       Museum; Ennis ISD.
 *   https://www.ennistx.gov/doesmyprojectrequireapermit — City of Ennis: "Fences over 8 feet high" are listed as needing a permit; Planning &
 *       Development, (972) 875-6442, 108 W. Knox St., Ennis, TX 75119, Mon–Fri 8 AM–5 PM. No fence-specific height/setback page was found,
 *       so the copy states only what that page lists and tells readers to call.
 *   https://soilseries.sc.egov.usda.gov/OSD_Docs/E/ELLIS.html — USDA Ellis series: established Ellis County, TX 1910; Blackland Prairies (MLRA 86A);
 *       "cracks remain open 120 to 150 cumulative days in most years".
 *   https://www.tshaonline.org/handbook/entries/ellis-county — Ellis County: Blackland Prairie, "level to rolling", 300–700 ft (Texas Almanac
 *       sidebar says up to 898 ft).
 *   https://phzmapi.org/75119.json — 2023 USDA hardiness zone for ZIP 75119: 8b (15–20 °F minimum). Same zone as Waxahachie (75165), so zone is not
 *       used as a differentiator in the copy.
 * ELEVATION: Wikipedia gives 535 ft for Ennis; other sources differ, so the page says only "a little over 500 feet" (range, never a point value).
 * NOT CLAIMED: how often D & D Fence works in Ennis, any Ennis job count, base city (unknown in intake), an Ennis HOA or historic-district rule.
 * The page's open questions are listed under /service-areas/ennis/ in /content-confirmations.json.
 */
$enTown = ['slug' => 'ennis', 'name' => 'Ennis', 'wiki' => 'https://en.wikipedia.org/wiki/Ennis,_Texas'];

$pageTitle       = 'Fence Contractor in Ennis, TX | ' . $siteName;
$pageDescription = 'D & D Fence installs and repairs privacy, cedar, chain link and wrought iron fences in Ennis, TX, built around Blackland Prairie clay. Call (469) 321-7783.';
$canonicalUrl    = $siteUrl . '/service-areas/ennis/';
$ogImage         = defaultOgImage();
$currentPage     = 'service-areas';
$pageType        = 'city';
$citySlug        = 'ennis';
$heroFormTitle   = 'Free estimate in Ennis';
$svc             = serviceBySlug('fence-installation');   // preselects the hero form's service

$enFaqs = [
    ['q' => 'Do I need a permit to build a fence in Ennis?',
     'a' => 'The City of Ennis lists fences over 8 feet high among the projects that need a permit. For any other fence, call the City\'s Planning & Development Department at (972) 875-6442 (108 W. Knox St., Monday to Friday, 8 AM to 5 PM) before work starts, because the answer can depend on your address and on any HOA covenants. D & D Fence can look at the rules for your address while it measures the run.'],
    ['q' => 'Why do fence posts lean in the Blackland Prairie clay around Ennis?',
     'a' => 'Ennis sits on Blackland Prairie, where clay swells when it is wet and shrinks and cracks as it dries. USDA\'s description of the Ellis clay, a soil series first set up in Ellis County in 1910, says its cracks stay open 120 to 150 days in most years. That seasonal movement works posts out of line, so a leaning section is usually a post problem rather than a board problem.'],
    ['q' => 'Does D & D Fence build fences on acreage and farm property outside Ennis?',
     'a' => 'Yes. D & D Fence\'s fence installation service covers farm and acreage properties as well as residential lots, and the service area reaches about 25 miles from Ennis. For land out toward Lake Bardwell or along SH 34, tell the crew the length of the run, where the gate openings need to be and what the fence has to hold in.'],
    ['q' => 'What should I ask before fencing a home in the Ennis historic district?',
     'a' => 'Ennis\'s Templeton-McCanless Residential Historic District, created in 1986 and on the National Register of Historic Places, is a neighborhood of Neoclassical, American Craftsman and Folk Victorian homes. Ask the City whether your address needs any extra review before you settle on a style. Wrought iron and a cedar fence are both common choices beside older homes, and D & D Fence builds both.'],
];

$schemaMarkup = areaPageSchema(
    $enTown,
    'Fence Contractor in Ennis, TX',
    'D & D Fence installs and repairs privacy, cedar, chain link and wrought iron fences and gates in Ennis, TX and the surrounding Ellis County area, including farm and acreage properties.',
    $enFaqs
);

$enCards   = serviceCards();
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/area-page.css'; ?>

/* ==========================================================================
   Ennis — page-specific composition: wire-and-post hero motif, cracked-clay rule on the pull quote,
   road-distance schematic (signature), ruled fact list. Tokens only.
   ========================================================================== */
.en-hero .sp-hero__motif { opacity: .08; }
.en-hero .eyebrow::before { width: 30px; }

/* Conditions: pull quote sits on a cracked-clay rule */
.en-ground .pull-quote { position: relative; padding-top: var(--space-5); }
.en-ground .pull-quote::before {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  width: 110px;
  height: 14px;
  background:
    linear-gradient(135deg, transparent 46%, var(--color-accent) 46% 54%, transparent 54%) 0 0 / 22px 14px repeat-x,
    linear-gradient(45deg, transparent 46%, var(--color-accent-dark) 46% 54%, transparent 54%) 11px 0 / 22px 14px repeat-x;
  opacity: .8;
}
.en-ground .sp-bento > li:first-child { background: var(--color-card-tint-1); }
.en-ground .sp-bento > li:nth-child(4) { background: var(--color-card-tint-3); }
@media (min-width: 901px) { .en-ground .sp-bento > li:nth-child(4) { grid-column: span 2; } }

/* Signature: road-distance schematic */
.en-reach { background: var(--color-paper-2); }
.en-reach__grid { display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(0, .9fr); gap: clamp(2rem, 5vw, 4rem); align-items: center; }
.en-reach .ap-map { transform: rotate(-.4deg); }
@media (max-width: 960px) { .en-reach__grid { grid-template-columns: 1fr; } .en-reach .ap-map { transform: none; } }

/* Why band: floating ring placement */
.en-why .floating-ring { left: -150px; bottom: -170px; }

.en-cta .floating-ring { opacity: .08; }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ 1. HERO (type hero, wire-and-post motif; no client photo on file yet) ============ -->
<section class="hero hero--interior sp-hero en-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="sp-hero__motif" aria-hidden="true">
    <svg viewBox="0 0 720 420" preserveAspectRatio="xMaxYMax slice" focusable="false">
      <defs>
        <pattern id="en-wire" width="120" height="420" patternUnits="userSpaceOnUse">
          <rect x="0" y="120" width="10" height="300" fill="currentColor"/>
          <path d="M10 150 H120 M10 215 H120 M10 280 H120" stroke="currentColor" stroke-width="3" fill="none"/>
          <path d="M40 150 l14 65 M80 150 l-14 65 M40 215 l14 65 M80 215 l-14 65" stroke="currentColor" stroke-width="2" fill="none"/>
        </pattern>
      </defs>
      <rect x="0" y="0" width="720" height="420" fill="url(#en-wire)"/>
    </svg>
  </div>
  <div class="container">
    <div class="hero-grid hero-grid--form">
      <div class="hero-copy">
        <nav class="breadcrumb" aria-label="Breadcrumb">
          <ol>
            <li><a href="/">Home</a></li>
            <li class="breadcrumb-sep" aria-hidden="true">/</li>
            <li><a href="/service-areas/">Service Areas</a></li>
            <li class="breadcrumb-sep" aria-hidden="true">/</li>
            <li><span aria-current="page">Ennis, TX</span></li>
          </ol>
        </nav>
        <span class="eyebrow">Fence contractor · Ennis, Ellis County</span>
        <h1 class="hero-title" id="hero-title">Fence Installation in <span class="text-accent">Ennis</span>, TX</h1>
        <p class="hero-answer"><?php echo h($siteName); ?> installs and repairs privacy, cedar, chain link and wrought iron fences in Ennis, laid out around your lot, your gates and Blackland Prairie clay.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
          <li><?php echo icon('map-pin', 16); ?>Ennis &amp; about <?php echo (int) $serviceRadiusMiles; ?> miles around</li>
          <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title"><?php echo h($heroFormTitle); ?></h2>
        <p class="hero-form-tagline">No obligation. <b>Ennis &amp; nearby.</b></p>
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

<!-- ============ 2. THE GROUND: Blackland Prairie conditions + local specifics (pull quote + bento) ============ -->
<section class="section sp-signs en-ground" aria-labelledby="ground-title">
  <div class="container-wide">
    <div class="sp-signs__layout">
      <div class="sp-signs__intro reveal-left">
        <span class="eyebrow">What the ground does</span>
        <h2 id="ground-title">What should an Ennis property owner know before building a fence on <span class="text-accent">Blackland Prairie</span>?</h2>
        <p class="answer-block">Ennis sits on Blackland Prairie, a clay that swells when it is wet and shrinks and cracks when it dries, so the post line decides how long a fence here stays straight. <?php echo h($siteName); ?> builds fences in Ennis with that movement in mind, from a backyard run to an acreage line.</p>
        <p class="pull-quote">In Ennis, a fence is only as straight as the ground under its posts.</p>
      </div>

      <ul class="sp-bento" aria-label="Local conditions that shape a fence in Ennis">
        <li class="reveal-up reveal-delay-1">
          <?php echo icon('layers', 26); ?>
          <h3>Clay that opens and closes with the weather</h3>
          <p>USDA describes the Ellis clay, a Blackland Prairie soil series set up in Ellis County in 1910, with cracks that stay open 120 to 150 days in most years. A post set in ground that moves that much needs a plan for it; the <?php echo serviceLink('fence-repair', 'fence repair page'); ?> explains what a leaning post means for the rest of the fence.</p>
        </li>
        <li class="reveal-up reveal-delay-2">
          <?php echo icon('sprout', 26); ?>
          <h3>Kachina Prairie shows the native ground</h3>
          <p>Kachina Prairie, a city park in Ennis, preserves a patch of untouched Blackland Prairie. The first Ennis bluebonnet trail was marked there in 1938.</p>
        </li>
        <li class="reveal-up reveal-delay-3">
          <?php echo icon('route', 26); ?>
          <h3>A town that grew around the railroad</h3>
          <p>The Houston and Texas Central Railroad reached the site in 1871, and Ennis grew up around it. In the older parts of town, confirm the corners against your survey or plat before any post hole is dug.</p>
        </li>
        <li class="reveal-up reveal-delay-1">
          <?php echo icon('landmark', 26); ?>
          <h3>Historic homes call for a matching fence</h3>
          <p>The Templeton-McCanless Residential Historic District, created in 1986 and on the National Register of Historic Places, holds Neoclassical, American Craftsman and Folk Victorian homes. A <?php echo serviceLink('wrought-iron', 'wrought iron fence'); ?> or a <?php echo serviceLink('cedar-fence', 'cedar fence'); ?> is the usual way to frame one, and the City can say whether your address needs extra review first.</p>
        </li>
        <li class="reveal-up reveal-delay-2">
          <?php echo icon('waves', 26); ?>
          <h3>Open county around Lake Bardwell</h3>
          <p>Southwest of town, Lake Bardwell is a U.S. Army Corps of Engineers reservoir, and the land around it is open county rather than city lots. <?php echo serviceLink('fence-installation', 'Fence installation'); ?> from <?php echo h($siteName); ?> covers farm and acreage properties: long runs, wide gates and fence that has to hold livestock or keep a dog in.</p>
        </li>
        <li class="reveal-up reveal-delay-3">
          <?php echo icon('building-2', 26); ?>
          <h3>The City's permit desk is one call away</h3>
          <p>The City of Ennis lists fences over 8 feet high as needing a permit. Planning &amp; Development answers questions about everything else at (972) 875-6442, Monday to Friday, 8 AM to 5 PM, at 108 W. Knox St.</p>
        </li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ 3. SIGNATURE: road-distance schematic ============ -->
<section class="section en-reach" aria-labelledby="reach-title">
  <div class="container-wide">
    <div class="en-reach__grid">
      <div class="sp-head reveal-left">
        <span class="eyebrow">How far we travel</span>
        <h2 id="reach-title">How far from Ennis will <?php echo h($siteName); ?> travel for a fence?</h2>
        <p class="answer-block"><?php echo h($siteName); ?> serves Ennis and the towns within about <?php echo (int) $serviceRadiusMiles; ?> miles. Waxahachie is 15 miles northwest on US 287 and Italy is 20 miles southwest on SH 34, both inside that radius. Kaufman, 26 miles northeast on SH 34, sits at the edge, so call to confirm.</p>
        <ul class="ap-facts">
          <li><b>I-45</b><span>Runs along the east side of Ennis, with exits 247 to 255.</span></li>
          <li><b>US 287</b><span>Curves around the south side and leads 15 miles northwest to Waxahachie, the county seat.</span></li>
          <li><b>SH 34</b><span>Runs through the center of town, 26 miles northeast to Kaufman and 20 miles southwest to Italy.</span></li>
          <li><b>Farther out</b><span>Dallas is 35 miles north. For anything beyond about <?php echo (int) $serviceRadiusMiles; ?> miles, call <?php echo phoneLink(); ?> and ask.</span></li>
        </ul>
        <p class="footnote">Working on the Waxahachie side? See the <?php $enNext = areaHref('Waxahachie, TX'); echo $enNext ? '<a class="sp-link" href="' . h($enNext) . '">Waxahachie service area page</a>' : 'Waxahachie service area'; ?>.</p>
      </div>

      <figure class="ap-map reveal-right">
        <svg viewBox="0 0 560 420" role="img" aria-labelledby="reach-map-title" focusable="false">
          <title id="reach-map-title">Schematic map of Ennis showing the dashed 25-mile service radius, Interstate 45 on the east side, US 287 curving south and northwest to Waxahachie at 15 miles, State Highway 34 running northeast to Kaufman at 26 miles and southwest to Italy at 20 miles, Lake Bardwell southwest of town, and Dallas 35 miles north outside the radius</title>
          <circle class="m-ring" cx="280" cy="250" r="150"/>
          <ellipse class="m-water" cx="228" cy="292" rx="26" ry="13" transform="rotate(-25 228 292)"/>
          <line class="m-road" x1="330" y1="20" x2="330" y2="410"/>
          <path class="m-road" d="M216 186 Q 228 306 330 306"/>
          <line class="m-road m-road--minor" x1="390" y1="140" x2="195" y2="335"/>
          <line class="m-link" x1="280" y1="250" x2="216" y2="186"/>
          <line class="m-link" x1="280" y1="250" x2="195" y2="335"/>
          <line class="m-link" x1="280" y1="250" x2="390" y2="140"/>
          <line class="m-link" x1="280" y1="250" x2="280" y2="52"/>
          <circle class="m-dot m-dot--out" cx="280" cy="40" r="7"/>
          <circle class="m-dot" cx="216" cy="186" r="7"/>
          <circle class="m-dot" cx="195" cy="335" r="7"/>
          <circle class="m-dot m-dot--out" cx="390" cy="140" r="7"/>
          <circle class="m-dot m-dot--home" cx="280" cy="250" r="11"/>
          <text class="m-label m-label--big" x="298" y="276">ENNIS</text>
          <text class="m-label" x="204" y="178" text-anchor="end">WAXAHACHIE</text>
          <text class="m-label m-label--muted" x="204" y="196" text-anchor="end">15 mi · US 287</text>
          <text class="m-label" x="120" y="360">ITALY</text>
          <text class="m-label m-label--muted" x="120" y="378">20 mi · SH 34</text>
          <text class="m-label" x="404" y="130">KAUFMAN</text>
          <text class="m-label m-label--muted" x="404" y="148">26 mi · SH 34</text>
          <text class="m-label" x="270" y="36" text-anchor="end">DALLAS</text>
          <text class="m-label m-label--muted" x="270" y="53" text-anchor="end">35 mi north</text>
          <text class="m-label m-label--muted" x="338" y="404">I-45</text>
          <text class="m-label m-label--muted" x="196" y="300" text-anchor="end">LAKE BARDWELL</text>
          <text class="m-label m-label--accent" x="438" y="226">25 MI RING</text>
        </svg>
        <figcaption>Schematic, not a survey. Distances are the ones published for Ennis; directions are approximate. The dashed ring marks about <?php echo (int) $serviceRadiusMiles; ?> miles. Hollow dots sit at or beyond the edge of the ring.</figcaption>
      </figure>
    </div>
  </div>
</section>

<!-- ============ 4. SERVICES (required services component, all six) ============ -->
<section class="section sp-related en-services" aria-label="Fence services in Ennis">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which <span class="text-accent">fence services</span> does <?php echo h($siteName); ?> offer in Ennis, TX?</h2>
      <p class="hero-answer"><?php echo h($siteName); ?> handles all six fence jobs in Ennis: privacy fences, cedar fences, chain link, wrought iron, repairs of existing fences and gates, and new installations for homes, acreage and farm property. Pick the card that matches your project, or call and describe it, and the crew will set up a time to walk the line.</p>
      <span class="section-subtitle">Privacy · Cedar · Chain link · Wrought iron · Repair · Installation</span>
    </div>
    <div class="services-grid">
<?php foreach ($services as $enI => $enSvc):
        $enCard = $enCards[$enSvc['slug']];
        $enTint = ($enI % 3) + 1; ?>
      <article class="service-card-with-image card-tint-<?php echo $enTint; ?> reveal-up reveal-delay-<?php echo $enTint; ?>">
        <div class="service-card__body">
          <div class="service-card__head">
            <div class="service-card__icon"><?php echo icon($enCard['icon'], 24); ?></div>
            <h3><?php echo h($enSvc['name']); ?></h3>
          </div>
          <p class="service-card__desc"><?php echo h($enCard['desc']); ?></p>
          <ul>
<?php foreach ($enCard['bullets'] as $enBullet): ?>
            <li><?php echo h($enBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($enSvc['slug']); ?>/" class="service-card__cta">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 5. WHY D & D FENCE FOR ENNIS (company facts only) ============ -->
<section class="section sp-expert en-why texture-grain slant-top" aria-labelledby="why-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div class="sp-expert__grid">
      <div class="reveal-left">
        <span class="eyebrow">Why call us</span>
        <h2 id="why-title">Why do Ennis property owners call <?php echo h($siteName); ?> for fence work?</h2>
        <p class="answer-block"><?php echo h($siteName); ?> is owned by <?php echo h($ownerName); ?>, has <?php echo (int) $yearsInBusiness; ?> years in business, and is open Monday to Friday, 7 AM to 6 PM. One phone number covers a new run, a gate and a repair in Ennis.</p>
        <div class="prose">
          <p>A fence in Ennis usually starts with one of three calls: a section that has started to lean, a yard that needs closing in, or a stretch of acreage that needs a line. Whichever it is, tell <?php echo h($siteName); ?> the town, the rough length and what the fence has to do, and the crew will set up a time to walk the line.</p>
          <p>Bring your survey or plat if you have it. It settles where the fence can sit, and it saves a second trip. If the fence replaces an old one, say so up front; the <?php echo serviceLink('fence-repair', 'repair page'); ?> covers when a fix is enough and when a rebuild makes more sense.</p>
        </div>
      </div>
      <div class="reveal-right">
        <div class="sp-figure">
          <b><?php echo (int) $yearsInBusiness; ?><span> yrs</span></b>
          <span>in business under owner <?php echo h($ownerName); ?>, serving Ennis and about <?php echo (int) $serviceRadiusMiles; ?> miles around</span>
        </div>
        <ul class="sp-points">
          <li><?php echo icon('handshake', 22); ?><span><strong>Owner-led.</strong> Google reviewers name Austin as one of the people who measured, quoted and built their fences.</span></li>
          <li><?php echo icon('hammer', 22); ?><span><strong>New builds and repairs.</strong> Six services run under one name, from a full run to a gate that no longer latches.</span></li>
          <li><?php echo icon('clock', 22); ?><span><strong>Weekday hours.</strong> Open Monday to Friday, 7 AM to 6 PM; closed Saturday and Sunday.</span></li>
          <li><?php echo icon('map-pin', 22); ?><span><strong>Ennis and about <?php echo (int) $serviceRadiusMiles; ?> miles.</strong> The service area includes Waxahachie, 15 miles northwest on US 287.</span></li>
        </ul>
<?php if (!empty($gbp['url'])): ?>
        <p class="ap-reviews-link">See what customers say: <a href="<?php echo h($gbp['url']); ?>" target="_blank" rel="noopener nofollow">D &amp; D Fence on Google ↗</a></p>
<?php endif; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============ 7. FAQ (Ennis-specific; mirrored by FAQPage schema) ============ -->
<section class="section sp-faq" aria-labelledby="faq-title">
  <div class="container-narrow">
    <div class="sp-head reveal-down">
      <span class="eyebrow">Ennis fence questions</span>
      <h2 id="faq-title">What do Ennis homeowners ask before building a fence?</h2>
      <p class="answer-block">Ennis fence questions come down to permits, soil, acreage and older neighborhoods. The answers below come from <?php echo h($siteName); ?> and from the City of Ennis, USDA and Wikipedia pages linked in the page source; call <?php echo phoneLink(); ?> for anything specific to your address.</p>
    </div>
    <div class="faq-grid">
<?php foreach ($enFaqs as $enIdx => $enFaq): ?>
      <details class="faq"<?php echo $enIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo h($enFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo h($enFaq['a']); ?></p>
      </details>
<?php endforeach; ?>
    </div>
  </div>
</section>

</article>

<!-- ============ NEXT TOWN ============ -->
<section class="ap-next" aria-label="Other service areas">
  <div class="container">
    <div class="ap-next__inner">
      <div>
        <h2>Fencing a property in Waxahachie instead?</h2>
        <p>Waxahachie, the Ellis County seat, is 15 miles northwest of Ennis on US 287 and inside the same service area. Its fence permit checklist spells out heights, posts and gates.</p>
      </div>
<?php $enWax = areaHref('Waxahachie, TX'); if ($enWax): ?>
      <a class="btn btn-secondary" href="<?php echo h($enWax); ?>">Fence installation in Waxahachie →</a>
<?php endif; ?>
    </div>
  </div>
</section>

<!-- ============ 8. FINAL CTA ============ -->
<section class="cta-banner texture-grain edge-curve-top sp-cta en-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-copy reveal-scale">
      <span class="eyebrow">Ennis fence estimate</span>
      <h2 id="cta-title">Get a Free Estimate in Ennis</h2>
      <p>Send the rough length, the fence type and the part of Ennis the job is in, and <?php echo h($siteName); ?> will set up a time to walk the line with you.</p>
    </div>
    <div class="actions reveal-scale reveal-delay-2">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a Free Estimate in Ennis</button>
      <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
