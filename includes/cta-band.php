<?php
/**
 * cta-band.php — the ONE mid-page estimate band for About and FAQ (never a hero form there).
 * Phase 5, 2026-10-19. Compact form (name | phone | email / service | button / consent | footnote), form id "cta-band".
 * Set before including (all optional):
 *   $ctaBandTitle  string  H2 text
 *   $ctaBandCopy   string  one short paragraph (plain text, escaped here)
 * Loop variables are $cta-prefixed (shared-include variable rule). Needs config.php + functions.php.
 */
$ctaBandTitle = $ctaBandTitle ?? 'Ready to talk through your fence?';
$ctaBandCopy  = $ctaBandCopy  ?? $siteName . ' calls back during business hours to set a time to walk the fence line.';
?>
<section class="cta-band texture-grain" id="estimate" aria-labelledby="cta-band-title">
  <span class="grain-layer" aria-hidden="true"></span>
  <div class="container-wide">
    <div class="cta-band__grid">
      <div class="cta-band__copy">
        <span class="eyebrow">Free estimate</span>
        <h2 id="cta-band-title"><?php echo h($ctaBandTitle); ?></h2>
        <p><?php echo h($ctaBandCopy); ?></p>
        <a class="link-call" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 18); ?>or call <?php echo h($phone); ?></a>
      </div>

      <div class="cta-band__card">
        <form action="<?php echo h($formAction); ?>" method="POST" class="cta-band__form">
          <?php echo p1_lead_hidden_fields('cta-band'); ?>
          <div class="field">
            <label for="cta-band-name">Your Name</label>
            <input id="cta-band-name" type="text" name="name" autocomplete="name" required>
          </div>
          <div class="field">
            <label for="cta-band-phone">Phone</label>
            <input id="cta-band-phone" type="tel" name="phone" autocomplete="tel" required>
          </div>
          <div class="field">
            <label for="cta-band-email">Email</label>
            <input id="cta-band-email" type="email" name="email" autocomplete="email" required>
          </div>
          <div class="field field--2">
            <label for="cta-band-service">Service Needed</label>
            <select id="cta-band-service" name="service">
              <option value="">Select a service</option>
<?php foreach ($services as $ctaOpt): ?>
              <option value="<?php echo h($ctaOpt['name']); ?>"><?php echo h($ctaOpt['name']); ?></option>
<?php endforeach; ?>
            </select>
          </div>
          <button type="submit" class="btn btn-primary btn-lg">Request estimate</button>
          <?php echo p1_consent_row('cta-band'), "\n"; ?>
          <p class="footnote">No obligation. The estimate is free.</p>
        </form>
      </div>
    </div>
  </div>
</section>
