<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /blog/why-fence-posts-lean-ellis-county-clay/ — D & D Fence launch post 2 (Phase 6, 2026-10-19). Seasonal / ground-movement post.
 * SOURCES (2026-10-19):
 *   USDA Ellis series official description, https://soilseries.sc.egov.usda.gov/OSD_Docs/E/ELLIS.html — series established Ellis County, Texas, 1910;
 *     "Fine, smectitic, thermic Udic Haplusterts"; "Cracks extend from the surface to a depth of more than 12 inches"; "cracks remain open 120 to 150
 *     cumulative days in most years"; cracks 0.5 to 3 inches wide at 13 inches or more; Blackland Prairies of Texas (MLRA 86A).
 *   Texas Water Development Board, "Texas State Soil" (Houston Black), https://www.twdb.texas.gov/conservation/education/doc/tx_State_soil.pdf —
 *     Houston Black is a classic Vertisol that shrinks and swells markedly with moisture; "very high shrink-swell potential commonly is a limitation
 *     affecting building site development".
 *   TSHA Ellis County, https://www.tshaonline.org/handbook/entries/ellis-county — 939 sq mi of Blackland Prairie.
 *   City of Waxahachie Residential Fence/Retaining Wall Permit Submittal Checklist (Rev. 05/24) — metal post gauge / spacing for privacy fences.
 * NOT CLAIMED: how D & D Fence sets posts (depth, concrete, steel) — intake lacks it and content-confirmations.json asks; no job counts.
 */
$bpPost         = blogPostBySlug('why-fence-posts-lean-ellis-county-clay');
$bpOther        = blogPostBySlug('what-drives-fence-cost-ellis-county');
$pageTitle      = 'Why Fence Posts Lean in Ellis County\'s Blackland Clay';
$pageDescription = 'Blackland Prairie clay swells and cracks, and it moves fence posts. Learn the signs of a leaning post, what to check first, and when repair beats rebuild.';
$canonicalUrl   = $siteUrl . '/blog/' . $bpPost['slug'] . '/';
$ogImage        = !empty($bpPost['image']) && is_file($_SERVER['DOCUMENT_ROOT'] . $bpPost['image']) ? $bpPost['image'] : defaultOgImage();
$currentPage    = 'blog';
$pageType       = 'blog';

$bpToc = [
    ['clay',    'Why does Blackland Prairie clay move fence posts?'],
    ['signs',   'What are the signs a fence post is moving?'],
    ['checks',  'When should you check your fence?'],
    ['repair',  'Can a leaning post be fixed without replacing the fence?'],
    ['towns',   'Does it matter where in Ellis County you live?'],
    ['faq',     'Leaning fence questions'],
];
$bpFaqs = [
    ['q' => 'Is a leaning fence always a post problem?',
     'a' => 'Most of the time. Boards and pickets rarely lean on their own; they follow the rails, and the rails follow the posts. If the lean runs along a whole section, look at the posts first. Loose boards on straight posts are a smaller repair.'],
    ['q' => 'How long do the cracks in Ellis County clay stay open?',
     'a' => 'USDA\'s description of the Ellis clay says its cracks remain open 120 to 150 days in most years. They close when the soil swells with rain, which is the swing that moves posts.'],
    ['q' => 'Should I wait for a leaning section to fall before calling?',
     'a' => 'No. A section caught early is usually a smaller job than one that has pulled its neighbors out of line or taken a gate with it. Call D & D Fence at (469) 321-7783 and describe the lean; the crew can tell you whether a visit is worth it.'],
];
$schemaMarkup = blogPostSchema($bpPost, ['leaning fence posts', 'fence repair Ellis County', 'Blackland Prairie clay fence', 'fence posts Ennis TX', 'fence posts Waxahachie TX', 'fence repair'], generateFAQSchema($bpFaqs));
$ctaBandTitle = 'Is your fence starting to lean?';
$ctaBandCopy  = $siteName . ' walks the fence line in Ennis, Waxahachie and the area around them, and tells you whether the posts need a repair or a rebuild.';
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<section class="blog-hero" aria-labelledby="post-title">
  <span class="grain" aria-hidden="true"></span>
  <div class="container">
    <div class="hero-copy blog-post__header">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="breadcrumb-sep" aria-hidden="true">/</li>
          <li><a href="/blog/">Blog</a></li>
          <li class="breadcrumb-sep" aria-hidden="true">/</li>
          <li><span aria-current="page">Leaning fence posts</span></li>
        </ol>
      </nav>
      <span class="eyebrow"><?php echo h($bpPost['category']); ?></span>
      <h1 class="hero-title" id="post-title"><?php echo h($bpPost['title']); ?></h1>
      <p class="blog-post__meta"><time datetime="<?php echo h($bpPost['dateISO']); ?>"><?php echo h($bpPost['date']); ?></time><span><?php echo h($bpPost['readtime']); ?></span><span>Published by Page One Insights LLC for <?php echo h($siteName); ?></span></p>
    </div>
  </div>
</section>

<article aria-labelledby="post-title">

<section class="blog-post__intro">
  <div class="container">
    <p class="answer-block">Fence posts lean in Ellis County because Blackland Prairie clay swells when it is wet and shrinks and cracks when it dries, and the posts move with it. A leaning section is usually a post problem rather than a board problem, and catching it early often keeps it a repair instead of a rebuild.</p>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/cta-band.php'; ?>

<section class="section">
  <div class="container">
    <div class="blog-post__layout">
      <aside class="blog-post__aside" aria-label="Article tools">
        <nav class="blog-toc" aria-label="On this page">
          <p>On this page</p>
          <ol>
<?php foreach ($bpToc as $bpT): ?>
            <li><a href="#<?php echo h($bpT[0]); ?>"><?php echo h($bpT[1]); ?></a></li>
<?php endforeach; ?>
          </ol>
        </nav>
        <div class="blog-sidebar-cta">
          <strong>Leaning fence? Call first.</strong>
          <p>Ennis, Waxahachie and about <?php echo (int) $serviceRadiusMiles; ?> miles around. Mon–Fri, 7 AM–6 PM.</p>
          <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?><?php echo h($phone); ?></a>
          <?php echo estimateLink('btn btn-accent', 'Request an estimate'), "\n"; ?>
        </div>
      </aside>

      <div class="blog-post__content">
        <h2 id="clay">Why does Blackland Prairie clay move fence posts?</h2>
        <p>Almost all of Ellis County is Blackland Prairie. The Texas State Historical Association counts 939 square miles of it in the county, and the soil there is clay that behaves like a sponge. Texas's official state soil, Houston Black, is a classic shrink-swell clay, and the Texas Water Development Board notes that its very high shrink-swell potential commonly limits building sites.</p>
        <p>The soil series named for this county shows how much that movement is. USDA's description of the Ellis clay, a series first established in Ellis County in 1910, says its cracks reach more than 12 inches deep, are 0.5 to 3 inches wide at 13 inches or deeper, and stay open 120 to 150 days in most years. A post set in ground that opens and closes that much is being pushed from every side, year after year.</p>
        <p>That is the reason a fence here is only as good as its post line. If you are pricing a new run, <a href="/blog/<?php echo h($bpOther['slug']); ?>/">what drives the cost of a fence in Ellis County</a> explains where post setting shows up on a quote.</p>

        <h2 id="signs">What are the signs a fence post is moving?</h2>
        <p>A fence post rarely fails all at once, so the signs of a moving post show up gradually. These are the early signs to look for along your fence line, roughly in the order they appear:</p>
        <ul>
          <li>A gate that drags on the ground or no longer latches</li>
          <li>Gaps opening along the bottom of the boards where the ground has dropped or the post has tipped</li>
          <li>A rail that has started to tilt or pull away from its post</li>
          <li>A ring of cracked soil around the base of a post after a dry stretch</li>
          <li>A whole section leaning the same direction instead of one board at a time</li>
        </ul>
        <p>Boards follow the rails and the rails follow the posts, so a lean along a section almost always starts underground. The <a href="/services/fence-repair/">fence repair page</a> shows what a repair visit covers.</p>

        <h2 id="checks">When should you check your fence?</h2>
        <p>Check your fence after the weather changes rather than on a calendar date, because the clay moves with moisture. Ellis County has a humid subtropical climate with hot, humid summers and mild to cool winters, so dry spells and heavy rain both come around.</p>
        <table>
          <caption class="sr-only">When to check a fence in Ellis County and what to look for</caption>
          <thead><tr><th scope="col">Right after</th><th scope="col">What the clay is doing</th><th scope="col">What to check</th></tr></thead>
          <tbody>
            <tr><th scope="row">A long hot, dry stretch</th><td>Shrinking and cracking</td><td>Cracks around post bases, gaps under boards, gates that have dropped</td></tr>
            <tr><th scope="row">Heavy rain</th><td>Swelling and softening</td><td>Posts that have tipped, soft ground at the base, standing water along the line</td></tr>
            <tr><th scope="row">A storm with strong wind</th><td>Loaded from the side</td><td>Solid fences leaning away from the wind, loose rails, broken boards</td></tr>
            <tr><th scope="row">Once a year</th><td>Either</td><td>Walk the whole line, push on each post, open and close every gate</td></tr>
          </tbody>
        </table>

        <h2 id="repair">Can a leaning post be fixed without replacing the fence?</h2>
        <p>Often, yes. When only a few posts have moved and the rails and boards are sound, the fix is to straighten or replace those posts and re-hang what comes off them. When the wood itself is rotted, or the lean runs the whole length, a rebuild can cost less than chasing one repair after another.</p>
        <p>The call depends on what is under the ground, so it is made on site. <?php echo h($siteName); ?> walks the line, checks which posts have moved and tells you which way makes sense. If the fence is cedar, the <a href="/services/cedar-fence/">cedar fence page</a> covers how long the wood lasts; for a solid fence, the <a href="/services/privacy-fence/">privacy fence page</a> explains why wind makes the posts matter more.</p>

        <h2 id="towns">Does it matter where in Ellis County you live?</h2>
        <p>The clay is the same belt across the county, but the surroundings differ. In Ennis, the city's Kachina Prairie park preserves untouched Blackland Prairie, and the <a href="/service-areas/ennis/">Ennis fence page</a> covers how the ground and the town's older neighborhoods shape a fence. In Waxahachie, the City's permit checklist requires metal posts on privacy fences, a minimum 13-gauge post at most every 8 feet or a minimum 15-gauge post at most every 6 feet. That settles the post material for a privacy fence there; how a post is set in the ground is a question for the estimate. The <a href="/service-areas/waxahachie/">Waxahachie fence page</a> has the full checklist.</p>

        <h2 id="faq">Leaning fence questions</h2>
<?php foreach ($bpFaqs as $bpFaq): ?>
        <h3><?php echo h($bpFaq['q']); ?></h3>
        <p><?php echo h($bpFaq['a']); ?></p>
<?php endforeach; ?>

        <p class="blog-post__byline">Published by Page One Insights LLC for <?php echo h($siteName); ?> on <time datetime="<?php echo h($bpPost['dateISO']); ?>"><?php echo h($bpPost['date']); ?></time>. Soil facts come from USDA's Ellis series description, the Texas Water Development Board and the Texas State Historical Association; permit details from the City of Waxahachie's residential fence checklist (revision dated 05/24).</p>
      </div>
    </div>

    <?php echo blogRelatedServicesHtml(['fence-repair', 'privacy-fence', 'cedar-fence', 'fence-installation']), "\n"; ?>
    <?php echo blogRelatedArticlesHtml($bpPost['slug']), "\n"; ?>
  </div>
</section>

</article>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
