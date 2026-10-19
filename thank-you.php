<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * thank-you.php — form confirmation (Phase 5, 2026-10-19). Every form's `_next` points here (/thank-you), so it must stay a flat
 * file the extensionless rewrite can serve. noindex via $noindex (head.php emits the robots meta); keep it out of the sitemap.
 * Promises only what the site already says elsewhere: the office calls back during business hours, then a written quote.
 */
$pageTitle       = 'Thank You | ' . $siteName;
$pageDescription = 'Your fence estimate request reached ' . $siteName . ' in Ennis and Waxahachie, TX. Expect a call back during business hours, Monday to Friday, 7 AM to 6 PM.';
$canonicalUrl    = $siteUrl . '/thank-you';
$ogImage         = defaultOgImage();
$currentPage     = 'thank-you';
$pageType        = 'other';
$noindex         = true;

$tyNext = [
    ['phone',          'The office calls you back',       'Expect a call during business hours, Monday through Friday, 7 AM to 6 PM. A request sent on a weekend is answered the next business day.'],
    ['ruler',          'A time to walk the fence line',   'The call sets a time to look at the property, measure the run, and note the ground, the gates and any old fence.'],
    ['clipboard-list', 'A written quote',                 'The materials and labor for your run come back in writing before any work starts.'],
];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   Thank-you — page-specific composition (D & D Fence, rustic). Confirmation hero, what-happens-next steps, back-to-services links.
   Tokens only (var()).
   ========================================================================== */
.ty-hero {
  background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 125%);
  padding-bottom: clamp(3rem, 6vw, 4.5rem);
}
.ty-hero::before {
  content: "";
  position: absolute;
  inset: -30% auto auto -10%;
  width: 70%;
  height: 150%;
  z-index: -1;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-success) 24%, transparent), transparent 72%);
  pointer-events: none;
}
.ty-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  opacity: .07;
  pointer-events: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='g'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23g)'/%3E%3C/svg%3E");
}
.ty-hero .hero-copy { display: grid; gap: var(--space-4); max-width: 44rem; justify-items: start; }
.ty-check { display: grid; place-items: center; width: 64px; height: 64px; border-radius: 50%; color: var(--color-white); background: var(--color-success); box-shadow: 0 0 0 8px color-mix(in srgb, var(--color-success) 25%, transparent); }
.ty-hero .hero-title { color: var(--color-white); text-wrap: balance; }
.ty-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); text-wrap: pretty; }
.ty-hero .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.ty-hero .link-call svg { color: var(--color-accent-bright); }
.ty-hero .link-call:hover { color: var(--color-white); }

.ty-next { background: var(--color-paper); }
.ty-next .section-head { display: grid; gap: var(--space-3); max-width: 60ch; margin-bottom: var(--space-8); }
.ty-next h2 { text-wrap: balance; }
.ty-steps { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-5); margin: 0; padding: 0; list-style: none; counter-reset: ty-step; }
.ty-steps li { counter-increment: ty-step; position: relative; display: grid; gap: var(--space-2); align-content: start; padding: var(--space-12) var(--space-5) var(--space-6); border-radius: var(--radius-lg); border: 1px solid var(--color-line); box-shadow: var(--shadow-sm); }
.ty-steps li::before { content: counter(ty-step, decimal-leading-zero); position: absolute; top: var(--space-4); left: var(--space-5); font-family: var(--font-accent); font-weight: 700; font-size: 1.5rem; color: var(--color-accent-dark); }
.ty-steps svg { position: absolute; top: var(--space-4); right: var(--space-5); color: var(--color-accent-dark); }
.ty-steps h3 { font-size: 1.12rem; text-wrap: balance; }
.ty-steps p { margin: 0; font-size: .95rem; color: var(--color-ink-2); }
@media (max-width: 860px) { .ty-steps { grid-template-columns: 1fr; } }

.ty-back { background: var(--color-surface); }
.ty-back .section-head { display: grid; gap: var(--space-3); max-width: 60ch; margin-bottom: var(--space-6); }
.ty-back h2 { text-wrap: balance; }
.ty-links { display: flex; flex-wrap: wrap; gap: var(--space-3); margin: 0; padding: 0; list-style: none; }
.ty-links a { display: inline-flex; align-items: center; gap: var(--space-2); min-height: 48px; padding: .6rem 1.1rem; border-radius: var(--radius); border: 1px solid var(--color-line); background: var(--color-paper); color: var(--color-ink); font-weight: 600; text-decoration: none; transition: border-color var(--transition), transform var(--transition); }
.ty-links a svg { color: var(--color-accent-dark); }
.ty-links a:hover { border-color: var(--color-accent); transform: translateY(-2px); }
@media (prefers-reduced-motion: reduce) { .ty-links a { transition: none; } }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ CONFIRMATION ============ -->
<section class="hero hero--interior ty-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-copy">
      <span class="ty-check"><?php echo icon('check-circle', 34); ?></span>
      <span class="eyebrow">Request received</span>
      <h1 class="hero-title" id="hero-title">Thank you. <?php echo h($siteName); ?> has your fence request.</h1>
      <p class="hero-answer">Your estimate request reached the <?php echo h($siteName); ?> office. Expect a call during business hours, Monday through Friday from 7 AM to 6 PM, to set a time to look at the fence line.</p>
      <div class="hero-actions">
        <a class="btn btn-primary btn-lg" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
        <a class="link-call" href="/"><?php echo icon('home', 18); ?>or go back to the homepage</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ WHAT HAPPENS NEXT ============ -->
<section class="section ty-next" aria-labelledby="next-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow">What to expect</span>
      <h2 id="next-title">What happens after you send an estimate request to <?php echo h($siteName); ?>?</h2>
      <p>Three things happen, in this order: a call back, a visit to measure the fence line, and a written quote. Nothing is built until you have the quote in hand.</p>
    </div>
    <ol class="ty-steps">
<?php foreach ($tyNext as $tyI => $tyStep): ?>
      <li class="card-tint-<?php echo $tyI + 1; ?> reveal-up reveal-delay-<?php echo $tyI + 1; ?>">
        <?php echo icon($tyStep[0], 24); ?>
        <h3><?php echo h($tyStep[1]); ?></h3>
        <p><?php echo h($tyStep[2]); ?></p>
      </li>
<?php endforeach; ?>
    </ol>
  </div>
</section>

<!-- ============ BACK TO SERVICES ============ -->
<section class="section ty-back" aria-labelledby="back-title">
  <div class="container">
    <div class="section-head reveal-up">
      <span class="eyebrow">While you wait</span>
      <h2 id="back-title">Which fence service would you like to read about next?</h2>
      <p>Each page covers what the job includes, how it runs and the questions owners in Ennis and Waxahachie ask before they call.</p>
    </div>
    <ul class="ty-links reveal-up">
<?php foreach ($services as $tySvc): if (!pageBuilt('/services/' . $tySvc['slug'] . '/')) continue; ?>
      <li><a href="/services/<?php echo h($tySvc['slug']); ?>/"><?php echo icon('fence', 18); ?><?php echo h($tySvc['name']); ?></a></li>
<?php endforeach; ?>
      <li><a href="/faq/"><?php echo icon('clipboard-list', 18); ?>Fence questions answered</a></li>
    </ul>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
