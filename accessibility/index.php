<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /accessibility/ — Accessibility Statement (Phase 5, 2026-10-19). Adapted from ~/crm/references/legal-compliance.md.
 * The feature list names only what this build ships (skip link, landmarks, focus ring, labelled fields, reduced-motion CSS, native dialog).
 */
$pageTitle       = 'Accessibility Statement | ' . $siteName;
$pageDescription = $siteName . ' aims to meet WCAG 2.1 Level AA on this website. See the accessibility features in place and how to report a barrier or ask for help.';
$canonicalUrl    = $siteUrl . '/accessibility/';
$ogImage         = defaultOgImage();
$currentPage     = 'accessibility';
$pageType        = 'other';

$lgBase   = rtrim($siteUrl, '/');
$lgCrumbs = generateBreadcrumbSchema([['name' => 'Home', 'url' => '/'], ['name' => 'Accessibility Statement', 'url' => '/accessibility/']]);
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
          <li><span aria-current="page">Accessibility</span></li>
        </ol>
      </nav>
      <span class="eyebrow">Legal</span>
      <h1 id="legal-title">Accessibility Statement</h1>
      <p class="legal-meta">Last updated: <?php echo h($legalUpdated); ?></p>
    </div>
  </div>
</section>

<section class="legal-section">
  <div class="container">
    <article class="legal-prose content-narrow">

      <h2 id="commitment">1. Our Commitment</h2>
      <p><?php echo h($companyName); ?> wants everyone who needs a fence in Ennis, Waxahachie and the surrounding area to be able to read this website, compare services and ask for an estimate, including people who use screen readers, keyboards, voice control or magnification. We work to improve the site for everyone and apply accessibility standards to <?php echo h($domain); ?>.</p>

      <h2 id="conformance">2. Conformance Status</h2>
      <p>This website is designed to meet the Web Content Accessibility Guidelines (WCAG) 2.1 at Level AA. We believe it partially conforms today, which means some content may not yet meet every requirement, and we are working to fix known issues as we find them.</p>

      <h2 id="features">3. Accessibility Features</h2>
      <ul>
        <li>Page structure built with HTML landmarks: header, navigation, main content and footer</li>
        <li>A "Skip to main content" link at the top of every page</li>
        <li>A visible focus outline on links, buttons and form fields, so keyboard users can see where they are</li>
        <li>Menus, the estimate request window and all forms that work with a keyboard alone</li>
        <li>Text descriptions (alt text) for images that carry meaning</li>
        <li>Text and button colors chosen for readable contrast</li>
        <li>A layout that adjusts to phone, tablet and desktop screens and to text zoom</li>
        <li>Reduced motion: animations and transitions switch off for visitors whose device asks for less motion</li>
        <li>Every form field has a label, and the consent choices are separate, labelled checkboxes</li>
      </ul>

      <h2 id="known-issues">4. Known Issues</h2>
      <ul>
        <li>Customer reviews come from Google and are shown exactly as the customers wrote them. We cannot change their formatting.</li>
        <li>Pages we link to, such as our Google Business Profile and Google Maps, are run by Google and may not meet every WCAG requirement. You can reach us by phone or email for anything you cannot get from those pages.</li>
      </ul>

      <h2 id="feedback">5. Feedback and Reporting Issues</h2>
      <p>If something on this website is hard or impossible for you to use, tell us which page and what happened, and what device or assistive technology you use if you can. We aim to answer accessibility reports within 5 business days.</p>

      <h2 id="alternatives">6. Other Ways to Reach Us</h2>
      <p>You do not need the website to get an estimate. Call <?php echo phoneLink(); ?> during business hours (<?php echo h($businessHours); ?>) or email <?php echo emailLink(); ?>. On request we can send information about our services in another format.</p>

      <h2 id="changes">7. Changes to This Statement</h2>
      <p>We update this statement when the website or our accessibility work changes. The "Last updated" date at the top shows the latest version.</p>

      <h2 id="contact">8. Contact Us</h2>
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
