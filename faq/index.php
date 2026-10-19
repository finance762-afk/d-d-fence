<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /faq/ — FAQ hub (Phase 5, 2026-10-19). 18 questions in four categories (General, Services, Pricing, Process).
 * Every answer is answer-first, names the company, and uses only facts already on the homepage / service pages / config.php;
 * facts intake does not hold (licence, insurance, warranty length, financing, prices) are not stated. FAQPage schema is an
 * AI-comprehension aid only (rich results were deprecated May 2026). One mid-page cta-band after the first category — no hero form on FAQ.
 */
$pageTitle       = 'Fence Questions Answered | Ennis & Waxahachie | ' . $siteName;
$pageDescription = 'Straight answers on fence cost, permits, property lines, materials, repairs and timing from D & D Fence, serving Ennis, Waxahachie and Ellis County, TX.';
$canonicalUrl    = $siteUrl . '/faq/';
$ogImage         = defaultOgImage();
$currentPage     = 'faq';
$pageType        = 'faq';

$fqYears = (int) $yearsInBusiness;
$fqCats = [
    [
        'id' => 'general', 'icon' => 'map-pin', 'label' => 'General',
        'title' => 'Who is ' . $siteName . ' and where does it work?',
        'lead' => $siteName . ' is a fence contractor owned by ' . $ownerName . ', serving Ennis, Waxahachie and the area within about ' . $serviceRadiusMiles . ' miles of both.',
        'items' => [
            ['q' => 'Which towns does ' . $siteName . ' serve?',
             'a' => $siteName . ' serves Ennis, Waxahachie and properties within about ' . $serviceRadiusMiles . ' miles of them in Ellis County and the surrounding area. Call ' . $phone . ' Monday through Friday from 7 AM to 6 PM, or send the estimate form, and the office will confirm whether your address is inside the service area.'],
            ['q' => 'Who owns ' . $siteName . ', and how long has it been in business?',
             'a' => $siteName . ' is owned by ' . $ownerName . ' and has been building and repairing fences around Ennis and Waxahachie for ' . $fqYears . ' years. The business handles privacy, cedar, chain link and wrought iron fences, fence repair, and new fence and gate installation.'],
            ['q' => 'What are the ' . $siteName . ' hours, and how do I reach the office?',
             'a' => $siteName . ' is open Monday through Friday from 7 AM to 6 PM and closed on Saturday and Sunday. Call ' . $phone . ' or email ' . $email . ' during those hours. The estimate form accepts requests at any time, and the office answers it on the next business day.'],
        ],
    ],
    [
        'id' => 'services', 'icon' => 'fence', 'label' => 'Services',
        'title' => 'Which fence services does ' . $siteName . ' offer?',
        'lead' => 'Four fence types, plus repair and new installation. Each service has its own page; these answers cover the questions that come up before choosing one.',
        'items' => [
            ['q' => 'What types of fence does ' . $siteName . ' build?',
             'a' => $siteName . ' builds four fence types: privacy fences, cedar fences, chain link and wrought iron. It also repairs existing fences and installs new fences and gates on residential and farm properties. Every service has its own page covering what the job includes and what owners ask first.',
             'link' => ['/services/', 'See all fence services']],
            ['q' => 'What is the difference between a privacy fence and a cedar fence?',
             'a' => 'A privacy fence is defined by what it does, closing a yard off with solid boards, while cedar is a wood those boards can be made from, so a cedar fence can also be a privacy fence. Cedar resists rot better than most wood, takes stain or sealer well, and weathers to a soft silver if left bare.',
             'link' => ['/services/cedar-fence/', 'Cedar fences']],
            ['q' => 'Which fence keeps a dog in without blocking the view?',
             'a' => 'Chain link is the usual answer. The open mesh keeps dogs inside the yard and leaves the view and the light, and it has the lowest material cost of the fence types ' . $siteName . ' builds. Wrought iron also keeps the view open, so mention the size of your dog when you call.',
             'link' => ['/services/chain-link/', 'Chain link fencing']],
            ['q' => 'Can wrought iron be used as a pool fence?',
             'a' => 'Yes. Wrought iron is used for pool lines, front yards, entries and security fencing because it leaves the view open and needs little upkeep once coated. Pool fences are regulated by local code, so check the height and gate requirements with your city before choosing a design, and ask ' . $siteName . ' about them at the estimate.',
             'link' => ['/services/wrought-iron/', 'Wrought iron fencing']],
            ['q' => 'Can a leaning fence be repaired instead of replaced?',
             'a' => 'Often, yes. A leaning run is usually a post problem, because Blackland clay in Ellis County swells and shrinks and works posts out of line, and resetting or replacing the posts can straighten the run without a new fence. Broken boards, rails and sagging gates can also be replaced one at a time.',
             'link' => ['/services/fence-repair/', 'Fence repair']],
            ['q' => 'Does ' . $siteName . ' install gates and farm fencing?',
             'a' => 'Gates are planned into the fence run on new installs, and fence installation covers residential and farm properties. For a particular gate, such as a wide farm gate or an automatic opener, call ' . $phone . ' and describe the opening so the office can confirm what applies.',
             'link' => ['/services/fence-installation/', 'Fence installation']],
        ],
    ],
    [
        'id' => 'pricing', 'icon' => 'clipboard-list', 'label' => 'Pricing',
        'title' => 'What does a fence cost, and how is it quoted?',
        'lead' => 'The price follows the material, the length, the height, the ground and any old fence that has to come out. The quote arrives in writing.',
        'items' => [
            ['q' => 'How much does a new fence cost?',
             'a' => 'The price of a new fence depends on the material, the total length, the height, the ground and whether an old fence has to come out first. Most residential fences are priced by the linear foot, and a free estimate from ' . $siteName . ' puts the materials and labor for your run in writing.'],
            ['q' => 'Is the estimate free, and will I get the price in writing?',
             'a' => 'Yes. The estimate is free, and the quote comes back in writing with the materials and labor for your run before any work starts. Because most residential fences are priced by the linear foot, the total follows the length you need and the fence type you choose.'],
            ['q' => 'Which fence material costs the least?',
             'a' => 'Chain link has the lowest material cost of the fence types ' . $siteName . ' builds, cedar sits in the middle, and wrought iron costs the most for the metal and its coating. The final figure still depends on the length, height and ground, so the written estimate for your run is the number to compare.',
             'link' => ['/services/', 'Compare the fence types']],
        ],
    ],
    [
        'id' => 'process', 'icon' => 'hammer', 'label' => 'Process',
        'title' => 'How does a fence job run from the first call to the finished fence?',
        'lead' => 'Reach out, estimate on site, settle the line and the rules, then build. These answers cover what happens at each step.',
        'items' => [
            ['q' => 'What happens after I send an estimate request?',
             'a' => 'The request goes straight to the ' . $siteName . ' office, which calls back during business hours to set a time to look at the fence line. The line is walked and measured, the ground, gates and any old fence are noted, and the written quote follows.'],
            ['q' => 'What should I have ready when I call for an estimate?',
             'a' => 'Have the fence type you are leaning toward, a rough length, whether you want gates, and the town the property is in. For a repair, photos of the damaged section help. The survey or plat from your closing documents shows the property line, so keep it handy.'],
            ['q' => 'Do I need a permit or HOA approval before building a fence?',
             'a' => 'Often, yes: many Texas cities require a permit for fences above a set height, and HOAs commonly set rules on style, color and placement. ' . $siteName . ' can check the requirements for your address so the project is not held up waiting on paperwork.'],
            ['q' => 'How do I know where my property line is?',
             'a' => 'Start with the survey or plat in your closing documents. If the line is still unclear, a licensed surveyor can stake it, which heads off disputes with neighbors. ' . $siteName . ' recommends confirming the line before any post hole is dug.'],
            ['q' => 'Are buried utility lines located before digging?',
             'a' => 'Yes. Buried lines are located before post holes are dug, which in Texas starts with a free locate request through Texas811 by dialing 811. Marking takes a few working days, so the request goes in ahead of the build, and posts are then set clear of the marked lines.'],
            ['q' => 'How long does fence installation take, and what warranty do you offer?',
             'a' => 'A typical residential fence run takes one to three days, depending on its length, the ground and the weather. Warranty coverage varies by material and workmanship, and ' . $siteName . ' puts the exact terms in writing with your estimate.'],
        ],
    ],
];

$fqAll = [];
foreach ($fqCats as $fqCat) {
    foreach ($fqCat['items'] as $fqItem) $fqAll[] = ['q' => $fqItem['q'], 'a' => $fqItem['a']];
}

$fqBase   = rtrim($siteUrl, '/');
$fqCrumbs = generateBreadcrumbSchema([['name' => 'Home', 'url' => '/'], ['name' => 'FAQ', 'url' => '/faq/']]);
unset($fqCrumbs['@context']);
$fqCrumbs['@id'] = $canonicalUrl . '#breadcrumb';
$fqFaq = generateFAQSchema($fqAll);
unset($fqFaq['@context']);
$fqFaq['@id'] = $canonicalUrl . '#faq';
$schemaMarkup = ['@context' => 'https://schema.org', '@graph' => [
    ['@type' => 'WebPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => 'Fence Questions Answered in Ennis & Waxahachie, TX',
     'description' => $pageDescription, 'isPartOf' => ['@id' => $fqBase . '/#website'], 'about' => ['@id' => $fqBase . '/#organization'],
     'breadcrumb' => ['@id' => $fqCrumbs['@id']], 'mainEntity' => ['@id' => $fqFaq['@id']],
     'speakable' => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.fq-cat__lead']]],
    $fqCrumbs,
    $fqFaq,
]];

$fqCtaIndex = 0;   // the cta-band sits after the first category
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
/* ==========================================================================
   /faq/ — page-specific composition (D & D Fence, rustic, no photos yet).
   Layered type hero with a category jump list, then four asymmetric category sections
   (sticky heading column + accordion), alternating backgrounds. Tokens only (var()).
   ========================================================================== */

/* ---------- Hero: gradient ::before, noise ::after, rail line ---------- */
.fq-hero {
  background: linear-gradient(120deg, var(--color-dark) 0%, var(--color-dark-alt) 55%, var(--color-primary-deep) 125%);
  padding-bottom: clamp(2.5rem, 5vw, 3.75rem);
}
.fq-hero::before {
  content: "";
  position: absolute;
  inset: -30% -10% auto 40%;
  height: 140%;
  z-index: -1;
  background: radial-gradient(closest-side, color-mix(in srgb, var(--color-accent) 20%, transparent), transparent 72%);
  pointer-events: none;
}
.fq-hero::after {
  content: "";
  position: absolute;
  inset: 0;
  z-index: -1;
  opacity: .07;
  pointer-events: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='160' height='160'%3E%3Cfilter id='g'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.75' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23g)'/%3E%3C/svg%3E");
}
.fq-hero .breadcrumb { align-items: center; color: color-mix(in srgb, var(--color-white) 62%, transparent); margin-bottom: var(--space-2); }
.fq-hero .breadcrumb a:hover { color: var(--color-white); }
.fq-hero .breadcrumb [aria-current] { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.fq-hero .hero-copy { display: grid; gap: var(--space-4); max-width: 46rem; }
.fq-hero .hero-title { color: var(--color-white); text-wrap: balance; }
.fq-hero .hero-title .text-accent { color: var(--color-accent-bright); }
.fq-hero .hero-answer { color: color-mix(in srgb, var(--color-white) 84%, transparent); text-wrap: pretty; max-width: 40rem; }
.fq-hero .link-call { color: color-mix(in srgb, var(--color-white) 88%, transparent); }
.fq-hero .link-call svg { color: var(--color-accent-bright); }
.fq-hero .link-call:hover { color: var(--color-white); }
.fq-jump { display: flex; flex-wrap: wrap; gap: var(--space-2); margin: 0; padding: 0; list-style: none; }
.fq-jump a {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  min-height: 44px;
  padding: .45rem .95rem;
  border-radius: var(--radius-full);
  border: 1px solid color-mix(in srgb, var(--color-white) 22%, transparent);
  background: color-mix(in srgb, var(--color-white) 7%, transparent);
  color: var(--color-white);
  font-size: .9rem;
  font-weight: 600;
  text-decoration: none;
  transition: background-color var(--transition), border-color var(--transition);
}
.fq-jump a svg { color: var(--color-accent-bright); }
.fq-jump a:hover { background: color-mix(in srgb, var(--color-white) 14%, transparent); border-color: var(--color-accent-bright); }
.fq-jump small { font-family: var(--font-accent); letter-spacing: .08em; color: color-mix(in srgb, var(--color-white) 60%, transparent); }

/* ---------- Category sections: sticky heading column + accordion ---------- */
.fq-cat { scroll-margin-top: var(--nav-height); }
.fq-cat--light { background: var(--color-paper); }
.fq-cat--alt { background: var(--color-surface); }
.fq-cat__grid { display: grid; grid-template-columns: minmax(0, .8fr) minmax(0, 1.7fr); gap: clamp(2rem, 5vw, 4.5rem); align-items: start; }
.fq-cat--flip .fq-cat__grid { grid-template-columns: minmax(0, 1.7fr) minmax(0, .8fr); }
.fq-cat--flip .fq-cat__head { order: 2; }
.fq-cat__head { display: grid; gap: var(--space-3); position: sticky; top: calc(var(--nav-height) + var(--space-6)); }
.fq-cat__head h2 { text-wrap: balance; }
.fq-cat__lead { margin: 0; color: var(--color-ink-2); }
.fq-cat__count { display: inline-flex; align-items: center; gap: var(--space-2); font-family: var(--font-accent); font-weight: 700; font-size: .85rem; letter-spacing: .12em; text-transform: uppercase; color: var(--color-accent-dark); }
.fq-list { display: grid; gap: 0; }
.fq-list .faq summary { text-wrap: balance; }
.fq-list .faq[open] summary { color: var(--color-accent-dark); }
.fq-list .faq-answer { max-width: 62ch; }
.fq-rel { display: inline-flex; align-items: center; gap: var(--space-2); margin-top: var(--space-2); font-weight: 600; font-size: .92rem; color: var(--color-primary); text-decoration: none; }
.fq-rel svg { transition: transform var(--transition); }
.fq-rel:hover { color: var(--color-accent-dark); }
.fq-rel:hover svg { transform: translateX(4px); }
@media (max-width: 900px) {
  .fq-cat__grid, .fq-cat--flip .fq-cat__grid { grid-template-columns: 1fr; }
  .fq-cat--flip .fq-cat__head { order: 0; }
  .fq-cat__head { position: static; }
}

/* ---------- Closing: unanswered question ---------- */
.fq-close { background: var(--color-paper-2); }
.fq-close__inner { display: grid; grid-template-columns: minmax(0, 1.2fr) auto; gap: var(--space-8); align-items: center; padding: var(--space-8); border-radius: var(--radius-lg); border: 1px solid var(--color-line); background: var(--color-surface); box-shadow: var(--shadow); }
.fq-close h2 { text-wrap: balance; }
.fq-close p { margin: var(--space-2) 0 0; color: var(--color-ink-2); max-width: 54ch; }
.fq-close__actions { display: flex; flex-wrap: wrap; gap: var(--space-3); align-items: center; }
@media (max-width: 760px) { .fq-close__inner { grid-template-columns: 1fr; padding: var(--space-6); } }

@media (prefers-reduced-motion: reduce) {
  .fq-jump a, .fq-rel svg { transition: none; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ============ HERO (type hero + category jump list) ============ -->
<section class="hero hero--interior fq-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-copy">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="breadcrumb-sep" aria-hidden="true">/</li>
          <li><span aria-current="page">FAQ</span></li>
        </ol>
      </nav>
      <span class="eyebrow">Fence questions · Ennis &amp; Waxahachie, TX</span>
      <h1 class="hero-title" id="hero-title">Fence Questions, Answered for <span class="text-accent">Ennis &amp; Waxahachie</span></h1>
      <p class="hero-answer"><?php echo h($siteName); ?> answers <?php echo count($fqAll); ?> questions on this page, covering the towns it serves, the fence types it builds, what a fence costs, and how a job runs from the first call to the finished fence.</p>
      <ul class="fq-jump" aria-label="Question categories">
<?php foreach ($fqCats as $fqNum => $fqCat): ?>
        <li><a href="#<?php echo h($fqCat['id']); ?>"><?php echo icon($fqCat['icon'], 16); ?><?php echo h($fqCat['label']); ?> <small><?php echo count($fqCat['items']); ?></small></a></li>
<?php endforeach; ?>
      </ul>
      <div class="hero-actions">
        <?php echo estimateLink('btn btn-primary btn-lg', 'Get a free estimate'), "\n"; ?>
        <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
      </div>
    </div>
  </div>
</section>

<?php foreach ($fqCats as $fqNum => $fqCat): ?>
<!-- ============ <?php echo strtoupper($fqCat['label']); ?> ============ -->
<section class="section fq-cat <?php echo $fqNum % 2 === 0 ? 'fq-cat--light' : 'fq-cat--alt fq-cat--flip'; ?>" id="<?php echo h($fqCat['id']); ?>" aria-labelledby="<?php echo h($fqCat['id']); ?>-title">
  <div class="container-wide">
    <div class="fq-cat__grid">
      <div class="fq-cat__head <?php echo $fqNum % 2 === 0 ? 'reveal-left' : 'reveal-right'; ?>">
        <span class="fq-cat__count"><?php echo icon($fqCat['icon'], 18); ?><?php echo h($fqCat['label']); ?> · <?php echo count($fqCat['items']); ?> questions</span>
        <h2 id="<?php echo h($fqCat['id']); ?>-title"><?php echo h($fqCat['title']); ?></h2>
        <p class="fq-cat__lead"><?php echo h($fqCat['lead']); ?></p>
      </div>
      <div class="fq-list reveal-up">
<?php foreach ($fqCat['items'] as $fqIdx => $fqItem): ?>
        <details class="faq"<?php echo ($fqNum === 0 && $fqIdx === 0) ? ' open' : ''; ?>>
          <summary><?php echo h($fqItem['q']); ?></summary>
          <p class="faq-answer"><?php echo h($fqItem['a']); ?></p>
<?php if (!empty($fqItem['link']) && pageBuilt($fqItem['link'][0])): ?>
          <a class="fq-rel" href="<?php echo h($fqItem['link'][0]); ?>"><?php echo h($fqItem['link'][1]); ?><?php echo icon('arrow-right', 16); ?></a>
<?php endif; ?>
        </details>
<?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php if ($fqNum === $fqCtaIndex):
    $ctaBandTitle = 'Still deciding on a fence? Get a free estimate.';
    $ctaBandCopy  = $siteName . ' will call back during business hours to set a time to walk the fence line, then put the price in writing.';
    include $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php';
endif; ?>
<?php endforeach; ?>

<!-- ============ CLOSING: a question that is not here ============ -->
<section class="section fq-close" aria-labelledby="close-title">
  <div class="container">
    <div class="fq-close__inner reveal-scale">
      <div>
        <h2 id="close-title">Have a fence question that is not here?</h2>
        <p>Call <?php echo phoneLink(); ?> or email <?php echo emailLink(); ?>, and <?php echo h($siteName); ?> will answer during business hours, Monday through Friday from 7 AM to 6 PM.</p>
      </div>
      <div class="fq-close__actions">
        <a class="btn btn-primary btn-lg" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>Call <?php echo h($phone); ?></a>
        <a class="btn btn-outline btn-lg" href="/contact/">Send a message</a>
      </div>
    </div>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
