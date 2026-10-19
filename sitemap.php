<?php
/**
 * sitemap.php — dynamic XML sitemap, served at /sitemap.xml by the .htaccess rewrite (Phase 6, 2026-10-19).
 * Enumerates every indexable page that exists on disk; the blog index and every post come from the registry
 * (includes/blog-data.php via blogLoad()), so adding a post never needs a sitemap edit. /thank-you is noindex and excluded.
 * lastmod = file mtime for pages, the post's dateISO for blog posts.
 */
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

header('Content-Type: application/xml; charset=UTF-8');

$smRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
$smBase = rtrim($siteUrl, '/');
$smUrls = [];   // [path, file (for mtime) | null, lastmod override | null, changefreq, priority]

$smAdd = function (string $path, ?string $file, ?string $lastmod, string $freq, string $prio) use (&$smUrls, $smRoot) {
    if ($file !== null && !is_file($smRoot . $file)) return;                       // never list a page that is not built
    $smUrls[] = [$path, $file, $lastmod ?: ($file ? date('Y-m-d', filemtime($smRoot . $file)) : date('Y-m-d')), $freq, $prio];
};

$smAdd('/', '/index.php', null, 'weekly', '1.0');
$smAdd('/services/', '/services/index.php', null, 'monthly', '0.9');
foreach ((array) $services as $smSvc) {
    $smAdd('/services/' . $smSvc['slug'] . '/', '/services/' . $smSvc['slug'] . '/index.php', null, 'monthly', '0.8');
}
$smAdd('/service-areas/', '/service-areas/index.php', null, 'monthly', '0.8');
foreach ((array) $serviceAreas as $smArea) {
    $smSlug = getAreaSlug($smArea);
    $smAdd('/service-areas/' . $smSlug . '/', '/service-areas/' . $smSlug . '/index.php', null, 'monthly', '0.8');
}
$smAdd('/about/', '/about/index.php', null, 'monthly', '0.7');
$smAdd('/contact/', '/contact/index.php', null, 'monthly', '0.7');
$smAdd('/faq/', '/faq/index.php', null, 'monthly', '0.7');

// Blog: index + every registry post
if (is_file($smRoot . '/blog/index.php')) {
    $blogPosts = blogLoad();
    $smPosts = $blogPosts;
    $smAdd('/blog/', '/blog/index.php', $smPosts ? $smPosts[0]['dateISO'] : null, 'weekly', '0.7');
    foreach ($smPosts as $smPost) {
        $smAdd('/blog/' . $smPost['slug'] . '/', '/blog/' . $smPost['slug'] . '/index.php', $smPost['dateISO'], 'monthly', '0.6');
    }
}

foreach (['privacy-policy', 'terms', 'cookie-policy', 'accessibility'] as $smLegal) {
    $smAdd('/' . $smLegal . '/', '/' . $smLegal . '/index.php', null, 'yearly', '0.3');
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($smUrls as [$smPath, , $smMod, $smFreq, $smPrio]) {
    echo "  <url>\n";
    echo '    <loc>' . htmlspecialchars($smBase . $smPath, ENT_XML1) . "</loc>\n";
    echo '    <lastmod>' . $smMod . "</lastmod>\n";
    echo '    <changefreq>' . $smFreq . "</changefreq>\n";
    echo '    <priority>' . $smPrio . "</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>' . "\n";
