<?php
/**
 * head.php — doctype, <head>, SEO, Open Graph, fonts, critical CSS, schema; opens <body>.
 * Phase 2, 2026-10-19. Pages set these BEFORE including it (all optional — sensible defaults below):
 *   $pageTitle, $pageDescription, $canonicalUrl, $ogImage, $currentPage, $pageType, $noindex,
 *   $heroPreload = ['srcset' => '…-480.avif 480w, …', 'sizes' => '100vw']   (photo-hero pages)
 *   $schemaMarkup  (JSON string, or array / list of arrays, of page-specific JSON-LD)
 * Never set $cssVersion on a page — it is the single framework.css cache-bust in config.php.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$hdTitle       = !empty($pageTitle) ? $pageTitle : defaultTitle();
$hdDescription = !empty($pageDescription) ? $pageDescription : defaultMetaDescription();
$hdCanonical   = !empty($canonicalUrl) ? $canonicalUrl : canonicalFromRequest();
$hdOgImage     = !empty($ogImage) ? $ogImage : defaultOgImage();
$hdPageType    = !empty($pageType) ? $pageType : 'other';
$hdNoindex     = !empty($noindex);
$hdGa          = (string) ($googleAnalyticsId ?? '');
$hdGaLive      = $hdGa !== '' && preg_match('/^G-[A-Z0-9]{6,}$/', $hdGa) && stripos($hdGa, 'XXXX') === false;
$hdLogo        = siteLogo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php echo generateMetaTags($hdTitle, $hdDescription, $hdCanonical), "\n"; ?>
<?php if ($hdNoindex): ?>
<meta name="robots" content="noindex, nofollow">
<?php endif; ?>
<?php if (!empty($gscVerification)): ?>
<meta name="google-site-verification" content="<?php echo h($gscVerification); ?>">
<?php endif; ?>

<!-- Open Graph -->
<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo h($hdTitle); ?>">
<meta property="og:description" content="<?php echo h($hdDescription); ?>">
<meta property="og:url" content="<?php echo h($hdCanonical); ?>">
<?php if ($hdOgImage !== ''): ?>
<meta property="og:image" content="<?php echo h(absoluteUrl($hdOgImage)); ?>">
<meta property="og:image:alt" content="<?php echo h($siteName . ' — ' . strtolower((string) $primaryKeyword) . ' in ' . placeLabel()); ?>">
<?php endif; ?>
<meta property="og:site_name" content="<?php echo h($siteName); ?>">
<meta property="og:locale" content="en_US">

<!-- Favicons -->
<link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">

<!-- Fonts: self-hosted (no Google Fonts CDN). Preload only the above-the-fold heading face (H1). -->
<link rel="preload" href="/assets/fonts/newsreader.woff2" as="font" type="font/woff2" crossorigin>

<!-- Critical CSS inline; framework.css loads non-blocking -->
<style><?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/critical.css'; ?></style>
<?php if ($hdLogo): ?>
<style>:root{--nav-height:<?php echo (int) $hdLogo['height'] + 20; ?>px;--navbar-height:<?php echo (int) $hdLogo['height'] + 20; ?>px}@media (max-width:1000px){:root{--nav-height:92px;--navbar-height:92px}}</style>
<?php endif; ?>
<link rel="preload" href="/assets/css/framework.css?v=<?php echo h($cssVersion); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="/assets/css/framework.css?v=<?php echo h($cssVersion); ?>"></noscript>
<?php if (!empty($heroPreload) && !empty($heroPreload['srcset'])): ?>
<link rel="preload" as="image" type="image/avif" imagesrcset="<?php echo h($heroPreload['srcset']); ?>" imagesizes="<?php echo h($heroPreload['sizes'] ?? '100vw'); ?>" fetchpriority="high">
<?php elseif (!empty($heroPreloadImage)): ?>
<link rel="preload" as="image" href="<?php echo h($heroPreloadImage); ?>" fetchpriority="high">
<?php endif; ?>

<?php if ($hdGaLive): ?>
<!-- Google Analytics 4 -->
<script defer src="https://www.googletagmanager.com/gtag/js?id=<?php echo h($hdGa); ?>"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','<?php echo h($hdGa); ?>');</script>
<?php else: ?>
<!-- Google Analytics 4 — placeholder. Set $googleAnalyticsId in includes/config.php to the client's G- measurement ID to activate:
<script defer src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('js',new Date());gtag('config','G-XXXXXXXXXX');</script>
-->
<?php endif; ?>

<!-- Structured data: LocalBusiness + WebSite (built from config.php; service-area business, no street address) -->
<script type="application/ld+json"><?php echo jsonLdEncode(buildLocalBusinessSchema($hdOgImage)); ?></script>
<?php
$hdBlocks = [];
if (!empty($schemaMarkup)) {
    $hdBlocks = is_string($schemaMarkup) ? [$schemaMarkup] : (isset($schemaMarkup['@type']) || isset($schemaMarkup['@graph']) ? [$schemaMarkup] : (array) $schemaMarkup);
}
foreach ($hdBlocks as $hdBlock): ?>
<script type="application/ld+json"><?php echo jsonLdEncode($hdBlock); ?></script>
<?php endforeach; ?>
</head>
<body class="page-<?php echo h($hdPageType); ?>">
