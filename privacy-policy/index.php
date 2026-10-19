<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/**
 * /privacy-policy/ — Privacy Policy (Phase 5, 2026-10-19). Adapted from ~/crm/references/legal-compliance.md.
 * Facts that are not in intake (entity type, state of formation, street address) are NOT printed; see config.php "Legal / company identity".
 * Formsubmit.co is retired: forms post to the Page One leads endpoint, so that is the processor this policy discloses.
 */
$pageTitle       = 'Privacy Policy | ' . $siteName;
$pageDescription = 'How ' . $siteName . ' collects, uses and protects the information you send through its fence estimate forms, phone calls and website in Ennis and Waxahachie, TX.';
$canonicalUrl    = $siteUrl . '/privacy-policy/';
$ogImage         = defaultOgImage();
$currentPage     = 'privacy-policy';
$pageType        = 'other';

$lgBase   = rtrim($siteUrl, '/');
$lgCrumbs = generateBreadcrumbSchema([['name' => 'Home', 'url' => '/'], ['name' => 'Privacy Policy', 'url' => '/privacy-policy/']]);
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
          <li><span aria-current="page">Privacy Policy</span></li>
        </ol>
      </nav>
      <span class="eyebrow">Legal</span>
      <h1 id="legal-title">Privacy Policy</h1>
      <p class="legal-meta">Last updated: <?php echo h($legalUpdated); ?></p>
    </div>
  </div>
</section>

<section class="legal-section">
  <div class="container">
    <article class="legal-prose content-narrow">

      <h2 id="introduction">1. Introduction</h2>
      <p>This Privacy Policy explains how <?php echo h($companyName); ?><?php echo $companyEntityType !== '' ? ', ' . h($companyEntityType) . ',' : ''; ?> ("we", "us", "our") collects, uses and protects personal information when you visit <?php echo h($domain); ?>, send an estimate request through one of our forms, or call us about a fence in Ennis, Waxahachie or the surrounding area.</p>

      <h2 id="information-we-collect">2. Information We Collect</h2>
      <ul>
        <li><strong>Information you give us:</strong> your name, phone number, email address, the service you are asking about, and anything you write in the project details or message box. If you call, we note your number and what you tell us about the job.</li>
        <li><strong>Consent choices:</strong> which consent boxes you checked on a form, the version of the consent wording shown, and the page the form was on.</li>
        <li><strong>Collected automatically:</strong> your IP address, browser type, device type, the pages you visit, the page that sent you here and timestamps.</li>
        <li><strong>Where you came from:</strong> the first page you landed on, the referring site, campaign tags in the link (UTM parameters), an advertising click ID if you arrived from a Google ad, and a random session ID. This is kept in a first-party cookie for up to 30 days and sent to us with any form you submit, so we can tell which page or ad brought the request in.</li>
        <li><strong>Cookies and similar technologies:</strong> described in our <a href="/cookie-policy/">Cookie Policy</a>.</li>
      </ul>

      <h2 id="how-we-use-information">3. How We Use Your Information</h2>
      <ul>
        <li>To answer your request and give you a fence estimate</li>
        <li>To schedule a visit to look at the fence line and to talk with you during a job</li>
        <li>To contact you by phone, email or text message where you have agreed to it (see section 6)</li>
        <li>To understand which pages and ads bring in requests, and to improve the website</li>
        <li>To keep records we need for business, tax and legal reasons</li>
      </ul>

      <h2 id="how-we-share-information">4. How We Share Your Information</h2>
      <ul>
        <li>We do <strong>not</strong> sell personal information, and we do not share it with other companies for their own marketing.</li>
        <li><strong>Page One Insights, LLC</strong> built and hosts this website. Its form-handling service receives each estimate request, delivers it to <?php echo h($companyName); ?>, keeps a copy of the submission together with your consent record, and gives Page One Insights a copy for lead tracking.</li>
        <li><strong>Google:</strong> when analytics is turned on, Google Analytics receives the usage data described in the Cookie Policy. Customer reviews shown on this site come from our Google Business Profile.</li>
        <li><strong>Hosting and technology providers</strong> that keep the website running, only as far as they need the data to do that.</li>
        <li><strong>Legal compliance:</strong> if the law, a court order or a government request requires it.</li>
        <li><strong>Business transfers:</strong> if the business is sold or merged, the records move with it.</li>
      </ul>

      <h2 id="your-rights">5. Your Privacy Rights</h2>

      <h3 id="state-rights">Texas Residents</h3>
      <p>If you live in Texas, you can ask us to confirm whether we hold personal information about you, to give you a copy, to correct it, or to delete it. Use the contact details in section 12.</p>

      <h3 id="ccpa-rights">California Residents (CCPA / CPRA)</h3>
      <p>If you are a California resident, you have these rights under the California Consumer Privacy Act and the California Privacy Rights Act:</p>
      <ul>
        <li><strong>Right to know</strong> what personal information we collect, use and disclose.</li>
        <li><strong>Right to delete</strong> personal information we collected from you, with some exceptions.</li>
        <li><strong>Right to correct</strong> inaccurate personal information.</li>
        <li><strong>Right to opt out of sale or sharing.</strong> We do not sell or share personal information, and you can still send us an opt-out request for our records.</li>
        <li><strong>Right to limit</strong> the use of sensitive personal information.</li>
        <li><strong>Right to non-discrimination.</strong> We will not deny you service or charge a different price for using these rights.</li>
      </ul>
      <p><strong>How to use these rights:</strong> email <?php echo emailLink(); ?> or call <?php echo phoneLink(); ?>. We respond within 45 days, and we confirm in writing when an opt-out or deletion request has been carried out.</p>

      <h3 id="other-state-rights">Residents of Other States</h3>
      <p>Residents of Colorado, Virginia, Connecticut, Utah and other states with privacy laws have similar rights. Contact us the same way to use them.</p>

      <h2 id="sms-and-phone">6. Phone, Email and Text Messages (TCPA)</h2>
      <p>Our estimate forms ask for three separate choices, and none of them is checked in advance:</p>
      <ul>
        <li><strong>Email updates (optional).</strong> If you check this box, <?php echo h($companyName); ?> may email you about your request, services, promotions and news. Every email carries an unsubscribe link, and you can also write to <?php echo emailLink(); ?>.</li>
        <li><strong>Text messages (optional).</strong> If you check this box, <?php echo h($companyName); ?> may text the number you gave us with appointment reminders, service updates and promotional offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe or HELP for help.</li>
        <li><strong>Privacy Policy and Terms (required).</strong> You must agree to this Privacy Policy and our <a href="/terms/">Terms of Service</a> to send the form. Agreeing to the policies is not consent to marketing messages.</li>
      </ul>
      <p>Consent to emails or texts is not a condition of buying anything. No mobile information is shared with third parties or affiliates for marketing or promotional purposes. We may still call you about the request you sent, and you can ask us to stop calling at any time by telling us or by emailing <?php echo emailLink(); ?>.</p>

      <h2 id="retention">7. How Long We Keep Information</h2>
      <p>We keep estimate requests, consent records and job records for as long as we need them to answer you, do the work, handle any warranty question, and meet business, tax and legal record-keeping rules. After that we delete them or remove what identifies you.</p>

      <h2 id="security">8. Data Security</h2>
      <p>This website uses HTTPS, so what you type into a form is encrypted on its way to us, and the form-handling service is hosted on secured infrastructure. No system is completely secure, and we cannot promise absolute security.</p>

      <h2 id="children">9. Children's Privacy</h2>
      <p>This website is not directed to children under 13 and we do not knowingly collect information from them. If you believe a child sent us information, contact us and we will delete it.</p>

      <h2 id="third-party-links">10. Links to Other Sites</h2>
      <p>This website links to other sites, including our Google Business Profile and Google Maps directions. Those sites have their own privacy practices, so read their policies separately.</p>

      <h2 id="changes">11. Changes to This Policy</h2>
      <p>We may update this policy from time to time. The "Last updated" date at the top shows the most recent change.</p>

      <h2 id="contact">12. Contact Us</h2>
      <p>For privacy questions or to use your rights:</p>
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
