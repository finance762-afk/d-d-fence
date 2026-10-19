<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /terms/ — Terms of Service (Phase 5, 2026-10-19). Adapted from ~/crm/references/legal-compliance.md.
 * Left out on purpose: the "Insurance Claim Work" clause (fence work is not insurance restoration), and licence / insurance /
 * workers' comp statements (none are in intake). Governing law uses the operating state (Texas) because state of formation is unknown.
 */
$pageTitle       = 'Terms of Service | ' . $siteName . ', Ennis & Waxahachie, TX';
$pageDescription = 'The terms for the ' . $siteName . ' website and its fence estimates, installations and repairs in Ennis, Waxahachie and Ellis County, Texas. Read them here.';
$canonicalUrl    = $siteUrl . '/terms/';
$ogImage         = defaultOgImage();
$currentPage     = 'terms';
$pageType        = 'other';

$lgBase   = rtrim($siteUrl, '/');
$lgCrumbs = generateBreadcrumbSchema([['name' => 'Home', 'url' => '/'], ['name' => 'Terms of Service', 'url' => '/terms/']]);
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
          <li><span aria-current="page">Terms of Service</span></li>
        </ol>
      </nav>
      <span class="eyebrow">Legal</span>
      <h1 id="legal-title">Terms of Service</h1>
      <p class="legal-meta">Last updated: <?php echo h($legalUpdated); ?></p>
    </div>
  </div>
</section>

<section class="legal-section">
  <div class="container">
    <article class="legal-prose content-narrow">

      <h2 id="agreement">1. Agreement to Terms</h2>
      <p>By using <?php echo h($domain); ?> or asking <?php echo h($companyName); ?><?php echo $companyEntityType !== '' ? ', ' . h($companyEntityType) . ',' : ''; ?> for an estimate or fence work, you agree to these Terms of Service and to our <a href="/privacy-policy/">Privacy Policy</a>. If you do not agree, please do not use the website or our services.</p>

      <h2 id="website-use">2. Use of This Website</h2>
      <ul>
        <li>You may use this website for personal, non-commercial purposes: to learn about our fence services and to contact us.</li>
        <li>You may not use it for anything unlawful, try to reach non-public systems, copy its content without written permission, send false information through a form, or use automated tools to pull data from it.</li>
      </ul>

      <h2 id="estimates">3. Estimates and Quotes</h2>
      <p>An estimate is based on what you tell us and what we can see at the property when the fence line is measured. The price can change if the scope changes or if the job turns up conditions that were not visible, such as rock, roots or buried obstructions on the line, a different fence height or material, or a change in the gate count. A verbal figure is not binding. Only a written estimate or contract that you accept is a final agreement.</p>

      <h2 id="project-work">4. Project Work</h2>
      <ul>
        <li>Each job is governed by a written estimate or contract for that job.</li>
        <li><?php echo h($companyName); ?> follows the Texas and local rules that apply to the fence being built.</li>
        <li>City permits and HOA approvals can be required before a fence goes up. We can check the requirements for your address, and the written estimate or contract will say who is responsible for obtaining each approval.</li>
        <li>Where the fence line depends on a property boundary, the written estimate or contract will say who confirms it. We recommend confirming the line from your survey or plat before any post hole is dug.</li>
      </ul>

      <h2 id="warranties">5. Warranties</h2>
      <p>Workmanship warranty terms, if any, are written into your estimate or contract. A manufacturer's warranty on a material comes from that manufacturer, for the materials that carry one. Warranties do not cover damage from storms or events beyond the ratings of the materials, damage from neglect or from changes made by others, or conditions that existed before the work and were pointed out to you.</p>

      <h2 id="payment">6. Payment Terms</h2>
      <p>Payment terms are stated in your written estimate or contract. Balances that are past due may accrue interest to the extent Texas law allows.</p>

      <h2 id="cancellation">7. Cancellation</h2>
      <p>Cancellation terms are stated in your written estimate or contract. If you cancel after materials have been ordered or work has begun, you owe payment for the materials ordered and the work done up to that point, as the contract describes.</p>

      <h2 id="liability">8. Limitation of Liability</h2>
      <p>To the fullest extent Texas law allows, the total liability of <?php echo h($companyName); ?> for any claim connected with this website or with our services is limited to the amount you paid for the specific service that caused the claim. We are not liable for indirect, incidental, special or consequential damages.</p>

      <h2 id="intellectual-property">9. Intellectual Property</h2>
      <p>The text, graphics, photographs and logos on this website belong to <?php echo h($companyName); ?> or are used with permission, and they are protected by copyright. You may not copy, distribute or adapt them without written permission.</p>

      <h2 id="governing-law">10. Governing Law and Disputes</h2>
      <p>These Terms are governed by the laws of the State of <?php echo h($companyState); ?>, without regard to conflict-of-laws rules. Disputes will be heard in the state or federal courts located in <?php echo h($companyCounty); ?>, <?php echo h($companyState); ?>.</p>

      <h2 id="changes">11. Changes to These Terms</h2>
      <p>We may update these Terms. The "Last updated" date at the top shows the latest version, and using the website after an update means you accept the revised Terms.</p>

      <h2 id="contact">12. Contact Us</h2>
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
