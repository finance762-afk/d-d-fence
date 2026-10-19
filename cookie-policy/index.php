<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /cookie-policy/ — Cookie Policy (Phase 5, 2026-10-19). Adapted from ~/crm/references/legal-compliance.md.
 * Lists only what this build actually sets: the first-party p1_ft attribution cookie (includes/attribution.php), the
 * cookie-notice localStorage flag (main.js), and Google Analytics 4 once a real measurement ID replaces the placeholder in config.php.
 * Fonts are self-hosted and there is no map or widget embed, so neither is listed as a cookie source.
 */
$pageTitle       = 'Cookie Policy | ' . $siteName . ', Ennis & Waxahachie, TX';
$pageDescription = 'The cookies and browser storage the ' . $siteName . ' fence website in Ennis and Waxahachie, TX uses, what each does, and how to block or delete them in your browser.';
$canonicalUrl    = $siteUrl . '/cookie-policy/';
$ogImage         = defaultOgImage();
$currentPage     = 'cookie-policy';
$pageType        = 'other';

$lgBase   = rtrim($siteUrl, '/');
$lgCrumbs = generateBreadcrumbSchema([['name' => 'Home', 'url' => '/'], ['name' => 'Cookie Policy', 'url' => '/cookie-policy/']]);
unset($lgCrumbs['@context']);
$lgCrumbs['@id'] = $canonicalUrl . '#breadcrumb';
$schemaMarkup = ['@context' => 'https://schema.org', '@graph' => [
    ['@type' => 'WebPage', '@id' => $canonicalUrl . '#webpage', 'url' => $canonicalUrl, 'name' => $pageTitle, 'description' => $pageDescription,
     'isPartOf' => ['@id' => $lgBase . '/#website'], 'about' => ['@id' => $lgBase . '/#organization'], 'breadcrumb' => ['@id' => $lgCrumbs['@id']]],
    $lgCrumbs,
]];
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<section class="hero hero--legal" aria-labelledby="legal-title">
  <div class="container">
    <div class="hero-copy">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <ol>
          <li><a href="/">Home</a></li>
          <li class="breadcrumb-sep" aria-hidden="true">/</li>
          <li><span aria-current="page">Cookie Policy</span></li>
        </ol>
      </nav>
      <span class="eyebrow">Legal</span>
      <h1 id="legal-title">Cookie Policy</h1>
      <p class="legal-meta">Last updated: <?php echo h($legalUpdated); ?></p>
    </div>
  </div>
</section>

<section class="legal-section">
  <div class="container">
    <article class="legal-prose content-narrow">

      <h2 id="what-are-cookies">1. What Are Cookies?</h2>
      <p>Cookies are small text files a website stores on your device. Browsers also offer local storage, which works in a similar way. Websites use both to work properly and to report how visitors use them.</p>

      <h2 id="cookies-we-use">2. What the <?php echo h($siteName); ?> Website Uses</h2>
      <div class="legal-table-wrap">
        <table class="legal-table">
          <thead>
            <tr><th scope="col">Name</th><th scope="col">What it does</th><th scope="col">Lasts</th><th scope="col">Set by</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row"><code>p1_ft</code></th><td>Remembers the first page you landed on, the site or ad that sent you, campaign tags in the link and a random session ID, so an estimate request can be matched to the page or ad that brought it in. It holds no name, phone number or email address.</td><td>30 days</td><td>This website (first party)</td></tr>
            <tr><th scope="row"><code>cookieBannerDismissed_v1</code></th><td>Local storage flag that records you closed the cookie notice, so it does not appear again.</td><td>Until you clear site data</td><td>This website (first party)</td></tr>
            <tr><th scope="row"><code>_ga</code>, <code>_ga_*</code></th><td>Google Analytics 4 cookies that tell us how many people visit, which pages they read and how they found the site. They are set only while analytics is switched on for this website.</td><td>Up to 2 years</td><td>Google (third party)</td></tr>
          </tbody>
        </table>
      </div>
      <h3 id="necessary">Strictly necessary</h3>
      <p>The estimate form and the cookie notice work without any cookie you could turn off. The <code>p1_ft</code> cookie is a first-party record used only to credit a request to the page that earned it.</p>
      <h3 id="analytics">Analytics (Google Analytics 4)</h3>
      <p>When analytics is on, Google Analytics 4 collects usage data such as pages viewed, approximate location, device and browser. It does not tell us who you are.</p>
      <h3 id="third-party">Links to other sites</h3>
      <p>This website links to Google Maps directions and to our Google Business Profile. Those pages open on Google's own sites, which set their own cookies under Google's policies.</p>

      <h2 id="control-cookies">3. How to Control Cookies</h2>
      <p>Most browsers let you see, delete or block cookies, including all third-party cookies. If you block every cookie, the website still works, but your estimate request may not be credited to the page that led to it. Instructions are on the help pages of Google Chrome, Mozilla Firefox, Apple Safari and Microsoft Edge.</p>

      <h2 id="opt-out-analytics">4. Opt Out of Google Analytics</h2>
      <p>You can turn off Google Analytics on every website by installing the <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">Google Analytics Opt-out Browser Add-on</a>.</p>

      <h2 id="cookie-notice">5. Our Cookie Notice</h2>
      <p>The website shows a short notice about cookies. When you press "Got it", the notice is hidden on later visits by setting the local storage flag listed above. Clearing your browser's site data brings the notice back.</p>

      <h2 id="changes">6. Changes to This Policy</h2>
      <p>We may update this policy as the website changes. The "Last updated" date at the top shows the latest version.</p>

      <h2 id="contact">7. Contact Us</h2>
      <address class="legal-contact">
        <strong><?php echo h($companyName); ?></strong>
        <span>Email: <?php echo emailLink(); ?></span>
        <span>Phone: <?php echo phoneLink(); ?></span>
        <span>Service area: <?php echo h(areaList() . ', ' . $address['state']); ?></span>
        <span>Hours: <?php echo h($businessHours); ?></span>
      </address>

    </article>
  </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
