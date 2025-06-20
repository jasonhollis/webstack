<?php
require_once __DIR__ . '/layout.php';

$page_title = 'Integration Grid Test – KTP Webstack';

// Load integrations
$json_file    = __DIR__ . '/data/ha_integrations.json';
$icon_dir     = __DIR__ . '/images/icons';
$fallback_icon = '/images/icons/home-assistant.svg';
$integrations = [];
if ( file_exists( $json_file ) ) {
    $integrations = json_decode( file_get_contents( $json_file ), true );
}
$integration_count = count( $integrations );

// Build page description (also used for meta description)
$page_desc = "Live data from ha_integrations.json ({$integration_count} integrations)";

ob_start();
?>
    <h1 class="text-4xl font-bold text-center">Integration Grid Test</h1>
    <p class="mt-2 text-center text-gray-600"><?= htmlspecialchars( $page_desc ) ?></p>

    <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 max-w-6xl mx-auto">
    <?php foreach ( $integrations as $item ) :
        $domain   = $item['domain'];
        $name     = $item['name'];
        $docs_url = $item['url'];

        // pick the correct icon file or fallback
        $svg_path = "{$icon_dir}/{$domain}.svg";
        $png_path = "{$icon_dir}/{$domain}.png";
        if ( file_exists( $svg_path ) ) {
            $icon_url = "/images/icons/{$domain}.svg";
        } elseif ( file_exists( $png_path ) ) {
            $icon_url = "/images/icons/{$domain}.png";
        } else {
            $icon_url = $fallback_icon;
            error_log( "Missing icon for domain: {$domain}" );
        }
    ?>
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-6 flex flex-col items-center">
            <img
                src="<?= htmlspecialchars( $icon_url ) ?>"
                alt="<?= htmlspecialchars( $name ) ?> logo"
                class="h-20 w-20 object-contain mb-4"
                onerror="this.src='<?= htmlspecialchars( $fallback_icon ) ?>'"
            />
            <span class="text-center text-base font-medium text-gray-900"><?= htmlspecialchars( $name ) ?></span>
            <a
                href="<?= htmlspecialchars( $docs_url ) ?>"
                target="_blank"
                class="mt-2 text-xs text-blue-600 underline"
            >HA Docs</a>
        </div>
    <?php endforeach; ?>
    </div>
<?php
$content = ob_get_clean();

// Render the full page
echo renderLayout(
    $page_title,
    $content,
    /* $meta = */ '',
    /* $page_desc = */ $page_desc,
    /* $canonical = */ '',
    /* $og_image = */ ''
);
