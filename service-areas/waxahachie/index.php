<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /service-areas/waxahachie/ — D & D Fence (Phase 6, 2026-10-19). Premium city page. Opening angle: the RULES — the City of Waxahachie
 * publishes a residential fence permit checklist, so the page leads with it. Signature section: the checklist as a spec sheet.
 * No client photos on file: type hero with a board-and-steel-post motif; recent-work strip skipped until photos exist.
 *
 * RESEARCH (2026-10-19) — every local claim below traces to one of these sources:
 *   https://www.waxahachietx.gov/DocumentCenter/View/2311/Fence-Permit-Submittal-Guide — "Residential Fence/Retaining Wall Permit Application
 *       Submittal Checklist", Rev. 05/24 (PDF text read directly): permit type Building (Residential)-Fence/Wall via the online portal; min. 10
 *       working days review; construction + site plan; height max 8 ft from interior grade; materials new and designed as fence material;
 *       privacy fences = min. 13-gauge metal post at max 8 ft OR min. 15-gauge at max 6 ft, metal post caps, metal brackets, min. 2x4 cedar /
 *       pressure-treated / chemically treated cross members, finished-wood pickets; front yard = decorative, openings >= 50%, <= 3 ft (wrought iron,
 *       split rail, wooden picket) and chain link / woven wire NOT decorative; electrical, barbed, razor wire prohibited; vehicular gates set back
 *       >= 20 ft from the property line. Contact on the document: (469) 309-4020, bcservices@waxahachie.com. The document says it is informational,
 *       not all-inclusive, and that the Unified Development Code controls — the page says the same and tells readers to confirm.
 *   https://en.wikipedia.org/wiki/Waxahachie,_Texas — Ellis County seat; pop. 41,140 (2020), 2025 estimate 50,504; elevation 623 ft; I-35E bypasses the
 *       west side, US 287 through the north side (to Ennis on the east), US 77 through downtown; Ellis County Courthouse (Richardsonian Romanesque);
 *       Victorian / Gingerbread-style homes; Getzendaner Memorial Park with the 1902 Chautauqua Auditorium; Waxahachie ISD.
 *   https://www.waxahachiecvb.com/events/2025/gingerbread-trail2 and https://www.achp.gov/node/9673 — Gingerbread Trail home tour by the Ellis County
 *       Museum since 1968; courthouse completed 1897; five historic districts on the National Register.
 *   https://www.tshaonline.org/handbook/entries/ellis-county — Ellis County: 939 sq mi of Blackland Prairie, "level to rolling", 300–700 ft (Texas Almanac
 *       sidebar: up to 898 ft).
 *   https://phzmapi.org/75165.json — 2023 USDA hardiness zone for ZIP 75165: 8b (15–20 °F minimum); same as Ennis, so zone is not used in the copy.
 * ELEVATION: Wikipedia gives 623 ft; other sources differ, so the page says only "a little over 600 feet".
 * NOT CLAIMED: how often D & D Fence works in Waxahachie, who files the permit (unknown — the page tells the reader to ask), any job count,
 *   any HOA or historic-district rule beyond "ask the City", Scarborough Renaissance Festival / SAGU (no fence relevance).
 * Open questions are listed under /service-areas/waxahachie/ in /content-confirmations.json.
 */
$waTown = ['slug' => 'waxahachie', 'name' => 'Waxahachie', 'wiki' => 'https://en.wikipedia.org/wiki/Waxahachie,_Texas'];

$pageTitle       = 'Fence Contractor in Waxahachie, TX | Permit Rules | ' . $siteName;
$pageDescription = 'D & D Fence installs and repairs privacy, cedar, chain link and wrought iron fences in Waxahachie, TX, planned around the City\'s permit rules. (469) 321-7783.';
$canonicalUrl    = $siteUrl . '/service-areas/waxahachie/';
$ogImage         = defaultOgImage();
$currentPage     = 'service-areas';
$pageType        = 'city';
$citySlug        = 'waxahachie';
$heroFormTitle   = 'Free estimate in Waxahachie';
$svc             = serviceBySlug('fence-installation');   // preselects the hero form's service

$waFaqs = [
    ['q' => 'Do I need a permit to build a fence in Waxahachie?',
     'a' => 'The City of Waxahachie has a Residential Fence/Retaining Wall permit, filed through its online permitting portal with a construction and site plan that shows the fence line, height and materials. The City asks you to allow a minimum of 10 working days for review. Its checklist is informational and the Unified Development Code controls, so confirm the current rules for your address with the City at (469) 309-4020 before you submit.'],
    ['q' => 'What kind of posts does Waxahachie require for a privacy fence?',
     'a' => 'The City\'s checklist calls for metal support posts on privacy fences: a minimum 13-gauge post set no more than 8 feet apart, or a minimum 15-gauge post set no more than 6 feet apart, with metal caps and metal brackets for the cross members. Cross members must be at least 2x4 cedar, pressure-treated or chemically treated lumber, and the pickets must be finished wood.'],
    ['q' => 'Can I put a chain link fence in my front yard in Waxahachie?',
     'a' => 'Probably not. The City\'s checklist limits front-yard fences to decorative styles with openings of at least 50 percent of the fence area and a height of 3 feet or less, and it lists wrought iron, split rail and wooden picket as examples. It says chain link and woven wire are not considered decorative fencing. Confirm your address with the City before you order materials.'],
    ['q' => 'Who files the fence permit in Waxahachie, the homeowner or D & D Fence?',
     'a' => 'Settle that when you ask for your estimate. The City wants a site plan showing the fence line, the height and the materials, and it reviews the application for at least 10 working days. Call D & D Fence at (469) 321-7783 and ask whether the company will prepare and file the plan or whether you will, so the review clock starts as early as it can.'],
];

$schemaMarkup = areaPageSchema(
    $waTown,
    'Fence Contractor in Waxahachie, TX',
    'D & D Fence installs and repairs privacy, cedar, chain link and wrought iron fences and gates in Waxahachie, TX, planned around the City of Waxahachie residential fence permit checklist.',
    $waFaqs
);

$waCards   = serviceCards();
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-page.css'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/area-page.css'; ?>

/* ==========================================================================
   Waxahachie — page-specific composition: board-and-steel-post hero motif, permit spec sheet (signature),
   gingerbread-trim rule on the town cards, four-tile "what we bring" band. Tokens only.
   ========================================================================== */
.wa-hero .sp-hero__motif { opacity: .07; }
.wa-hero .eyebrow::before { width: 38px; }

/* Signature: permit checklist as a spec sheet */
.wa-rules { background: var(--color-paper-2); }
.wa-rules .sp-compare__grid { display: grid; grid-template-columns: minmax(0, .72fr) minmax(0, 1.6fr); gap: clamp(2rem, 4vw, 3.5rem); align-items: start; }
.wa-rules .sp-head { position: sticky; top: calc(var(--nav-height) + var(--space-6)); }
.wa-rules .sp-sheet::before {
  content: "";
  position: absolute;
  inset: 0 0 auto 0;
  height: 8px;
  background: repeating-linear-gradient(90deg, var(--color-accent) 0 28px, var(--color-accent-dark) 28px 32px);
}
.wa-rules .sp-sheet__head { padding-top: var(--space-8); }
.wa-rules .sp-table tbody th { font-size: .95rem; }
@media (max-width: 1040px) { .wa-rules .sp-compare__grid { grid-template-columns: 1fr; } .wa-rules .sp-head { position: static; } }

/* Town specifics: first card carries a trim edge (Victorian gingerbread) */
.wa-town .sp-bento > li:first-child { background: var(--color-card-tint-3); }
.wa-town .sp-bento > li:nth-child(2) { background: var(--color-card-tint-1); }
@media (min-width: 901px) { .wa-town .sp-bento > li:nth-child(2) { grid-column: span 2; } }
.wa-town .sp-bento > li:nth-child(2)::after {
  content: "";
  position: absolute;
  inset: auto var(--space-6) 0 var(--space-6);
  height: 10px;
  background: radial-gradient(circle at 10px 0, transparent 7px, color-mix(in srgb, var(--color-accent) 55%, transparent) 7.5px 9px, transparent 9.5px) 0 0 / 20px 10px repeat-x;
}
.wa-town .sp-signs__intro .pull-quote { max-width: 18ch; }

/* From call to fence: timeline beside a have-ready list */
.wa-flow .sp-timeline > li:nth-child(2)::before { background: var(--color-accent); color: var(--color-white); }

/* Why band: four tiles instead of a split */
.wa-why .wa-why__head { display: grid; gap: var(--space-3); max-width: 62ch; margin-bottom: clamp(1.75rem, 3vw, 2.5rem); }
.wa-why .wa-why__head h2 { color: var(--color-white); }
.wa-why .wa-why__head .answer-block { margin: 0; }
.wa-tiles { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: var(--space-4); margin: 0; padding: 0; list-style: none; }
.wa-tiles li { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-6); border-radius: var(--radius-lg); border: 1px solid color-mix(in srgb, var(--color-white) 16%, transparent); background: color-mix(in srgb, var(--color-white) 6%, transparent); }
.wa-tiles li:nth-child(even) { transform: translateY(var(--space-5)); }
.wa-tiles svg { color: var(--color-accent-bright); }
.wa-tiles b { font-family: var(--font-heading); font-size: 1.35rem; color: var(--color-white); line-height: 1.15; }
.wa-tiles span { font-size: .93rem; color: color-mix(in srgb, var(--color-white) 76%, transparent); }
.wa-why .floating-ring { right: -160px; top: -150px; }
.wa-why { padding-bottom: calc(var(--section-pad) + var(--space-5)); }
@media (max-width: 960px) { .wa-tiles { grid-template-columns: repeat(2, minmax(0, 1fr)); } }
@media (max-width: 520px) { .wa-tiles { grid-template-columns: 1fr; } .wa-tiles li:nth-child(even) { transform: none; } }

.wa-cta .floating-ring { opacity: .08; }
@media (prefers-reduced-motion: reduce) { .wa-tiles li:nth-child(even) { transform: none; } }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ 1. HERO (type hero, board-and-steel-post motif; no client photo on file yet) ============ -->
<section class="hero hero--interior sp-hero wa-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="sp-hero__motif" aria-hidden="true">
    <svg viewBox="0 0 720 420" preserveAspectRatio="xMaxYMax slice" focusable="false">
      <defs>
        <pattern id="wa-boards" width="192" height="420" patternUnits="userSpaceOnUse">
          <path d="M0 40 h8 v380 h-8 Z M184 40 h8 v380 h-8 Z" fill="currentColor"/>
          <path d="M4 36 h0 M-2 40 h20 M180 40 h20" stroke="currentColor" stroke-width="5" fill="none"/>
          <path d="M18 70 l8 -9 h10 l8 9 V420 H18 Z M56 70 l8 -9 h10 l8 9 V420 H56 Z M94 70 l8 -9 h10 l8 9 V420 H94 Z M132 70 l8 -9 h10 l8 9 V420 H132 Z" fill="currentColor"/>
        </pattern>
      </defs>
      <rect x="0" y="0" width="720" height="420" fill="url(#wa-boards)"/>
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
            <li><span aria-current="page">Waxahachie, TX</span></li>
          </ol>
        </nav>
        <span class="eyebrow">Fence contractor · Waxahachie, Ellis County seat</span>
        <h1 class="hero-title" id="hero-title">Fence Installation in <span class="text-accent">Waxahachie</span>, TX</h1>
        <p class="hero-answer"><?php echo h($siteName); ?> installs and repairs privacy, cedar, chain link and wrought iron fences in Waxahachie, planned around the City's fence permit checklist for height, posts and gates.</p>
        <div class="hero-actions">
          <button type="button" class="btn btn-primary btn-lg hero-form-open" data-open-estimate>Get a free estimate</button>
          <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
        </div>
        <ul class="hero-chips">
          <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
          <li><?php echo icon('map-pin', 16); ?>Waxahachie &amp; about <?php echo (int) $serviceRadiusMiles; ?> miles around</li>
          <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
        </ul>
      </div>

      <aside class="hero-form-card" id="estimate-form" aria-labelledby="hero-form-title">
        <h2 id="hero-form-title"><?php echo h($heroFormTitle); ?></h2>
        <p class="hero-form-tagline">No obligation. <b>Waxahachie &amp; nearby.</b></p>
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

<!-- ============ 2. SIGNATURE: the City's residential fence permit checklist as a spec sheet ============ -->
<section class="section sp-compare wa-rules" aria-labelledby="rules-title">
  <div class="container-wide">
    <div class="sp-compare__grid">
      <div class="sp-head reveal-left">
        <span class="eyebrow">The City's rules</span>
        <h2 id="rules-title">Does Waxahachie require a permit to build a <span class="text-accent">fence</span>?</h2>
        <p class="answer-block">Yes. The City of Waxahachie has a Residential Fence/Retaining Wall permit, filed online with a site plan, and it asks you to allow at least 10 working days for review. The checklist sets an 8-foot height limit and spells out posts, front-yard fences and driveway gates.</p>
        <p>The sheet beside this text lists what the City's checklist says and what each rule means for the fence you are planning. <?php echo h($siteName); ?> can go over your address with you when it walks the line.</p>
      </div>

      <div class="sp-sheet ap-sheet reveal-right">
        <div class="sp-sheet__head"><span>City of Waxahachie</span><b>Residential fence permit checklist, at a glance</b></div>
        <div class="table-scroll" role="region" aria-label="City of Waxahachie residential fence permit checklist" tabindex="0">
          <table class="sp-table">
            <caption class="sr-only">What the City of Waxahachie residential fence permit checklist requires, and what each rule means for a fence project</caption>
            <thead>
              <tr><th scope="col">Rule</th><th scope="col">What the City's checklist says</th><th scope="col">On your fence</th></tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">Permit &amp; review<small>Building (Residential) – Fence/Wall</small></th>
                <td data-label="What the City's checklist says">Submitted through the City's online permitting portal. Allow a minimum of 10 working days for review.</td>
                <td data-label="On your fence">Build the review time into your schedule before you set a start date.</td>
              </tr>
              <tr>
                <th scope="row">Site plan<small>Required document</small></th>
                <td data-label="What the City's checklist says">A construction and site plan showing the proposed fence line on the property, with the fence height and the type of materials clearly indicated.</td>
                <td data-label="On your fence">Your survey or plat is the starting point for the drawing.</td>
              </tr>
              <tr>
                <th scope="row">Height</th>
                <td data-label="What the City's checklist says">May not exceed 8 feet, measured from the interior grade of the property.</td>
                <td data-label="On your fence">Eight feet is the ceiling on any Waxahachie lot, not a default.</td>
              </tr>
              <tr>
                <th scope="row">Materials</th>
                <td data-label="What the City's checklist says">All fence materials must be new and designed to be used as fence material.</td>
                <td data-label="On your fence">Salvaged or repurposed lumber does not fit this rule.</td>
              </tr>
              <tr>
                <th scope="row"><span class="ap-tag">Privacy fences</span>Posts &amp; rails</th>
                <td data-label="What the City's checklist says">Minimum 13-gauge metal posts at most every 8 feet, or minimum 15-gauge metal posts at most every 6 feet; metal post caps; metal brackets for the cross members; cross members at least 2x4 cedar, pressure-treated or chemically treated; pickets of finished wood.</td>
                <td data-label="On your fence">The post gauge sets the spacing, and the spacing sets how many posts a run needs. See the <?php echo serviceLink('privacy-fence', 'privacy fence page'); ?> for board layouts.</td>
              </tr>
              <tr>
                <th scope="row"><span class="ap-tag">Front yards</span>Open, low fences</th>
                <td data-label="What the City's checklist says">Decorative fences with openings of at least 50 percent of the fence area and a height of 3 feet or less. Wrought iron, split rail and wooden picket are listed as examples; chain link, woven wire and similar materials are not considered decorative.</td>
                <td data-label="On your fence"><?php echo serviceLink('wrought-iron', 'Wrought iron'); ?> fits a front yard here; <?php echo serviceLink('chain-link', 'chain link'); ?> does not count as decorative.</td>
              </tr>
              <tr>
                <th scope="row">Prohibited</th>
                <td data-label="What the City's checklist says">Electrical, barbed and razor-wire fences are prohibited.</td>
                <td data-label="On your fence">This is the City's residential checklist. For land outside city limits, ask before you assume.</td>
              </tr>
              <tr>
                <th scope="row">Vehicle gates</th>
                <td data-label="What the City's checklist says">Gates designed for vehicles must be set back from the property line a minimum of 20 feet.</td>
                <td data-label="On your fence">Place the drive gate before the layout is final, because it moves the whole gate line back from the street.</td>
              </tr>
            </tbody>
          </table>
        </div>
        <p class="sp-sheet__foot">Source: City of Waxahachie, Residential Fence/Retaining Wall Permit Application Submittal Checklist (revision dated 05/24). The City states that the checklist is informational and not all-inclusive, and that its Unified Development Code controls. Confirm the current version at (469) 309-4020 or bcservices@waxahachie.com before you submit.</p>
      </div>
    </div>
  </div>
</section>

<!-- ============ 3. THE TOWN: local specifics (pull quote + bento) ============ -->
<section class="section sp-signs wa-town" aria-labelledby="town-title">
  <div class="container-wide">
    <div class="sp-signs__layout">
      <div class="sp-signs__intro reveal-left">
        <span class="eyebrow">The county seat</span>
        <h2 id="town-title">What is it like to fence a property in <span class="text-accent">Waxahachie</span>?</h2>
        <p class="answer-block">Waxahachie is the Ellis County seat, a Victorian-era town with a growing edge. Older streets near downtown reward a fence that suits the house, and newer subdivisions come with HOA rules. <?php echo h($siteName); ?> fences both, from front-yard wrought iron to a full privacy run.</p>
        <p class="pull-quote">The permit sets the posts. The house sets the style.</p>
      </div>

      <ul class="sp-bento" aria-label="Local details that shape a fence in Waxahachie">
        <li class="reveal-up reveal-delay-1">
          <?php echo icon('landmark', 26); ?>
          <h3>A courthouse square from 1897</h3>
          <p>The Ellis County Courthouse, finished in 1897 and built in the Richardsonian Romanesque style, anchors downtown. The streets around it hold the town's oldest lots, so the survey comes first.</p>
        </li>
        <li class="reveal-up reveal-delay-2">
          <?php echo icon('home', 26); ?>
          <h3>Gingerbread City and its historic districts</h3>
          <p>Waxahachie's nickname comes from its restored Victorian houses, and the Ellis County Museum's Gingerbread Trail home tour has run since 1968. Five historic districts are listed on the National Register of Historic Places. If your house sits in one, ask the City whether a style needs extra review, then look at <?php echo serviceLink('wrought-iron', 'wrought iron'); ?> or a <?php echo serviceLink('cedar-fence', 'cedar fence'); ?>, which frame an older house well.</p>
        </li>
        <li class="reveal-up reveal-delay-3">
          <?php echo icon('users', 26); ?>
          <h3>A city adding neighbors fast</h3>
          <p>Waxahachie counted 41,140 residents in the 2020 census, and Wikipedia lists a 2025 estimate of 50,504. HOAs commonly control a fence's height, board style, stain color and which side faces the street, so read your covenants before you pick a layout.</p>
        </li>
        <li class="reveal-up reveal-delay-1">
          <?php echo icon('route', 26); ?>
          <h3>Three highways, one county seat</h3>
          <p>I-35E bypasses the west side, US 287 crosses the north side toward Ennis, 15 miles east, and US 77 runs through downtown. Both towns sit inside the same service area.</p>
        </li>
        <li class="reveal-up reveal-delay-2">
          <?php echo icon('mountain', 26); ?>
          <h3>Rolling ground, a little over 600 feet up</h3>
          <p>The Texas State Historical Association describes Ellis County terrain as level to rolling, and Waxahachie sits a little over 600 feet above sea level. On a sloped lot the fence follows the grade, and the layout is settled when the line is walked. Nearly all of the county is Blackland Prairie clay, so the post advice on the <?php echo serviceLink('fence-repair', 'repair page'); ?> applies here too.</p>
        </li>
        <li class="reveal-up reveal-delay-3">
          <?php echo icon('trees', 26); ?>
          <h3>Parks and lakes at the edge of town</h3>
          <p>Getzendaner Memorial Park holds the 1902 Chautauqua Auditorium, and Lake Waxahachie offers camping and fishing. Properties out past the edge of town may fall outside the City's rules, which is one more reason to ask the City before you plan around the checklist.</p>
        </li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ 4. FROM CALL TO FENCE: timeline + have-ready list ============ -->
<section class="section sp-scope wa-flow" aria-labelledby="flow-title">
  <div class="container">
    <div class="sp-scope__grid">
      <div class="sp-scope__aside reveal-left">
        <span class="eyebrow">From call to fence</span>
        <h2 id="flow-title">How does a fence job run in Waxahachie, permit included?</h2>
        <p class="answer-block">A Waxahachie fence job runs in four steps: walk the line, prepare the plan the City asks for, wait out the review, then build. The review alone is at least 10 working days, so the earlier the plan is filed, the sooner the posts go in.</p>
        <ul class="sp-included">
          <li><?php echo icon('check', 18); ?><span>Your survey or plat, if you have it</span></li>
          <li><?php echo icon('check', 18); ?><span>Rough length, height and fence type</span></li>
          <li><?php echo icon('check', 18); ?><span>Your HOA covenants, if there is an HOA</span></li>
          <li><?php echo icon('check', 18); ?><span>Where the walk gates and drive gate should go</span></li>
          <li><?php echo icon('check', 18); ?><span>Whether an old fence is coming out first</span></li>
        </ul>
        <p class="footnote">Already have a fence that is failing? Start with <?php echo serviceLink('fence-repair', 'fence repair'); ?>, or see <a class="sp-link" href="/services/">all six fence services</a>.</p>
      </div>

      <div>
        <h3 class="sr-only">How a Waxahachie fence job runs</h3>
        <ol class="sp-timeline">
          <li class="reveal-up">
            <h3>Walk the line and pull the survey</h3>
            <p><?php echo h($siteName); ?> walks the yard with you, measures the run and notes the grade, trees, utility boxes and where the gates need to go. Your plat or survey settles where the fence can sit.</p>
          </li>
          <li class="reveal-up">
            <h3>Prepare the plan the City asks for</h3>
            <p>The City wants a construction and site plan showing the fence line, the height and the materials. Settle at the estimate who prepares and files it, and whether the plan has to account for the metal posts a privacy fence needs.</p>
          </li>
          <li class="reveal-up">
            <h3>Wait out the review</h3>
            <p>The City asks you to allow a minimum of 10 working days. Use the time to choose a gate style and a finish, and to check your HOA's rules on color and which side faces out.</p>
          </li>
          <li class="reveal-up">
            <h3>Build to the checklist</h3>
            <p>Posts go in along the string line, rails follow, and the pickets or panels go on last. On a privacy fence that means metal posts, caps and brackets, and a drive gate set back from the property line.</p>
          </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<!-- ============ 5. SERVICES (required services component, all six) ============ -->
<section class="section sp-related wa-services" aria-label="Fence services in Waxahachie">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>Which fence jobs can <?php echo h($siteName); ?> take on in <span class="text-accent">Waxahachie</span>?</h2>
      <p class="hero-answer">From a wrought iron front-yard fence to a cedar privacy run, <?php echo h($siteName); ?> covers all six services in Waxahachie: privacy fences, cedar fences, chain link, wrought iron, repairs and new fence and gate installation. Each card links to the details, and the crew walks the line with you before anything is priced.</p>
      <span class="section-subtitle">Front-yard iron · Privacy runs · Cedar · Chain link · Repair · Gates</span>
    </div>
    <div class="services-grid">
<?php foreach ($services as $waI => $waSvc):
        $waCard = $waCards[$waSvc['slug']];
        $waTint = (($waI + 1) % 3) + 1; ?>
      <article class="service-card-with-image card-tint-<?php echo $waTint; ?> reveal-up reveal-delay-<?php echo $waTint; ?>">
        <div class="service-card__body">
          <div class="service-card__head">
            <div class="service-card__icon"><?php echo icon($waCard['icon'], 24); ?></div>
            <h3><?php echo h($waSvc['name']); ?></h3>
          </div>
          <p class="service-card__desc"><?php echo h($waCard['desc']); ?></p>
          <ul>
<?php foreach ($waCard['bullets'] as $waBullet): ?>
            <li><?php echo h($waBullet); ?></li>
<?php endforeach; ?>
          </ul>
          <a href="/services/<?php echo h($waSvc['slug']); ?>/" class="service-card__cta">Learn more</a>
        </div>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ 6. WHY D & D FENCE FOR WAXAHACHIE (company facts only; four tiles) ============ -->
<section class="section sp-expert wa-why texture-grain edge-wave-top" aria-labelledby="why-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate-slow" aria-hidden="true"></span>
  <div class="container">
    <div class="wa-why__head reveal-up">
      <span class="eyebrow">Why call us</span>
      <h2 id="why-title">What does <?php echo h($siteName); ?> bring to a Waxahachie fence job?</h2>
      <p class="answer-block"><?php echo h($siteName); ?> is owned by <?php echo h($ownerName); ?> and has <?php echo (int) $yearsInBusiness; ?> years in business. For a Waxahachie job that means a direct phone line on weekdays, one company for the build, the gates and the repairs, and a straight answer about what the City's checklist means for your plan.</p>
    </div>
    <ul class="wa-tiles">
      <li class="reveal-up reveal-delay-1"><?php echo icon('handshake', 28); ?><b><?php echo h($ownerName); ?></b><span>Owner of <?php echo h($siteName); ?>. Google reviewers name Austin as one of the people who built their fences.</span></li>
      <li class="reveal-up reveal-delay-2"><?php echo icon('badge-check', 28); ?><b><?php echo (int) $yearsInBusiness; ?> years</b><span>in business building and repairing fences in Ellis County.</span></li>
      <li class="reveal-up reveal-delay-3"><?php echo icon('clock', 28); ?><b>Mon–Fri, 7–6</b><span>Open 7 AM to 6 PM on weekdays; closed Saturday and Sunday.</span></li>
      <li class="reveal-up reveal-delay-4"><?php echo icon('map-pin', 28); ?><b>~<?php echo (int) $serviceRadiusMiles; ?> miles</b><span>around Waxahachie and Ennis, 15 miles apart on US 287.</span></li>
    </ul>
<?php if (!empty($gbp['url'])): ?>
    <p class="ap-reviews-link">See what customers say: <a href="<?php echo h($gbp['url']); ?>" target="_blank" rel="noopener nofollow">D &amp; D Fence on Google ↗</a></p>
<?php endif; ?>
  </div>
</section>

<!-- ============ 8. FAQ (Waxahachie-specific; mirrored by FAQPage schema) ============ -->
<section class="section sp-faq" aria-labelledby="faq-title">
  <div class="container-narrow">
    <div class="sp-head reveal-down">
      <span class="eyebrow">Waxahachie fence questions</span>
      <h2 id="faq-title">What do Waxahachie homeowners ask before building a fence?</h2>
      <p class="answer-block">Waxahachie fence questions start with the City's permit checklist: who files, how long review takes, which posts a privacy fence needs and what can go in a front yard. The answers below come from the City's published checklist; call <?php echo phoneLink(); ?> for anything specific to your address.</p>
    </div>
    <div class="faq-grid">
<?php foreach ($waFaqs as $waIdx => $waFaq): ?>
      <details class="faq"<?php echo $waIdx === 0 ? ' open' : ''; ?>>
        <summary><?php echo h($waFaq['q']); ?></summary>
        <p class="faq-answer"><?php echo h($waFaq['a']); ?></p>
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
        <h2>Fencing a property in Ennis instead?</h2>
        <p>Ennis sits 15 miles southeast of Waxahachie on US 287, on Blackland Prairie clay that moves with the weather. The Ennis page covers what that does to posts.</p>
      </div>
<?php $waEnnis = areaHref('Ennis, TX'); if ($waEnnis): ?>
      <a class="btn btn-secondary" href="<?php echo h($waEnnis); ?>">Fence installation in Ennis →</a>
<?php endif; ?>
    </div>
  </div>
</section>

<!-- ============ 9. FINAL CTA ============ -->
<section class="cta-banner texture-grain slant-top sp-cta wa-cta" aria-labelledby="cta-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <span class="floating-ring float-animate" aria-hidden="true"></span>
  <div class="container">
    <div class="cta-copy reveal-scale">
      <span class="eyebrow">Waxahachie fence estimate</span>
      <h2 id="cta-title">Get a Free Estimate in Waxahachie</h2>
      <p>Send the rough length, the fence type and your side of Waxahachie, and <?php echo h($siteName); ?> will set up a time to walk the line and talk through the City's permit steps.</p>
    </div>
    <div class="actions reveal-scale reveal-delay-2">
      <button type="button" class="btn btn-accent btn-lg" data-open-estimate>Get a Free Estimate in Waxahachie</button>
      <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
