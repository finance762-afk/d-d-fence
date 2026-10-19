<?php
/**
 * includes/blog-data.php — single source of truth for all blog post metadata (D & D Fence, Phase 6, 2026-10-19).
 * Newest post FIRST. Every consumer reads this array through blogLoad(): the blog index, the homepage "From the Blog"
 * section, the Related Articles blocks and sitemap.php. Never hardcode post lists elsewhere.
 *
 * Adding a post = one entry here + one /blog/{slug}/index.php directory.
 *
 * IMAGES: no client photos or blog images exist under /assets/images/ yet (only favicons), and the prompt forbids pointing at a file that is
 * not on disk, so 'image' and 'alt' are empty. blogCard() and the post template then render the decorative fence-board art panel instead of an
 * <img>. When photos arrive, set 'image' to the -960.webp variant and write a descriptive
 * 'alt'; the card, the featured block and BlogPosting.image switch to the photo automatically once the file exists.
 */
$blogPosts = [
    [
        'slug'     => 'what-drives-fence-cost-ellis-county',
        'title'    => 'What Drives the Cost of a Fence in Ellis County?',   // ≤ 60 chars, no brand suffix
        'excerpt'  => 'Fence prices come down to length, height, material, gates, ground and old-fence removal. Here is how each one moves an Ennis or Waxahachie quote.',
        'image'    => '',
        'alt'      => '',
        'date'     => 'October 19, 2026',
        'dateISO'  => '2026-10-19',
        'category' => 'Fence Costs',
        'readtime' => '6 min read',
    ],
    [
        'slug'     => 'why-fence-posts-lean-ellis-county-clay',
        'title'    => 'Why Fence Posts Lean in Ellis County Clay',
        'excerpt'  => 'Blackland Prairie clay swells and cracks with the weather. Here is why that tips fence posts, what to check after dry spells and storms, and when a repair beats a rebuild.',
        'image'    => '',
        'alt'      => '',
        'date'     => 'October 19, 2026',
        'dateISO'  => '2026-10-19',
        'category' => 'Fence Care',
        'readtime' => '6 min read',
    ],
];
