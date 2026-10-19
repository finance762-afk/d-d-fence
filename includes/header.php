<?php
/**
 * header.php — skip link, fixed glass navbar, mobile overlay menu; opens <main id="main-content">.
 * Phase 2, 2026-10-19. Include after head.php. footer.php closes <main>.
 * Loop variables are $nav-prefixed (shared-include variable rule — pages own $svc, $area, $c, $card).
 * Link integrity: the Services/Areas hub links, Blog and every area page appear only once they exist on disk
 * (area pages gated with is_dir() via areaHref(), falling back to the /service-areas/ hub anchor).
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$navLogo = siteLogo();
// Text lockup (used until a logo file lands in /assets/images/): "D&D" mark + company name over the trade.
$navWords    = preg_split('/\s+/', trim($siteName));
$navMarkText = preg_match('/^([A-Z])\s*&\s*([A-Z])\b/', trim($siteName), $navInit)
    ? $navInit[1] . '&' . $navInit[2]
    : strtoupper(substr($navWords[0], 0, 1) . substr($navWords[1] ?? '', 0, 1));
$navNameSub  = keywordCore();

$navServicesBuilt = pageBuilt('/services/');
$navAreasBuilt    = pageBuilt('/service-areas/');
$navAreaItems = [];   // [label, href] — only towns that have somewhere real to link
foreach ((array) $serviceAreas as $navArea) {
    $navHref = areaHref($navArea);
    if ($navHref !== null) $navAreaItems[] = [$navArea, $navHref];
}
$navShowAreas = $navAreasBuilt || $navAreaItems;
$navShowBlog  = pageBuilt('/blog/');
?>
<a href="#main-content" class="skip-link">Skip to main content</a>

<header class="site-header" data-header>
  <nav class="navbar" aria-label="Main navigation">
    <div class="navbar-inner container">

      <a class="site-logo navbar-logo" href="/" aria-label="<?php echo h($siteName); ?> — home">
<?php if ($navLogo): ?>
        <img src="<?php echo h($navLogo['src']); ?>" width="<?php echo (int) $navLogo['width']; ?>" height="<?php echo (int) $navLogo['height']; ?>" alt="<?php echo h($siteName); ?>" loading="eager"<?php echo $navLogo['class'] ? ' class="' . h($navLogo['class']) . '"' : ''; ?>>
<?php else: ?>
        <span class="logo-mark" aria-hidden="true"><?php echo h($navMarkText); ?></span>
        <span class="logo-text"><span class="brand-name"><?php echo h($siteName); ?></span><span class="brand-sub"><?php echo h($navNameSub); ?></span></span>
<?php endif; ?>
      </a>

      <ul class="navbar-links">
        <li><a href="/"<?php echo isActivePage('home') ? ' aria-current="page"' : ''; ?>>Home</a></li>
        <li class="has-dropdown">
<?php if ($navServicesBuilt): ?>
          <a href="/services/" aria-haspopup="true"<?php echo isActivePage('services') ? ' aria-current="page"' : ''; ?>>Services <?php echo icon('chevron-down', 16); ?></a>
<?php else: ?>
          <button type="button" class="dropdown-toggle" aria-haspopup="true">Services <?php echo icon('chevron-down', 16); ?></button>
<?php endif; ?>
          <ul class="dropdown" style="display:none">
<?php foreach ($services as $navSvc): ?>
            <li><a href="/services/<?php echo h($navSvc['slug']); ?>/"><?php echo h($navSvc['name']); ?></a></li>
<?php endforeach; ?>
          </ul>
        </li>
<?php if ($navShowAreas): ?>
        <li class="has-dropdown">
<?php if ($navAreasBuilt): ?>
          <a href="/service-areas/" aria-haspopup="true"<?php echo (isActivePage('service-areas') || isActivePage('areas')) ? ' aria-current="page"' : ''; ?>>Service Areas <?php echo icon('chevron-down', 16); ?></a>
<?php else: ?>
          <button type="button" class="dropdown-toggle" aria-haspopup="true">Service Areas <?php echo icon('chevron-down', 16); ?></button>
<?php endif; ?>
          <ul class="dropdown" style="display:none">
<?php foreach ($navAreaItems as $navItem): ?>
            <li><a href="<?php echo h($navItem[1]); ?>"><?php echo h($navItem[0]); ?></a></li>
<?php endforeach; ?>
          </ul>
        </li>
<?php endif; ?>
        <li><a href="/about/"<?php echo isActivePage('about') ? ' aria-current="page"' : ''; ?>>About</a></li>
<?php if ($navShowBlog): ?>
        <li><a href="/blog/"<?php echo isActivePage('blog') ? ' aria-current="page"' : ''; ?>>Blog</a></li>
<?php endif; ?>
        <li><a href="/contact/"<?php echo isActivePage('contact') ? ' aria-current="page"' : ''; ?>>Contact</a></li>
      </ul>

      <div class="navbar-cta">
        <a class="btn btn-secondary navbar-phone" href="tel:<?php echo h($phoneRaw); ?>" aria-label="Call <?php echo h($siteName); ?> at <?php echo h($phone); ?>"><?php echo icon('phone', 18); ?><span class="navbar-phone__text"><?php echo h($phone); ?></span></a>
        <?php echo estimateLink('btn btn-nav-cta', 'Free Estimate'), "\n"; ?>
      </div>

      <button class="hamburger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
        <span class="hamburger-line"></span>
      </button>

    </div>
  </nav>
</header>

<!-- Mobile overlay lives OUTSIDE <header>: the header's backdrop-filter would otherwise shrink position:fixed to bar height. main.js toggles .active + aria-hidden. -->
<div class="mobile-menu" id="mobile-menu" aria-hidden="true">
  <div class="mobile-menu-inner">
    <nav aria-label="Mobile navigation">
      <ul class="mobile-menu-links">
        <li><a href="/"<?php echo isActivePage('home') ? ' aria-current="page"' : ''; ?>>Home</a></li>
        <li>
<?php if ($navServicesBuilt): ?>
          <a href="/services/"<?php echo isActivePage('services') ? ' aria-current="page"' : ''; ?>>Services</a>
<?php else: ?>
          <span class="mm-label">Services</span>
<?php endif; ?>
          <ul class="mobile-submenu">
<?php foreach ($services as $navSvc): ?>
            <li><a href="/services/<?php echo h($navSvc['slug']); ?>/"><?php echo h($navSvc['name']); ?></a></li>
<?php endforeach; ?>
          </ul>
        </li>
<?php if ($navShowAreas): ?>
        <li>
<?php if ($navAreasBuilt): ?>
          <a href="/service-areas/"<?php echo (isActivePage('service-areas') || isActivePage('areas')) ? ' aria-current="page"' : ''; ?>>Service Areas</a>
<?php else: ?>
          <span class="mm-label">Service Areas</span>
<?php endif; ?>
          <ul class="mobile-submenu">
<?php foreach ($navAreaItems as $navItem): ?>
            <li><a href="<?php echo h($navItem[1]); ?>"><?php echo h($navItem[0]); ?></a></li>
<?php endforeach; ?>
          </ul>
        </li>
<?php endif; ?>
        <li><a href="/about/"<?php echo isActivePage('about') ? ' aria-current="page"' : ''; ?>>About</a></li>
<?php if ($navShowBlog): ?>
        <li><a href="/blog/"<?php echo isActivePage('blog') ? ' aria-current="page"' : ''; ?>>Blog</a></li>
<?php endif; ?>
        <li><a href="/contact/"<?php echo isActivePage('contact') ? ' aria-current="page"' : ''; ?>>Contact</a></li>
      </ul>
    </nav>
    <div class="mobile-menu-cta">
      <a class="btn btn-primary btn-lg" href="tel:<?php echo h($phoneRaw); ?>"><?php echo icon('phone', 20); ?>Call <?php echo h($phone); ?></a>
      <?php echo estimateLink('btn btn-outline-white btn-lg', 'Free Estimate'), "\n"; ?>
    </div>
    <p class="mobile-menu-meta"><?php echo h($businessHours); ?> · <?php echo h(areaList() . ', ' . $address['state']); ?></p>
  </div>
</div>

<main id="main-content">
