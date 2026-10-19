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
     * Link for one service area. /areas/{slug}/ once that page directory exists; otherwise the
     * /service-areas/ hub anchor when the hub is built; otherwise null (render the town as plain text).
     */
    function areaHref(string $area): ?string {
        $fnSlug = getAreaSlug($area);
        if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/areas/' . $fnSlug)) return '/areas/' . $fnSlug . '/';
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
