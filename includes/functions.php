<?php
/**
 * functions.php — shared helpers for head.php / header.php / footer.php and pages.
 * Phase 2, 2026-10-19. Every function is guarded so the file can be required from any include.
 * Shared-include variable rule: locals inside these functions never reuse page names ($svc, $area, $c, $card).
 * Pages require config.php FIRST, then this file (config.php holds every value used below).
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/p1-form-helpers.php';   // p1_lead_hidden_fields(), p1_consent_row(), p1_service_options()

if (!function_exists('h')) {
    /** Escape for HTML text and attribute values. */
    function h($value): string {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}

// ── Request / navigation state ──────────────────────────────

if (!function_exists('requestPath')) {
    /** Request path with no query string and no trailing index.php, always starting with "/". */
    function requestPath(): string {
        $fnPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $fnPath = preg_replace('#/index\.php$#', '/', $fnPath);
        $fnPath = preg_replace('#\.php$#', '', $fnPath);
        return '/' . ltrim($fnPath, '/');
    }
}

if (!function_exists('isActivePage')) {
    /** True when $page is the current page: matches $currentPage, or the first URL segment. 'home' = "/". */
    function isActivePage(string $page): bool {
        global $currentPage;
        if (isset($currentPage) && $currentPage === $page) return true;
        $fnPath = requestPath();
        if ($page === 'home') return $fnPath === '/';
        return $fnPath === '/' . $page . '/' || $fnPath === '/' . $page || strpos($fnPath, '/' . $page . '/') === 0;
    }
}

if (!function_exists('pageBuilt')) {
    /** Link-integrity gate: true only when $path ("/about/") exists on disk as a directory index or a flat .php. */
    function pageBuilt(string $path): bool {
        $fnRoot = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/');
        $fnPath = trim($path, '/');
        if ($fnPath === '') return is_file($fnRoot . '/index.php');
        return is_file($fnRoot . '/' . $fnPath . '/index.php') || is_file($fnRoot . '/' . $fnPath . '.php');
    }
}

if (!function_exists('areaHref')) {
    /**
     * Link for one service area. /service-areas/{slug}/ once that page directory exists; otherwise the
     * /service-areas/ hub anchor when the hub is built; otherwise null (render the town as plain text).
     */
    function areaHref(string $area): ?string {
        $fnSlug = getAreaSlug($area);
        if (is_file($_SERVER['DOCUMENT_ROOT'] . '/service-areas/' . $fnSlug . '/index.php')) return '/service-areas/' . $fnSlug . '/';
        if (pageBuilt('/service-areas/')) return '/service-areas/#' . $fnSlug;
        return null;
    }
}

// ── Formatting / slugs ──────────────────────────────────────

if (!function_exists('formatPhone')) {
    /** "+14693217783" or "469.321.7783" → "(469) 321-7783". Returns the input unchanged if it is not 10/11 digits. */
    function formatPhone(string $phone): string {
        $fnDigits = preg_replace('/\D+/', '', $phone);
        if (strlen($fnDigits) === 11 && $fnDigits[0] === '1') $fnDigits = substr($fnDigits, 1);
        if (strlen($fnDigits) !== 10) return $phone;
        return '(' . substr($fnDigits, 0, 3) . ') ' . substr($fnDigits, 3, 3) . '-' . substr($fnDigits, 6);
    }
}

if (!function_exists('phoneLink')) {
    /** The site phone as a tel: link (use for every phone number that appears in body copy). */
    function phoneLink(): string {
        global $phone, $phoneRaw;
        return '<a href="tel:' . h($phoneRaw) . '">' . h($phone) . '</a>';
    }
}

if (!function_exists('emailLink')) {
    /** The site email as a mailto: link. */
    function emailLink(): string {
        global $email;
        return '<a href="mailto:' . h($email) . '">' . h($email) . '</a>';
    }
}

if (!function_exists('slugify')) {
    function slugify(string $text): string {
        $fnSlug = strtolower(str_replace('&', ' and ', $text));
        $fnSlug = preg_replace('/[^a-z0-9]+/', '-', $fnSlug);
        return trim($fnSlug, '-');
    }
}

if (!function_exists('getServiceSlug')) {
    /** Slug for a service name. Uses the config.php slug when the name matches a $services entry. */
    function getServiceSlug(string $name): string {
        global $services;
        foreach ((array) ($services ?? []) as $fnEntry) {
            if (is_array($fnEntry) && strcasecmp($fnEntry['name'] ?? '', $name) === 0 && !empty($fnEntry['slug'])) {
                return $fnEntry['slug'];
            }
        }
        return slugify($name);
    }
}

if (!function_exists('getAreaSlug')) {
    /** "Ennis, TX" → "ennis". State suffix is dropped. */
    function getAreaSlug(string $city): string {
        return slugify(preg_replace('/,\s*[A-Za-z]{2}$/', '', $city));
    }
}

if (!function_exists('cityFromArea')) {
    /** Split "Ennis, TX" → ['Ennis', 'TX']. */
    function cityFromArea(string $area): array {
        $fnParts = array_map('trim', explode(',', $area, 2));
        return [$fnParts[0], $fnParts[1] ?? ''];
    }
}

if (!function_exists('keywordCore')) {
    /** Primary keyword, title-cased: "fence contractor" → "Fence Contractor". */
    function keywordCore(): string {
        global $primaryKeyword;
        return ucwords(trim((string) ($primaryKeyword ?? '')));
    }
}

if (!function_exists('placeLabel')) {
    /**
     * "Ennis, TX" — the base city when config.php has one, else the first service area (primaryCity), then state.
     * build-plan has no street/city, so titles and copy anchor on the first listed service area until onboarding confirms the base.
     */
    function placeLabel(): string {
        global $address, $primaryCity;
        $fnCity = trim((string) ($address['city'] ?? '')) ?: trim((string) ($primaryCity ?? ''));
        return trim($fnCity . ', ' . ($address['state'] ?? ''), ', ');
    }
}

if (!function_exists('areaList')) {
    /** "Ennis and Waxahachie" / "A, B and C" from $serviceAreas (city names only). */
    function areaList(): string {
        global $serviceAreas;
        $fnCities = array_map(fn($fnA) => cityFromArea($fnA)[0], (array) $serviceAreas);
        if (count($fnCities) < 2) return implode('', $fnCities);
        return implode(', ', array_slice($fnCities, 0, -1)) . ' and ' . end($fnCities);
    }
}

// ── Icons (inline SVG at build time — never runtime injection) ──

if (!function_exists('icon')) {
    /**
     * Echo-ready inline SVG from references/lucide-icons/<name>.svg with aria-hidden, width/height and an optional class.
     * Returns '' when the file is missing so a bad name never breaks the page.
     */
    function icon(string $name, int $size = 20, string $class = ''): string {
        static $fnCache = [];
        if (!preg_match('/^[a-z0-9-]+$/', $name)) return '';
        if (!isset($fnCache[$name])) {
            $fnFile = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/') . '/references/lucide-icons/' . $name . '.svg';
            $fnRaw = is_file($fnFile) ? (string) file_get_contents($fnFile) : '';
            $fnStart = strpos($fnRaw, '<svg');            // files open with a license comment — drop it
            $fnCache[$name] = $fnStart === false ? '' : trim(substr($fnRaw, $fnStart));
        }
        if ($fnCache[$name] === '') return '';
        // Rewrite only the opening tag: strip width/height/class/aria-hidden, then set ours.
        $fnAttrs = ' aria-hidden="true" focusable="false" class="icon' . ($class !== '' ? ' ' . h($class) : '') . '" width="' . $size . '" height="' . $size . '"';
        return preg_replace_callback('/^<svg\b([^>]*)>/s', function ($fnTag) use ($fnAttrs) {
            $fnRest = preg_replace('/\s(width|height|class|aria-hidden|focusable)="[^"]*"/', '', $fnTag[1]);
            return '<svg' . $fnAttrs . ' ' . trim(preg_replace('/\s+/', ' ', $fnRest)) . '>';
        }, $fnCache[$name], 1);
    }
}

// ── Logo (image-first; text lockup only when no logo file exists) ──

if (!function_exists('siteLogo')) {
    /**
     * Finds the logo in /assets/images/ (newest versioned knock-out first). Returns
     * ['src','width','height','class'] sized to the LARGE-LOGO STANDARD by aspect ratio, or null → text logo.
     * No logo is staged on this build yet (build-plan assets.logo is null), so header/footer render the text lockup.
     */
    function siteLogo(): ?array {
        static $fnLogo = false;
        if ($fnLogo === false) {
            $fnLogo = null;
            $fnRoot = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/');
            $fnCandidates = array_merge(
                array_reverse(glob($fnRoot . '/assets/images/logo-mark-v*.png') ?: []),
                array_map(fn($fnF) => $fnRoot . '/assets/images/' . $fnF, ['logo-mark.png', 'logo.svg', 'logo.png', 'logo.webp'])
            );
            foreach ($fnCandidates as $fnFile) {
                if (!is_file($fnFile)) continue;
                $fnW = $fnH = 0;
                if (substr($fnFile, -4) === '.svg') {
                    $fnXml = @simplexml_load_file($fnFile);
                    if ($fnXml && !empty($fnXml['viewBox'])) {
                        $fnBox = preg_split('/[\s,]+/', trim((string) $fnXml['viewBox']));
                        if (count($fnBox) === 4) { $fnW = (float) $fnBox[2]; $fnH = (float) $fnBox[3]; }
                    }
                } else {
                    $fnSize = @getimagesize($fnFile);
                    if ($fnSize) { $fnW = $fnSize[0]; $fnH = $fnSize[1]; }
                }
                if ($fnW <= 0 || $fnH <= 0) continue;
                $fnRatio = $fnW / $fnH;
                // wordmark >3:1 → 120px, combination 1.5–3:1 → 96px, square → 88px (CSS: .logo--wordmark / .logo--square)
                $fnHeight = $fnRatio > 3 ? 120 : ($fnRatio >= 1.5 ? 96 : 88);
                $fnLogo = [
                    'src'    => str_replace($fnRoot, '', $fnFile),
                    'width'  => (int) round($fnHeight * $fnRatio),
                    'height' => $fnHeight,
                    'class'  => $fnRatio > 3 ? 'logo--wordmark' : ($fnRatio >= 1.5 ? '' : 'logo--square'),
                ];
                break;
            }
        }
        return $fnLogo;
    }
}

// ── Hours / schema ──────────────────────────────────────────

if (!function_exists('hoursSpecs')) {
    /** $hours (config.php rows) → OpeningHoursSpecification nodes, consecutive days with identical hours grouped; closed days skipped. */
    function hoursSpecs(): array {
        global $hours;
        $fnGroups = [];
        foreach ((array) $hours as $fnRow) {
            if (empty($fnRow['opens']) || empty($fnRow['closes'])) continue;
            $fnKey = $fnRow['opens'] . '-' . $fnRow['closes'];
            $fnGroups[$fnKey]['opens'] = $fnRow['opens'];
            $fnGroups[$fnKey]['closes'] = $fnRow['closes'];
            $fnGroups[$fnKey]['days'][] = $fnRow['day'];
        }
        $fnSpecs = [];
        foreach ($fnGroups as $fnG) {
            $fnSpecs[] = ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => $fnG['days'], 'opens' => $fnG['opens'], 'closes' => $fnG['closes']];
        }
        return $fnSpecs;
    }
}

if (!function_exists('absoluteUrl')) {
    function absoluteUrl(string $path): string {
        global $siteUrl;
        if (preg_match('#^https?://#i', $path)) return $path;
        return rtrim((string) $siteUrl, '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('defaultOgImage')) {
    /** Site OG/schema image path (local), or '' when none exists on disk yet. */
    function defaultOgImage(): string {
        $fnRoot = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/');
        foreach (['/assets/images/og-default-v1.jpg', '/assets/images/og-default.jpg'] as $fnPath) {
            if (is_file($fnRoot . $fnPath)) return $fnPath;
        }
        $fnLogo = siteLogo();
        return $fnLogo ? $fnLogo['src'] : '';
    }
}

if (!function_exists('buildLocalBusinessSchema')) {
    /**
     * The site-wide @graph: HomeAndConstructionBusiness (#organization) + WebSite. Built only from config.php:
     * empty values are omitted, a service-area business (address_public false) never gets a streetAddress,
     * and there is no self-serving rating markup, ever.
     */
    function buildLocalBusinessSchema(string $ogImage = ''): array {
        global $siteName, $siteUrl, $phoneE164, $email, $address, $addressPublic, $geo, $services, $serviceAreas,
               $gbp, $socialLinks, $businessDescription;

        $fnAddress = ['@type' => 'PostalAddress'];
        if (!empty($addressPublic) && !empty($address['street'])) $fnAddress['streetAddress'] = $address['street']; // address_public:false → never the street
        if (!empty($address['city']))  $fnAddress['addressLocality'] = $address['city'];
        if (!empty($address['state'])) $fnAddress['addressRegion'] = $address['state'];
        if (!empty($address['zip']))   $fnAddress['postalCode'] = $address['zip'];
        $fnAddress['addressCountry'] = 'US';

        $fnStates = ['TX' => 'Texas'];
        $fnAreas = [];
        foreach ((array) $serviceAreas as $fnArea) {
            [$fnCity, $fnSt] = cityFromArea($fnArea);
            $fnNode = ['@type' => 'City', 'name' => $fnCity];
            if ($fnSt !== '') $fnNode['containedInPlace'] = ['@type' => 'State', 'name' => $fnStates[strtoupper($fnSt)] ?? strtoupper($fnSt)];
            $fnAreas[] = $fnNode;
        }

        $fnOffers = [];
        foreach ((array) $services as $fnEntry) {
            if (empty($fnEntry['name'])) continue;
            $fnOffers[] = ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $fnEntry['name']]];
        }

        $fnSameAs = array_values(array_filter(array_merge([(string) ($gbp['url'] ?? '')], array_values((array) $socialLinks))));

        $fnBiz = [
            '@type'       => 'HomeAndConstructionBusiness',
            '@id'         => rtrim($siteUrl, '/') . '/#organization',
            'name'        => $siteName,
            'url'         => rtrim($siteUrl, '/') . '/',
            'telephone'   => $phoneE164,
            'email'       => $email,
            'description' => $businessDescription,
            'address'     => $fnAddress,
            'areaServed'  => $fnAreas,
        ];
        if (!empty($geo['lat']) && !empty($geo['lng'])) $fnBiz['geo'] = ['@type' => 'GeoCoordinates', 'latitude' => $geo['lat'], 'longitude' => $geo['lng']];
        if (!empty($gbp['url'])) $fnBiz['hasMap'] = $gbp['url'];
        if ($ogImage !== '') $fnBiz['image'] = absoluteUrl($ogImage);
        if ($fnSpecs = hoursSpecs()) $fnBiz['openingHoursSpecification'] = $fnSpecs;
        if ($fnOffers) $fnBiz['hasOfferCatalog'] = ['@type' => 'OfferCatalog', 'name' => $siteName . ' services', 'itemListElement' => $fnOffers];
        if ($fnSameAs) $fnBiz['sameAs'] = $fnSameAs;

        return [
            '@context' => 'https://schema.org',
            '@graph'   => [
                $fnBiz,
                ['@type' => 'WebSite', '@id' => rtrim($siteUrl, '/') . '/#website', 'url' => rtrim($siteUrl, '/') . '/', 'name' => $siteName, 'publisher' => ['@id' => rtrim($siteUrl, '/') . '/#organization']],
            ],
        ];
    }
}

if (!function_exists('generateServiceSchema')) {
    /** Service node for a $services entry (config.php shape). Provider points at the homepage @id — no duplicate business block. */
    function generateServiceSchema(array $service): array {
        global $siteUrl, $serviceAreas;
        $fnSlug = $service['slug'] ?? getServiceSlug($service['name'] ?? '');
        $fnAreas = [];
        foreach ((array) $serviceAreas as $fnArea) {   // same towns the page and footer list
            [$fnCity, $fnSt] = cityFromArea($fnArea);
            $fnAreas[] = ['@type' => 'City', 'name' => $fnCity, 'containedInPlace' => ['@type' => 'State', 'name' => strtoupper($fnSt) === 'TX' ? 'Texas' : strtoupper($fnSt)]];
        }
        return [
            '@context'    => 'https://schema.org',
            '@type'       => 'Service',
            'name'        => $service['name'] ?? '',
            'description' => $service['description'] ?? '',
            'url'         => rtrim($siteUrl, '/') . '/services/' . $fnSlug . '/',
            'serviceType' => $service['name'] ?? '',
            'provider'    => ['@id' => rtrim($siteUrl, '/') . '/#organization'],
            'areaServed'  => $fnAreas,
        ];
    }
}

if (!function_exists('generateFAQSchema')) {
    /** FAQPage from [['q'=>…, 'a'=>…], …]. AI-comprehension aid only (FAQ rich results are deprecated). */
    function generateFAQSchema(array $faqs): array {
        $fnItems = [];
        foreach ($faqs as $fnFaq) {
            $fnQ = $fnFaq['q'] ?? ($fnFaq['question'] ?? '');
            $fnA = $fnFaq['a'] ?? ($fnFaq['answer'] ?? '');
            if ($fnQ === '' || $fnA === '') continue;
            $fnItems[] = ['@type' => 'Question', 'name' => $fnQ, 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $fnA]];
        }
        return ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => $fnItems];
    }
}

if (!function_exists('generateBreadcrumbSchema')) {
    /** BreadcrumbList from [['name'=>'Home','url'=>'/'], …]; urls may be relative. */
    function generateBreadcrumbSchema(array $crumbs): array {
        $fnItems = [];
        foreach (array_values($crumbs) as $fnIdx => $fnCrumb) {
            $fnItems[] = ['@type' => 'ListItem', 'position' => $fnIdx + 1, 'name' => $fnCrumb['name'], 'item' => absoluteUrl($fnCrumb['url'])];
        }
        return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $fnItems];
    }
}

if (!function_exists('jsonLdEncode')) {
    /** JSON-LD body for an array or a ready JSON string (safe inside <script>). */
    function jsonLdEncode($data): string {
        return is_string($data) ? $data : (string) json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP);
    }
}

// ── SEO ─────────────────────────────────────────────────────

if (!function_exists('defaultTitle')) {
    /** Fallback <title> (pages should set $pageTitle): "Fence Contractor in Ennis, TX | D & D Fence". */
    function defaultTitle(): string {
        global $siteName;
        return keywordCore() . ' in ' . placeLabel() . ' | ' . $siteName;
    }
}

if (!function_exists('defaultMetaDescription')) {
    /** Fallback description (pages should set $pageDescription). Uses only facts that are in build-plan.json / config.php. */
    function defaultMetaDescription(): string {
        global $siteName, $phone, $primaryKeyword, $address;
        $fnText = $siteName . ' is a ' . strtolower((string) $primaryKeyword) . ' serving ' . areaList() . ', ' . ($address['state'] ?? '')
                . '. Privacy, cedar, chain link and wrought iron fences. Call ' . $phone . ' for pricing.';
        if (mb_strlen($fnText) > 160) $fnText = rtrim(mb_substr($fnText, 0, 157), " ,.:;") . '...';
        return $fnText;
    }
}

if (!function_exists('canonicalFromRequest')) {
    /** Self-referencing canonical: site URL + request path, trailing slash for directory pages, no query string. */
    function canonicalFromRequest(): string {
        global $siteUrl;
        $fnPath = requestPath();
        if ($fnPath !== '/' && !preg_match('#\.[a-z0-9]{2,5}$#i', $fnPath)) $fnPath = rtrim($fnPath, '/') . '/';
        return rtrim((string) $siteUrl, '/') . $fnPath;
    }
}

if (!function_exists('generateMetaTags')) {
    /** <title>, meta description and canonical for the given values (all escaped). */
    function generateMetaTags(string $title, string $description, string $canonical): string {
        return '<title>' . h($title) . '</title>' . "\n"
             . '<meta name="description" content="' . h($description) . '">' . "\n"
             . '<link rel="canonical" href="' . h($canonical) . '">';
    }
}

if (!function_exists('serviceLink')) {
    /**
     * Body-copy link to a service page — an <a> once /services/{slug}/ exists on disk, plain escaped text until then
     * (link-integrity rule: never link a page that is not built yet). $label defaults to the config.php service name.
     */
    function serviceLink(string $slug, string $label = ''): string {
        global $services;
        if ($label === '') {
            foreach ((array) $services as $fnEntry) {
                if (($fnEntry['slug'] ?? '') === $slug) { $label = strtolower((string) $fnEntry['name']); break; }
            }
        }
        $fnLabel = h($label !== '' ? $label : $slug);
        return pageBuilt('/services/' . $slug . '/') ? '<a href="' . h('/' . implode('/', ['services', $slug]) . '/') . '">' . $fnLabel . '</a>' : $fnLabel;
    }
}

// ── Estimate triggers ───────────────────────────────────────

if (!function_exists('estimateLink')) {
    /**
     * "Free estimate" control. Anchor to /contact/ so it still works without JavaScript; main.js intercepts
     * [data-open-estimate] and opens #estimate-dialog instead (footer.php carries the dialog on every page).
     */
    function estimateLink(string $class, string $label): string {
        return '<a class="' . h($class) . '" href="/contact/" data-open-estimate>' . $label . '</a>';
    }
}

// ── Service pages (Phase 4) ─────────────────────────────────

if (!function_exists('serviceReviews')) {
    /**
     * Real Google reviews for one service page: the Page One feed (google-reviews.php — server-side, cached on disk)
     * filtered to reviews whose text matches $pattern (a case-insensitive regex body, e.g. 'iron|steel|pool').
     * Text is never hard-coded or edited; the page prints it escaped, exactly as written on Google.
     * Returns ['reviews' => [...], 'rating' => float|null, 'count' => int, 'url' => string] or null when the feed is
     * unreachable or nothing matches (the page then drops its proof section — fail-quiet, like p1_google_reviews()).
     */
    function serviceReviews(string $pattern, int $limit = 3): ?array {
        global $slug;
        require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/google-reviews.php';
        $fnFeed = p1_google_reviews_data($slug, 30, 4);
        if (!$fnFeed || empty($fnFeed['reviews'])) return null;
        $fnHits = [];
        foreach ($fnFeed['reviews'] as $fnRev) {
            $fnText = (string) ($fnRev['text'] ?? '');
            if ($fnText === '' || !preg_match('/' . str_replace('/', '\/', $pattern) . '/i', $fnText)) continue;
            $fnHits[] = $fnRev;
            if (count($fnHits) >= $limit) break;
        }
        if (!$fnHits) return null;
        return [
            'reviews' => $fnHits,
            'rating'  => isset($fnFeed['rating']) ? (float) $fnFeed['rating'] : null,
            'count'   => (int) ($fnFeed['review_count'] ?? count($fnFeed['reviews'])),
            'url'     => (string) ($fnFeed['reviews_url'] ?? ($GLOBALS['gbp']['url'] ?? '')),
        ];
    }
}

if (!function_exists('servicePageSchema')) {
    /**
     * One @graph for a service page: WebPage (speakable → .hero-answer / .answer-block) + Service (#service-{slug},
     * provider = the homepage #organization) + BreadcrumbList, plus FAQPage only when the page shows real FAQs
     * ($faqs: the page's generateFAQSchema() node, or a raw Q/A list).
     */
    function servicePageSchema(array $service, string $pageName, string $description, array $faqs = [], array $extra = []): array {
        global $siteUrl;
        $fnBase  = rtrim((string) $siteUrl, '/');
        $fnUrl   = $fnBase . '/services/' . $service['slug'] . '/';
        $fnSvc   = generateServiceSchema($service);
        unset($fnSvc['@context']);
        $fnSvc['@id']         = $fnUrl . '#service-' . $service['slug'];
        $fnSvc['description'] = $description;
        $fnSvc = array_merge($fnSvc, $extra);
        $fnCrumbs = generateBreadcrumbSchema([
            ['name' => 'Home', 'url' => '/'],
            ['name' => 'Services', 'url' => '/services/'],
            ['name' => $service['name'], 'url' => '/services/' . $service['slug'] . '/'],
        ]);
        unset($fnCrumbs['@context']);
        $fnCrumbs['@id'] = $fnUrl . '#breadcrumb';
        $fnGraph = [
            [
                '@type'      => 'WebPage',
                '@id'        => $fnUrl . '#webpage',
                'url'        => $fnUrl,
                'name'       => $pageName,
                'isPartOf'   => ['@id' => $fnBase . '/#website'],
                'about'      => ['@id' => $fnSvc['@id']],
                'breadcrumb' => ['@id' => $fnCrumbs['@id']],
                'speakable'  => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']],
            ],
            $fnSvc,
            $fnCrumbs,
        ];
        if ($faqs) {
            // Pages pass generateFAQSchema($faqs) (a FAQPage node); a plain Q/A list is accepted too.
            $fnFaq = isset($faqs['@type']) ? $faqs : generateFAQSchema($faqs);
            unset($fnFaq['@context']);
            $fnFaq['@id'] = $fnUrl . '#faq';
            $fnGraph[] = $fnFaq;
        }
        return ['@context' => 'https://schema.org', '@graph' => $fnGraph];
    }
}

if (!function_exists('serviceCards')) {
    /** Card copy for the required services component (icon, ≤14-word description, exactly 3 bullets), keyed by slug. */
    function serviceCards(): array {
        return [
            'privacy-fence'      => ['icon' => 'fence',        'desc' => 'Solid board fences that close a backyard off from the street and neighbors.',
                                     'bullets' => ['Blocks sightlines into the yard', 'Keeps pets and kids contained', 'Marks the property line clearly']],
            'cedar-fence'        => ['icon' => 'trees',        'desc' => 'Cedar board fencing for a natural wood look around the yard.',
                                     'bullets' => ['Rot-resistant wood by nature', 'Takes stain or sealer well', 'Weathers to a soft silver']],
            'chain-link'         => ['icon' => 'link',         'desc' => 'Galvanized wire-mesh fencing for yards, perimeters and secure areas.',
                                     'bullets' => ['Lowest material cost per foot', 'Keeps dogs inside the yard', 'Leaves the view wide open']],
            'wrought-iron'       => ['icon' => 'shield-check', 'desc' => 'Ornamental metal fencing for front yards, entries, pools and security.',
                                     'bullets' => ['Decorative without blocking views', 'Little upkeep once coated', 'Pairs with matching gates']],
            'fence-repair'       => ['icon' => 'wrench',       'desc' => 'Fixes for leaning posts, broken boards and gates that no longer latch.',
                                     'bullets' => ['Leaning posts set straight', 'Broken pickets and rails replaced', 'Sagging gates closing again']],
            'fence-installation' => ['icon' => 'hammer',       'desc' => 'New fence and gate installation for residential and farm properties.',
                                     'bullets' => ['Layout walked before digging', 'Gates planned into the run', 'Homes, acreage and farms']],
        ];
    }
}

if (!function_exists('serviceBySlug')) {
    /** The config.php $services entry for a slug (pages fail loudly in dev if the slug is wrong). */
    function serviceBySlug(string $slug): array {
        global $services;
        foreach ((array) $services as $fnEntry) {
            if (($fnEntry['slug'] ?? '') === $slug) return $fnEntry;
        }
        trigger_error('Unknown service slug: ' . $slug, E_USER_WARNING);
        return ['name' => $slug, 'slug' => $slug, 'description' => ''];
    }
}


// ── Service area pages + blog (Phase 6) ─────────────────────

if (!function_exists('areaPageSchema')) {
    /**
     * One @graph for /service-areas/{slug}/: WebPage (speakable) + Service (provider = homepage #organization, areaServed = this town)
     * + the business @id restated with areaServed for this town only (same @id as head.php's node, so it merges — it is not a second business)
     * + BreadcrumbList, plus FAQPage only when the page shows real FAQs.
     * $town: ['slug','name','wiki' (optional Wikipedia URL for sameAs)]. $faqs: raw Q/A list.
     */
    function areaPageSchema(array $town, string $pageName, string $description, array $faqs = []): array {
        global $siteUrl, $siteName;
        $fnBase = rtrim((string) $siteUrl, '/');
        $fnUrl  = $fnBase . '/service-areas/' . $town['slug'] . '/';
        $fnCity = ['@type' => 'City', 'name' => $town['name'], 'containedInPlace' => ['@type' => 'State', 'name' => 'Texas']];
        if (!empty($town['wiki'])) $fnCity['sameAs'] = $town['wiki'];
        $fnCrumbs = generateBreadcrumbSchema([
            ['name' => 'Home', 'url' => '/'],
            ['name' => 'Service Areas', 'url' => '/service-areas/'],
            ['name' => $town['name'] . ', TX', 'url' => '/service-areas/' . $town['slug'] . '/'],
        ]);
        unset($fnCrumbs['@context']);
        $fnCrumbs['@id'] = $fnUrl . '#breadcrumb';
        $fnGraph = [
            [
                '@type'      => 'WebPage',
                '@id'        => $fnUrl . '#webpage',
                'url'        => $fnUrl,
                'name'       => $pageName,
                'isPartOf'   => ['@id' => $fnBase . '/#website'],
                'about'      => ['@id' => $fnUrl . '#service'],
                'breadcrumb' => ['@id' => $fnCrumbs['@id']],
                'speakable'  => ['@type' => 'SpeakableSpecification', 'cssSelector' => ['h1', '.hero-answer', '.answer-block']],
            ],
            [
                '@type'       => 'Service',
                '@id'         => $fnUrl . '#service',
                'name'        => 'Fence installation and repair in ' . $town['name'] . ', TX',
                'serviceType' => 'Fence installation',
                'description' => $description,
                'url'         => $fnUrl,
                'provider'    => ['@id' => $fnBase . '/#organization'],
                'areaServed'  => $fnCity,
            ],
            [
                '@type'      => 'HomeAndConstructionBusiness',
                '@id'        => $fnBase . '/#organization',
                'name'       => $siteName,
                'url'        => $fnBase . '/',
                'areaServed' => $fnCity,
            ],
            $fnCrumbs,
        ];
        if ($faqs) {
            $fnFaq = generateFAQSchema($faqs);
            unset($fnFaq['@context']);
            $fnFaq['@id'] = $fnUrl . '#faq';
            $fnGraph[] = $fnFaq;
        }
        return ['@context' => 'https://schema.org', '@graph' => $fnGraph];
    }
}

if (!function_exists('blogLoad')) {
    /** The blog registry (includes/blog-data.php, newest first). Safe to call from any scope. */
    function blogLoad(): array {
        $blogPosts = [];
        require $_SERVER['DOCUMENT_ROOT'] . '/includes/blog-data.php';
        return $blogPosts;
    }
}

if (!function_exists('blogPostBySlug')) {
    function blogPostBySlug(string $slug): array {
        foreach (blogLoad() as $fnPost) {
            if ($fnPost['slug'] === $slug) return $fnPost;
        }
        trigger_error('Unknown blog slug: ' . $slug, E_USER_WARNING);
        return [];
    }
}

if (!function_exists('blogCard')) {
    /**
     * One registry post as a .blog-card. Posts with a real image file use it; posts without one get the typographic
     * fence-board art panel (decorative, aria-hidden) — never a missing or hotlinked image.
     */
    function blogCard(array $post, string $class = ''): string {
        $fnRoot = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/');
        $fnHasImg = !empty($post['image']) && is_file($fnRoot . $post['image']);
        $fnHref = '/blog/' . $post['slug'] . '/';
        $fnOut  = '<a class="blog-card' . ($class !== '' ? ' ' . h($class) : '') . '" href="' . h($fnHref) . '">';
        if ($fnHasImg) {
            $fnOut .= sprintf('<div class="blog-card__image"><img src="%s" alt="%s" width="960" height="600" loading="lazy" decoding="async"></div>', h($post['image']), h($post['alt'] ?? ''));
        } else {
            $fnOut .= '<div class="blog-card__art" aria-hidden="true"><span>' . h($post['category']) . '</span></div>';
        }
        $fnOut .= '<div class="blog-card__body">'
                . '<span class="blog-card__category">' . h($post['category']) . '</span>'
                . '<h3 class="blog-card__title">' . h($post['title']) . '</h3>'
                . '<p class="blog-card__excerpt">' . h($post['excerpt']) . '</p>'
                . '<span class="blog-card__meta"><time datetime="' . h($post['dateISO']) . '">' . h($post['date']) . '</time> · ' . h($post['readtime']) . '</span>'
                . '<span class="blog-card__cta">Read Article →</span>'
                . '</div></a>';
        return $fnOut;
    }
}

if (!function_exists('blogPostSchema')) {
    /**
     * @graph for /blog/{slug}/: BlogPosting (author = Page One Insights LLC, publisher = the client #organization)
     * + BreadcrumbList (Home → Blog → Post) + FAQPage mirroring the visible FAQ ($faqNode = generateFAQSchema($faqs), built by the post).
     */
    function blogPostSchema(array $post, array $keywords, array $faqNode = []): array {
        global $siteUrl;
        $fnBase = rtrim((string) $siteUrl, '/');
        $fnUrl  = $fnBase . '/blog/' . $post['slug'] . '/';
        $fnRoot = rtrim($_SERVER['DOCUMENT_ROOT'] ?? '', '/');
        $fnPosting = [
            '@type'            => 'BlogPosting',
            '@id'              => $fnUrl . '#article',
            'headline'         => $post['title'],
            'description'      => $post['excerpt'],
            'datePublished'    => $post['dateISO'],
            'dateModified'     => $post['dateISO'],
            'keywords'         => implode(', ', $keywords),
            'articleSection'   => $post['category'],
            'inLanguage'       => 'en-US',
            'mainEntityOfPage' => $fnUrl,
            'author'           => ['@type' => 'Organization', 'name' => 'Page One Insights LLC', 'url' => 'https://pageoneinsights.com'],
            'publisher'        => ['@id' => $fnBase . '/#organization'],
        ];
        if (!empty($post['image']) && is_file($fnRoot . $post['image'])) $fnPosting['image'] = absoluteUrl($post['image']);
        $fnCrumbs = generateBreadcrumbSchema([
            ['name' => 'Home', 'url' => '/'],
            ['name' => 'Blog', 'url' => '/blog/'],
            ['name' => $post['title'], 'url' => '/blog/' . $post['slug'] . '/'],
        ]);
        unset($fnCrumbs['@context']);
        $fnGraph = [$fnPosting, $fnCrumbs];
        if ($faqNode) {   // the post passes generateFAQSchema($faqs) — a FAQPage node mirroring its visible FAQ
            unset($faqNode['@context']);
            $fnGraph[] = $faqNode;
        }
        return ['@context' => 'https://schema.org', '@graph' => $fnGraph];
    }
}

if (!function_exists('blogRelatedServicesHtml')) {
    /** "Related Services" block for a post: links to service pages that exist, both service-area pages, and contact. */
    function blogRelatedServicesHtml(array $serviceSlugs): string {
        $fnOut = '<section class="blog-post__related-services" aria-labelledby="related-services-title"><h2 id="related-services-title">Related fence services</h2><ul>';
        foreach ($serviceSlugs as $fnSlug) {
            if (!pageBuilt('/services/' . $fnSlug . '/')) continue;
            $fnSvc = serviceBySlug($fnSlug);
            $fnOut .= '<li><a href="' . h('/' . implode('/', ['services', $fnSlug]) . '/') . '">' . h($fnSvc['name']) . '</a></li>';
        }
        foreach (['Ennis, TX', 'Waxahachie, TX'] as $fnArea) {
            $fnHref = areaHref($fnArea);
            if ($fnHref !== null) $fnOut .= '<li><a href="' . h($fnHref) . '">Fence contractor in ' . h(cityFromArea($fnArea)[0]) . '</a></li>';
        }
        if (pageBuilt('/contact/')) $fnOut .= '<li><a href="/contact/">Contact D &amp; D Fence</a></li>';
        return $fnOut . '</ul></section>';
    }
}

if (!function_exists('blogRelatedArticlesHtml')) {
    /** "Related Articles" block: up to $max registry cards, same category first, then newest; never the current post. */
    function blogRelatedArticlesHtml(string $currentSlug, int $max = 3): string {
        $fnCurrent = blogPostBySlug($currentSlug);
        $fnSame = $fnOther = [];
        foreach (blogLoad() as $fnPost) {
            if ($fnPost['slug'] === $currentSlug) continue;
            if (($fnPost['category'] ?? '') === ($fnCurrent['category'] ?? '')) $fnSame[] = $fnPost; else $fnOther[] = $fnPost;
        }
        $fnPicked = array_slice(array_merge($fnSame, $fnOther), 0, $max);
        if (!$fnPicked) return '';
        $fnOut = '<section class="blog-post__related-articles" aria-labelledby="related-articles-title"><h2 id="related-articles-title">Related articles</h2><div class="blog-grid">';
        foreach ($fnPicked as $fnPost) $fnOut .= blogCard($fnPost);
        return $fnOut . '</div></section>';
    }
}
