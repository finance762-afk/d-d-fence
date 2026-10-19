<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /blog/ — D & D Fence blog index (Phase 6, 2026-10-19). REGISTRY-DRIVEN: every card comes from includes/blog-data.php via blogLoad().
 * Newest post is the featured block; the rest fill the grid. One mid-page estimate band (cta-band) after the first section; no hero form.
 */
$pageTitle       = 'Fence Tips for Ennis & Waxahachie, TX | Blog | ' . $siteName;
$pageDescription = 'Plain-language fence guides for Ellis County: what drives fence cost, why posts lean in Blackland clay, and what to ask before you build. From D & D Fence.';
$canonicalUrl    = $siteUrl . '/blog/';
$ogImage         = defaultOgImage();
$currentPage     = 'blog';
$pageType        = 'blog';

$blogPosts = blogLoad();           // the registry (includes/blog-data.php) — every card below comes from it
$blIndexPosts = $blogPosts;
$blFeatured   = $blIndexPosts[0] ?? null;
$blRest       = array_slice($blIndexPosts, 1);

$blItems = [];
foreach ($blIndexPosts as $blI => $blP) {
    $blItems[] = ['@type' => 'ListItem', 'position' => $blI + 1, 'name' => $blP['title'], 'url' => $siteUrl . '/blog/' . $blP['slug'] . '/'];
}
$blCrumbs = generateBreadcrumbSchema([['name' => 'Home', 'url' => '/'], ['name' => 'Blog', 'url' => '/blog/']]);
unset($blCrumbs['@context']);
$schemaMarkup = [
    '@context' => 'https://schema.org',
    '@graph'   => [
        [
            '@type'      => 'CollectionPage',
            '@id'        => $canonicalUrl . '#webpage',
            'url'        => $canonicalUrl,
            'name'       => 'D & D Fence Blog',
            'isPartOf'   => ['@id' => $siteUrl . '/#website'],
            'about'      => ['@id' => $siteUrl . '/#organization'],
            'breadcrumb' => ['@id' => $canonicalUrl . '#breadcrumb'],
            'mainEntity' => ['@id' => $canonicalUrl . '#posts'],
        ],
        ['@type' => 'ItemList', '@id' => $canonicalUrl . '#posts', 'itemListElement' => $blItems],
        $blCrumbs + ['@id' => $canonicalUrl . '#breadcrumb'],
    ],
];

$ctaBandTitle = 'Ready to talk through your fence?';
$ctaBandCopy  = $siteName . ' calls back during business hours to set a time to walk the fence line in Ennis, Waxahachie or the area around them.';
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<style>
.bl-featured { background: var(--color-paper); padding-block: clamp(2.5rem, 5vw, 4rem); }
.bl-featured .blog-feature { box-shadow: var(--shadow); background: var(--color-card-tint-3); }
.bl-list { background: var(--color-paper-2); }
.bl-list .section-title { max-width: 60ch; margin-bottom: var(--space-6); }
.bl-list .blog-grid { grid-template-columns: repeat(auto-fit, minmax(min(100%, 300px), 380px)); }
.bl-list .blog-card:nth-child(3n + 1) { background: var(--color-card-tint-1); }
.bl-list .blog-card:nth-child(3n + 2) { background: var(--color-card-tint-2); }
.bl-list .blog-card:nth-child(3n + 3) { background: var(--color-card-tint-3); }
.bl-cats { background: var(--color-paper); padding-block: clamp(2.25rem, 4vw, 3.5rem); }
.bl-cats p { max-width: 62ch; color: var(--color-ink-2); }
.bl-cats__list { display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr)); gap: var(--space-4); margin: var(--space-5) 0 0; padding: 0; list-style: none; }
.bl-cats__list li { display: grid; gap: var(--space-2); align-content: start; padding: var(--space-5); border: 1px solid var(--color-line); border-radius: var(--radius-lg); background: var(--color-surface); }
.bl-cats__list li:nth-child(odd) { background: var(--color-card-tint-1); }
.bl-cats__list li:nth-child(even) { background: var(--color-card-tint-2); }
.bl-cats__list h3 { font-size: 1.15rem; }
.bl-cats__list p { margin: 0; font-size: .95rem; }
.bl-cats__list span { font-size: .85rem; color: var(--color-muted); }
.bl-cats__list a { color: var(--color-primary); font-weight: 600; }
.bl-topics { background: var(--color-surface); padding-block: clamp(2.25rem, 4vw, 3.5rem); }
.bl-topics ul { display: flex; flex-wrap: wrap; gap: var(--space-3); margin: var(--space-4) 0 0; padding: 0; list-style: none; }
.bl-topics a { display: inline-flex; padding: var(--space-2) var(--space-4); border: 1px solid var(--color-line); border-radius: var(--radius-full); background: var(--color-paper); font-weight: 600; font-size: .95rem; }
.bl-topics a:hover { border-color: var(--color-accent); color: var(--color-accent-dark); }
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<section class="blog-hero" aria-labelledby="hero-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-copy">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="breadcrumb-sep" aria-hidden="true">/</li>
          <li><span aria-current="page">Blog</span></li>
        </ol>
      </nav>
      <span class="eyebrow">From the fence crew</span>
      <h1 class="hero-title" id="hero-title">Fence Guides for <span class="text-accent">Ennis &amp; Waxahachie</span> Property Owners</h1>
      <p class="hero-answer">Short, specific articles on what a fence costs, why posts lean in Ellis County clay and what to settle before the first hole is dug.</p>
    </div>
  </div>
</section>

<?php if ($blFeatured): ?>
<section class="bl-featured" aria-labelledby="featured-title">
  <div class="container-wide">
    <h2 id="featured-title" class="sr-only">Latest article</h2>
    <?php echo blogCard($blFeatured, 'blog-feature reveal-up'), "\n"; ?>
  </div>
</section>
<?php endif; ?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php'; ?>

<?php if ($blRest): ?>
<section class="section bl-list" aria-labelledby="more-title">
  <div class="container-wide">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">More articles</span>
      <h2 id="more-title">What else should you know before you build?</h2>
    </div>
    <div class="blog-grid">
<?php foreach ($blRest as $blIdx => $blPost): ?>
      <?php echo blogCard($blPost, 'reveal-up reveal-delay-' . (($blIdx % 3) + 1)), "\n"; ?>
<?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php
$blCats = [];
foreach ($blogPosts as $blCp) { $blCats[$blCp['category']][] = $blCp; }
$blCatBlurbs = [
    'Fence Costs' => 'What moves a fence quote: material, height, gates, ground, old-fence removal and permits.',
    'Fence Care'  => 'How Ellis County clay, weather and wind affect posts, and when a repair beats a rebuild.',
];
?>
<section class="bl-cats" aria-labelledby="cats-title">
  <div class="container">
    <h2 id="cats-title">Which fence topics do the D &amp; D Fence guides cover?</h2>
    <p>The guides are grouped by topic so you can go straight to the question you have: what a fence costs, or how to keep one standing in Ellis County ground.</p>
    <ul class="bl-cats__list">
<?php foreach ($blCats as $blCatName => $blCatPosts): ?>
      <li>
        <h3><?php echo h($blCatName); ?></h3>
        <p><?php echo h($blCatBlurbs[$blCatName] ?? 'Fence guides for Ellis County property owners.'); ?></p>
        <span><?php echo count($blCatPosts); ?> article<?php echo count($blCatPosts) === 1 ? '' : 's'; ?> · <a href="/blog/<?php echo h($blCatPosts[0]['slug']); ?>/">Start with “<?php echo h($blCatPosts[0]['title']); ?>”</a></span>
      </li>
<?php endforeach; ?>
    </ul>
  </div>
</section>

<section class="bl-topics" aria-labelledby="topics-title">
  <div class="container">
    <h2 id="topics-title">Looking for a specific fence?</h2>
    <p>Each service page covers one fence type in detail, with local conditions and common questions.</p>
    <ul>
<?php foreach ($services as $blSvc): ?>
      <li><a href="/services/<?php echo h($blSvc['slug']); ?>/"><?php echo h($blSvc['name']); ?></a></li>
<?php endforeach; ?>
    </ul>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
