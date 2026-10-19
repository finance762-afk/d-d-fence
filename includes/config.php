<?php
/**
 * includes/config.php — single source of site-wide variables (D & D Fence).
 * Every value below traces to build-plan.json. Nothing here is invented: values the plan leaves blank
 * (street address, ZIP, tagline, social links, license, insurance, GBP review count, geo) stay empty
 * and the templates omit anything empty.
 */

// ---- Identity ---------------------------------------------------------------------------------
$slug          = 'd-d-fence';                          // exact build directory name
$siteName      = 'D & D Fence';                        // build-plan company_name
$tagline       = '';                                   // build-plan tagline is empty — never invent
$industry      = 'fencing';
$industryLabel = 'Fence contractor';                   // build-plan industry
$ownerName     = 'Austin Dunnahue';

// ---- Contact ----------------------------------------------------------------------------------
$phone          = '(469) 321-7783';
$phoneRaw       = '4693217783';
$phoneE164      = '+14693217783';
$phoneSecondary = '';
$email          = 'dunnahuea@gmail.com';
$contactEmail   = $email;
// Lead routing only (server-side, never rendered)
$leadNotificationEmail = 'dunnahuea@gmail.com';
$leadNotificationPhone = '(469) 321-7783';

// Service-area business: address_public is false and the plan holds no street/city/zip, so none is printed or put in schema.
// State is TX per the build-plan description ("serving Ennis and Waxahachie, TX"). Base city is UNKNOWN — confirm at onboarding.
$addressPublic = false;
$address = ['street' => '', 'city' => '', 'state' => 'TX', 'zip' => ''];
// First-listed service area, used where a page needs one anchor town (titles, identity sentence) until the base city is confirmed.
$primaryCity = 'Ennis';

// ---- Domain / URLs ----------------------------------------------------------------------------
// build-plan has no production_domain (the old site ddfencetx.com is listed only as a web source), so default to the preview host.
$domain  = 'd-d-fence.pageone.cloud';
$siteUrl = 'https://' . $domain;
// $canonicalUrl is NOT set here — each page sets its own from $siteUrl + path before including head.php.

// ---- SEO --------------------------------------------------------------------------------------
$primaryKeyword    = 'fence contractor';
// build-plan secondary_keywords, split where the plan ran several phrases together, de-duplicated
$secondaryKeywords = [
    'wood fence installation', 'chain link fencing', 'fence repair', 'gate installation', 'privacy fences',
    'wrought iron fencing', 'cedar fencing', 'privacy fencing', 'security fencing', 'decorative fencing',
    'backyard fencing', 'pool fence installation', 'farm fencing', 'agricultural fencing', 'fence gates',
    'automatic gate installation',
];

// ---- Services (6 — one page each, per build-plan service_grouping) ----------------------------
$services = [
    ['name' => 'Privacy Fence', 'slug' => 'privacy-fence',
     'description' => 'Privacy fence installation for residential backyards and property lines in Ennis, Waxahachie and the surrounding area.',
     'keywords' => ['privacy fence', 'privacy fences', 'privacy fencing', 'backyard fencing']],
    ['name' => 'Cedar Fence', 'slug' => 'cedar-fence',
     'description' => 'Cedar wood fence installation for privacy, backyard and decorative fencing.',
     'keywords' => ['cedar fence', 'cedar fencing', 'wood fence installation']],
    ['name' => 'Chain Link', 'slug' => 'chain-link',
     'description' => 'Chain link fencing for yards, perimeters and security fencing.',
     'keywords' => ['chain link', 'chain link fencing', 'security fencing']],
    ['name' => 'Wrought Iron', 'slug' => 'wrought-iron',
     'description' => 'Wrought iron fencing for decorative, security and pool fence applications.',
     'keywords' => ['wrought iron', 'wrought iron fencing', 'decorative fencing', 'pool fence installation']],
    ['name' => 'Fence Repair', 'slug' => 'fence-repair',
     'description' => 'Repair of existing fences and gates.',
     'keywords' => ['fence repair', 'fence gates']],
    ['name' => 'Fence Installation', 'slug' => 'fence-installation',
     'description' => 'New fence and gate installation for residential and farm properties.',
     'keywords' => ['fence installation', 'fence contractor', 'gate installation', 'farm fencing', 'agricultural fencing']],
];

// ---- Service areas (Premium: /areas/{slug}/ per town) -----------------------------------------
$serviceAreas = ['Ennis, TX', 'Waxahachie, TX'];
$areaPages = [
    ['slug' => 'ennis',      'name' => 'Ennis',      'state' => 'TX'],
    ['slug' => 'waxahachie', 'name' => 'Waxahachie', 'state' => 'TX'],
];
$serviceRadiusMiles = 25;                              // build-plan seo.target_radius

// ---- Hours (build-plan business_hours: "Mon–Fri 7 AM–6 PM, closed Saturday and Sunday") -------
$hours = [
    ['day' => 'Monday',    'short' => 'Mon', 'opens' => '07:00', 'closes' => '18:00', 'label' => '7:00 AM – 6:00 PM'],
    ['day' => 'Tuesday',   'short' => 'Tue', 'opens' => '07:00', 'closes' => '18:00', 'label' => '7:00 AM – 6:00 PM'],
    ['day' => 'Wednesday', 'short' => 'Wed', 'opens' => '07:00', 'closes' => '18:00', 'label' => '7:00 AM – 6:00 PM'],
    ['day' => 'Thursday',  'short' => 'Thu', 'opens' => '07:00', 'closes' => '18:00', 'label' => '7:00 AM – 6:00 PM'],
    ['day' => 'Friday',    'short' => 'Fri', 'opens' => '07:00', 'closes' => '18:00', 'label' => '7:00 AM – 6:00 PM'],
    ['day' => 'Saturday',  'short' => 'Sat', 'opens' => null,    'closes' => null,    'label' => 'Closed'],
    ['day' => 'Sunday',    'short' => 'Sun', 'opens' => null,    'closes' => null,    'label' => 'Closed'],
];
// One-line form for the v8 components that expect a string
$businessHours = 'Mon–Fri 7:00 AM – 6:00 PM, Sat–Sun Closed';

// ---- Brand ------------------------------------------------------------------------------------
// build-plan design.colors holds no hex values and assets.logo is null; these match the tokens the scaffold wrote into
// framework.css (:root --color-primary/secondary/accent). Replace with logo-analysis values once a logo is supplied.
$colors = ['primary' => '#1f2428', 'secondary' => '#5a6570', 'accent' => '#c8461a'];
$yearsInBusinessAtBuild = 6;                           // build-plan content.years (as of 2026)
$yearEstablished = 2026 - $yearsInBusinessAtBuild;     // 2020 — derived, confirm at onboarding
$yearsInBusiness = (int) date('Y') - $yearEstablished;

// Short factual description for schema / AEO (build-plan content.description)
$businessDescription = 'D & D Fence is a fence contractor serving Ennis and Waxahachie, TX. Services include privacy fence, cedar fence, chain link, wrought iron, fence repair and fence installation.';

// ---- Google Business Profile ------------------------------------------------------------------
$gbp = [
    'place_id'      => 'ChIJJ-CVsN7rToYRxU3yHz0EahE',
    'share_url'     => 'https://share.google/YeJ2GN1LFZbrmb75W',                                       // build-plan google_business_profile_url
    'url'           => 'https://www.google.com/maps/place/?q=place_id:ChIJJ-CVsN7rToYRxU3yHz0EahE',     // schema hasMap
    'directions'    => 'https://www.google.com/maps/dir/?api=1&destination=place_id:ChIJJ-CVsN7rToYRxU3yHz0EahE',
    'review_url'    => 'https://search.google.com/local/writereview?placeid=ChIJJ-CVsN7rToYRxU3yHz0EahE',
    'embed_src'     => '',                             // integrations.gbp_map_embed is null — no map embed
    'reviews_count' => 0,                              // no GBP review data in the plan: no ratings, never AggregateRating
];
$geo = [];                                             // integrations.geo is null — omit GeoCoordinates

// ---- Social / analytics -----------------------------------------------------------------------
$socialLinks       = [];                               // none provided — footer renders icons only for platforms the client uses
$googleAnalyticsId = 'G-XXXXXXXXXX';                   // placeholder until the client's GA4 measurement ID is set

// ---- Forms ------------------------------------------------------------------------------------
$formAction      = 'https://db.pageone.cloud/functions/v1/leads/d-d-fence';   // build-plan form_action, verbatim
// HMAC secret for the spam-shield `_ft` field. Blank in the repo: the real value is injected by
// ~/crm/scripts/patch-leads-spamshield.py at promote time. p1-form-helpers.php skips the shield when empty.
$leadsFormSecret = '';

// ---- v8 components (written exactly as build-plan integrations holds them) ---------------------
$estimateTool   = [];   // integrations.estimate_tool.authorized is false
$bookingWindows = [];   // integrations.booking.authorized is false
$textUsNumber   = '';   // integrations.text_us_number is null (accepts_sms false) -> two-button sticky bar
$financing      = [];   // integrations.financing is null
$serviceZips    = [];   // integrations.service_zips not provided

$cssVersion = '1';      // the SINGLE framework.css cache-bust; bump here on every framework.css / critical.css change

// ---- Lead attribution (first-touch cookie + p1_attribution_fields()) — must stay last, before any output ----
require_once __DIR__ . '/attribution.php';
