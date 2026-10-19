<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /contact/ — Contact (Phase 5, 2026-10-19). The full estimate form (the only page that keeps the full form), hours board with a
 * live open/closed line (America/Chicago), and the service-area panel.
 * Form contract (leads endpoint, db.pageone.cloud): fields name / phone / email / service / message; honeypot `_honey` (what the endpoint reads)
 * plus the requested `_honeypot`; three separate unchecked consent boxes, terms_accepted required; `_consent_version` / `_consent_page`
 * hidden fields (the endpoint reads the underscore names); attribution + spam-shield fields come from p1_lead_hidden_fields('contact').
 * Map: integrations.gbp_map_embed is null and address_public is false, so no map iframe and no directions button are printed;
 * the .map-embed block below renders itself the moment config.php gets a gbp['embed_src'].
 */
$pageTitle       = 'Contact ' . $siteName . ' | Free Fence Estimate, Ennis & Waxahachie';
$pageDescription = 'Call ' . $phone . ' or send the form for a free fence estimate from ' . $siteName . ' in Ennis, Waxahachie and Ellis County, TX. Open Monday to Friday, 7 AM to 6 PM.';
$canonicalUrl    = $siteUrl . '/contact/';
$ogImage         = defaultOgImage();
$currentPage     = 'contact';
$pageType        = 'contact';

// Open / closed line, computed in the business's own time zone.
$ctNow  = new DateTimeImmutable('now', new DateTimeZone('America/Chicago'));
$ctDow  = (int) $ctNow->format('N') - 1;                       // 0 = Monday
$ctTime = $ctNow->format('H:i');
$ctFmt  = fn(string $ctHm): string => date('g:i A', strtotime($ctHm));
$ctToday = $hours[$ctDow];
$ctOpenNow = !empty($ctToday['opens']) && $ctTime >= $ctToday['opens'] && $ctTime < $ctToday['closes'];
if ($ctOpenNow) {
    $ctStatus = 'Open now until ' . $ctFmt($ctToday['closes']);
} else {
    $ctStatus = 'Closed right now';
    for ($ctStep = 0; $ctStep < 8; $ctStep++) {
        $ctRow = $hours[($ctDow + $ctStep) % 7];
        if (empty($ctRow['opens'])) continue;
        if ($ctStep === 0 && $ctTime >= $ctRow['opens']) continue;   // today's hours already over
        $ctStatus .= ' · opens ' . ($ctStep === 0 ? 'today' : ($ctStep === 1 ? 'tomorrow' : $ctRow['day'])) . ' at ' . $ctFmt($ctRow['opens']);
        break;
    }
}

$ctBase   = rtrim($siteUrl, '/');
$ctCrumbs = generateBreadcrumbSchema([['name' => 'Home', 'url' => '/'], ['name' => 'Contact', 'url' => '/contact/']]);
unset($ctCrumbs['@context']);
$ctCrumbs['@id'] = $canonicalUrl . '#breadcrumb';
$schemaMarkup = ['@context' => 'https://schema.org', '@graph' => [
    ['@type' => 'ContactPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => 'Contact ' . $siteName, 'description' => $pageDescription,
     'isPartOf' => ['@id' => $ctBase . '/#website'], 'about' => ['@id' => $ctBase . '/#organization'], 'breadcrumb' => ['@id' => $ctCrumbs['@id']],
     'mainEntity' => ['@id' => $ctBase . '/#organization']],
    $ctCrumbs,
]];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   /contact/ — page-specific composition (D & D Fence, rustic, no photos yet).
   Type hero, full estimate form card beside a hours board + next-steps rail, service-area panel. Tokens only (var()).
   ========================================================================== */

/* ---------- Hero ---------- */
.ct-hero {
  background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 125%);
  padding-bottom: clamp(2.5rem, 5vw, 3.75rem);
}
.ct-hero::before {
  content: "";
  position: absolute;
  inset: -30% auto auto -12%;
  width: 70%;
  height: 150%;
  z-index: -1;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 72%);
  pointer-events: none;
}
.ct-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  opacity: .07;
  pointer-events: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='g'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23g)'/%3E%3C/svg%3E");
}
.ct-hero .breadcrumb { align-items: center; color: color-mix(in srgb, var(--color-white) 62%, transparent); margin-bottom: var(--space-2); }
.ct-hero .breadcrumb a:hover { color: var(--color-white); }
.ct-hero .breadcrumb [aria-current] { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.ct-hero .hero-copy { display: grid; gap: var(--space-4); max-width: 46rem; }
.ct-hero .hero-title { color: var(--color-white); text-wrap: balance; }
.ct-hero .hero-title .text-accent { color: var(--color-accent-bright); }
.ct-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); text-wrap: pretty; max-width: 40rem; }
.ct-hero .hero-chips li { background: color-mix(in srgb, var(--color-white) 7%, transparent); border-color: color-mix(in srgb, var(--color-white) 20%, transparent); color: var(--color-white); }
.ct-hero .hero-chips svg { color: var(--color-accent-bright); }
.ct-hero .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.ct-hero .link-call svg { color: var(--color-accent-bright); }
.ct-hero .link-call:hover { color: var(--color-white); }

/* ---------- Form + rail ---------- */
.ct-main { background: var(--color-paper); }
.ct-grid { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(0, .85fr); gap: clamp(1.75rem, 4vw, 3.5rem); align-items: start; }
.ct-form-card { display: grid; gap: var(--space-4); padding: clamp(1.5rem, 3vw, 2.25rem); background: var(--color-surface); border: 1px solid var(--color-line); border-top: 4px solid var(--color-accent); border-radius: var(--radius-lg); box-shadow: var(--shadow); }
.ct-form-card h2 { text-wrap: balance; }
.ct-form-card > p { margin: 0; color: var(--color-ink-2); }
.ct-form-card .form-consent-fieldset { margin-top: var(--space-2); padding: var(--space-4); border: 1px solid var(--color-line); border-radius: var(--radius); background: var(--color-paper-2); }
.ct-form-card .form-consent-legend { padding-inline: var(--space-2); color: var(--color-ink); }
.ct-form-card .form-consent-item { margin-block: var(--space-2); }
.ct-form-card .form-consent-item span { color: var(--color-ink-2); }
.ct-form-card .form-consent-item a { text-decoration: underline; text-underline-offset: .18em; }
.ct-form-card textarea { min-height: 7.5rem; resize: vertical; }
.ct-rail { display: grid; gap: var(--space-5); position: sticky; top: calc(var(--nav-height) + var(--space-6)); }

/* Phone card (dark) */
.ct-call { position: relative; isolation: isolate; overflow: clip; display: grid; gap: var(--space-2); padding: var(--space-6); border-radius: var(--radius-lg); color: var(--color-paper); background: linear-gradient(125deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 130%); box-shadow: var(--shadow-lg); }
.ct-call .eyebrow { color: var(--color-accent-bright); }
.ct-call__number { font-family: var(--font-heading); font-weight: 700; font-size: clamp(1.7rem, 3.4vw, 2.2rem); line-height: 1.1; color: var(--color-white); text-decoration: none; }
.ct-call__number:hover { color: var(--color-accent-bright); }
.ct-call p { margin: 0; font-size: .95rem; color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.ct-call .nap { margin-top: var(--space-2); color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.ct-call .nap svg { color: var(--color-accent-bright); }
.ct-call .nap a { text-decoration: underline; text-underline-offset: .18em; }

/* Hours board */
.ct-hours { padding: var(--space-5) var(--space-6); background: var(--color-surface); border: 1px solid var(--color-line); border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); }
.ct-hours h2 { font-size: 1.15rem; margin-bottom: var(--space-1); }
.ct-hours__status { display: inline-flex; align-items: center; gap: var(--space-2); margin: 0 0 var(--space-3); font-size: .9rem; font-weight: 600; color: var(--color-ink-2); }
.ct-hours__status::before { content: ""; width: 10px; height: 10px; border-radius: 50%; background: var(--color-muted); }
.ct-hours__status.is-open { color: var(--color-success); }
.ct-hours__status.is-open::before { background: var(--color-success); box-shadow: 0 0 0 4px color-mix(in srgb, var(--color-success) 22%, transparent); }
.ct-hours dl { margin: 0; display: grid; }
.ct-hours dl > div { display: flex; justify-content: space-between; gap: var(--space-4); padding: .5rem 0; border-top: 1px solid var(--color-line); font-size: .95rem; }
.ct-hours dl > div:first-child { border-top: 0; }
.ct-hours dt { font-weight: 600; color: var(--color-ink); }
.ct-hours dd { margin: 0; color: var(--color-ink-2); text-align: right; }
.ct-hours dl > div.is-today { margin-inline: calc(-1 * var(--space-2)); padding-inline: var(--space-2); border-radius: var(--radius-sm); background: color-mix(in srgb, var(--color-accent) 10%, transparent); border-top-color: transparent; }
.ct-hours dl > div.is-closed dd { color: var(--color-muted); }

/* Next steps */
.ct-next { padding: var(--space-5) var(--space-6); background: var(--color-paper-2); border: 1px solid var(--color-line); border-radius: var(--radius-lg); }
.ct-next h2 { font-size: 1.15rem; }
@media (max-width: 960px) {
  .ct-grid { grid-template-columns: 1fr; }
  .ct-rail { position: static; }
}

/* ---------- Service area panel ---------- */
.ct-area { background: var(--color-surface); }
.ct-area__grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: clamp(2rem, 5vw, 4rem); align-items: center; }
.ct-area__copy { display: grid; gap: var(--space-4); }
.ct-area__copy h2 { text-wrap: balance; }
.ct-area__copy p { margin: 0; color: var(--color-ink-2); max-width: 56ch; }
.ct-area__links { display: flex; flex-wrap: wrap; gap: var(--space-3); align-items: center; }
.ct-area__panel { position: relative; isolation: isolate; overflow: clip; display: grid; gap: var(--space-4); padding: clamp(1.5rem, 3vw, 2.25rem); border-radius: var(--radius-lg); color: var(--color-paper); background: linear-gradient(125deg, var(--color-dark) 0%, var(--color-dark-alt) 60%, var(--color-primary-deep) 130%); box-shadow: var(--shadow-lg); }
.ct-area__panel h3 { color: var(--color-white); }
.ct-area__radius { font-family: var(--font-accent); font-weight: 700; font-size: clamp(2.4rem, 6vw, 3.4rem); line-height: 1; color: var(--color-accent-bright); }
.ct-area__radius small { font-size: .9rem; letter-spacing: .12em; text-transform: uppercase; color: color-mix(in srgb, var(--color-white) 70%, transparent); }
.ct-area__towns { display: flex; flex-wrap: wrap; gap: var(--space-2); margin: 0; padding: 0; list-style: none; }
.ct-area__towns li { display: inline-flex; align-items: center; gap: var(--space-2); padding: .4rem .9rem; border-radius: var(--radius-full); border: 1px solid color-mix(in srgb, var(--color-white) 22%, transparent); background: color-mix(in srgb, var(--color-white) 7%, transparent); font-weight: 600; font-size: .95rem; }
.ct-area__towns svg { color: var(--color-accent-bright); }
.ct-area__panel p { margin: 0; font-size: .95rem; color: color-mix(in srgb, var(--color-white) 78%, transparent); }
.ct-area .map-embed { box-shadow: var(--shadow-lg); }
@media (max-width: 860px) { .ct-area__grid { grid-template-columns: 1fr; } }

@media (prefers-reduced-motion: reduce) { .ct-call__number { transition: none; } }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ HERO ============ -->
<section class="hero hero--interior ct-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-copy">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="breadcrumb-sep" aria-hidden="true">/</li>
          <li><span aria-current="page">Contact</span></li>
        </ol>
      </nav>
      <span class="eyebrow">Free fence estimate · Ennis &amp; Waxahachie, TX</span>
      <h1 class="hero-title" id="hero-title">Contact <?php echo h($siteName); ?> in <span class="text-accent">Ennis &amp; Waxahachie</span>, TX</h1>
      <p class="hero-answer">To get a fence estimate from <?php echo h($siteName); ?>, call <?php echo phoneLink(); ?> Monday through Friday from 7 AM to 6 PM, or send the form below at any time. The office calls back during business hours to set a time to look at the fence line.</p>
      <div class="hero-actions">
        <a class="btn btn-primary btn-lg" href="#contact-form"><?php echo icon('send', 18); ?>Send the form</a>
        <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
      </div>
      <ul class="hero-chips">
        <li><?php echo icon('handshake', 16); ?>Owned by <?php echo h($ownerName); ?></li>
        <li><?php echo icon('clock', 16); ?>Mon–Fri, 7 AM–6 PM</li>
        <li><?php echo icon('map-pin', 16); ?>Within <?php echo (int) $serviceRadiusMiles; ?> miles of Ennis &amp; Waxahachie</li>
      </ul>
    </div>
  </div>
</section>

<!-- ============ FORM + RAIL ============ -->
<section class="section ct-main" aria-labelledby="form-title">
  <div class="container-wide">
    <div class="ct-grid">

      <div class="ct-form-card reveal-left" id="contact-form">
        <span class="eyebrow">Estimate request</span>
        <h2 id="form-title">Tell <?php echo h($siteName); ?> about the fence</h2>
        <p>The fence type, a rough length and the town are enough to get started. Photos can wait for the call.</p>

        <form action="<?php echo h($formAction); ?>" method="POST" class="estimate-form">
          <?php echo p1_lead_hidden_fields('contact', ['_consent_version' => 'v2.1', '_consent_page' => $_SERVER['REQUEST_URI'] ?? '/']); ?>
          <input type="text" name="_honeypot" style="display:none" tabindex="-1" autocomplete="off" aria-hidden="true">

          <div class="form-grid">
            <div class="field">
              <label for="ct-name">Your Name</label>
              <input id="ct-name" type="text" name="name" autocomplete="name" required>
            </div>
            <div class="field">
              <label for="ct-phone">Phone</label>
              <input id="ct-phone" type="tel" name="phone" autocomplete="tel" required>
            </div>
            <div class="field">
              <label for="ct-email">Email</label>
              <input id="ct-email" type="email" name="email" autocomplete="email" required>
            </div>
            <div class="field">
              <label for="ct-service">Service Needed</label>
              <select id="ct-service" name="service">
                <option value="">Select a service</option>
<?php foreach ($services as $ctOpt): ?>
                <option value="<?php echo h($ctOpt['name']); ?>"><?php echo h($ctOpt['name']); ?></option>
<?php endforeach; ?>
              </select>
            </div>
            <div class="field full">
              <label for="ct-message">Project Details</label>
              <textarea id="ct-message" name="message" rows="5" placeholder="Fence type, rough length, gates, and which town the property is in"></textarea>
            </div>
          </div>

          <fieldset class="form-consent-fieldset">
            <legend class="form-consent-legend">Communication Consent</legend>
            <label class="form-consent-item">
              <input type="checkbox" name="email_opt_in" value="yes" class="consent-checkbox">
              <span class="consent-label"><strong>Email updates (optional):</strong> I agree to receive emails from <?php echo h($siteName); ?> about my inquiry, services, promotions, and news. I understand I can unsubscribe anytime via the link in any email or by emailing <?php echo emailLink(); ?>. Message frequency varies.</span>
            </label>
            <label class="form-consent-item">
              <input type="checkbox" name="sms_opt_in" value="yes" class="consent-checkbox">
              <span class="consent-label"><strong>SMS/Text messages (optional):</strong> I agree to receive text messages from <?php echo h($siteName); ?> at the phone number I provided. Message types may include appointment reminders, service updates, and promotional offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help. <strong>Consent is not a condition of purchase.</strong></span>
            </label>
            <label class="form-consent-item form-consent-required">
              <input type="checkbox" name="terms_accepted" value="yes" class="consent-checkbox" required>
              <span class="consent-label">I have read and agree to the <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a> and <a href="/terms/" target="_blank" rel="noopener">Terms of Service</a>. <span class="required-star">*</span></span>
            </label>
          </fieldset>

          <button type="submit" class="btn btn-primary btn-block btn-lg">Send my estimate request</button>
          <p class="footnote">The estimate is free. Your details go only to <?php echo h($siteName); ?> and are handled as described in the <a href="/privacy-policy/" target="_blank" rel="noopener">Privacy Policy</a>.</p>
        </form>
      </div>

      <aside class="ct-rail" aria-label="Ways to reach <?php echo h($siteName); ?>">
        <div class="ct-call texture-grain reveal-right">
          <span class="grain-layer" aria-hidden="true"></span>
          <span class="eyebrow">Fastest way</span>
          <a class="ct-call__number" href="tel:<?php echo h($phoneRaw); ?>"><?php echo h($phone); ?></a>
          <p>Call during business hours and describe the fence. If nobody picks up, send the form and the office returns the call.</p>
          <div class="nap">
            <div><?php echo icon('mail', 18); ?><?php echo emailLink(); ?></div>
            <div><?php echo icon('map-pin', 18); ?><span>Serving <?php echo h(areaList() . ', ' . $address['state']); ?></span></div>
          </div>
        </div>

        <div class="ct-hours reveal-right reveal-delay-1">
          <h2>Business hours</h2>
          <p class="ct-hours__status<?php echo $ctOpenNow ? ' is-open' : ''; ?>" role="status"><?php echo h($ctStatus); ?></p>
          <dl>
<?php foreach ($hours as $ctI => $ctH): ?>
            <div class="<?php echo trim(($ctI === $ctDow ? 'is-today ' : '') . (empty($ctH['opens']) ? 'is-closed' : '')); ?>">
              <dt><?php echo h($ctH['day']); ?></dt>
              <dd><?php echo h($ctH['label']); ?></dd>
            </div>
<?php endforeach; ?>
          </dl>
        </div>

        <div class="ct-next reveal-right reveal-delay-2">
          <h2>What happens next</h2>
          <ol class="next-steps">
            <li><strong>The request reaches the office</strong>The form goes straight to <?php echo h($siteName); ?> with your fence type, length and town.</li>
            <li><strong>A call to set up the estimate</strong>Expect a call back during business hours to arrange a time to look at the fence line.</li>
            <li><strong>A written quote</strong>Materials and labor for your run, in writing, before any work starts.</li>
          </ol>
        </div>
      </aside>

    </div>
  </div>
</section>

<!-- ============ SERVICE AREA (+ map when a GBP embed is supplied) ============ -->
<section class="section ct-area" aria-labelledby="area-title">
  <div class="container-wide">
    <div class="ct-area__grid">
      <div class="ct-area__copy reveal-up">
        <span class="eyebrow">Where we work</span>
        <h2 id="area-title">Which towns does <?php echo h($siteName); ?> serve?</h2>
        <p class="answer-block"><?php echo h($siteName); ?> serves Ennis, Waxahachie and properties within about <?php echo (int) $serviceRadiusMiles; ?> miles of them in Ellis County and the surrounding area. <?php echo h($siteName); ?> is a service-area business, so the fence is measured at your property rather than at a shop.</p>
        <p>Not sure your address is inside the area? Call <?php echo phoneLink(); ?> and give the street and town, and the office will tell you.</p>
        <div class="ct-area__links">
<?php if (!empty($gbp['url'])): ?>
          <a class="btn btn-outline" href="<?php echo h($gbp['url']); ?>" target="_blank" rel="noopener"><?php echo icon('map-pin', 18); ?>See <?php echo h($siteName); ?> on Google</a>
<?php endif; ?>
<?php if (!empty($gbp['embed_src']) && !empty($gbp['directions'])): ?>
          <a class="btn btn-secondary" href="<?php echo h($gbp['directions']); ?>" target="_blank" rel="noopener"><?php echo icon('route', 18); ?>Get directions</a>
<?php endif; ?>
        </div>
      </div>

<?php if (!empty($gbp['embed_src'])): ?>
      <div class="map-embed reveal-scale">
        <iframe src="<?php echo h($gbp['embed_src']); ?>" title="Map showing the <?php echo h($siteName); ?> location on Google Maps" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
      </div>
<?php else: ?>
      <div class="ct-area__panel texture-grain reveal-scale">
        <span class="grain-layer" aria-hidden="true"></span>
        <h3>Service radius</h3>
        <div class="ct-area__radius"><?php echo (int) $serviceRadiusMiles; ?> <small>miles around</small></div>
        <ul class="ct-area__towns">
<?php foreach ($serviceAreas as $ctArea): ?>
          <li><?php echo icon('map-pin', 16); ?><?php echo h($ctArea); ?></li>
<?php endforeach; ?>
        </ul>
        <p>Both towns sit in Ellis County, along the I-45 and I-35E corridors south of Dallas.</p>
      </div>
<?php endif; ?>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
