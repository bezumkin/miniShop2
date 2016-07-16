<?php

$chunks = array();

$tmp = array(
    'msProduct.content' => 'ms_product_content',
    'tpl.msProducts.row' => 'ms_products_row',

    'tpl.msCart' => 'ms_cart',
    'tpl.msMiniCart' => 'ms_minicart',
    'tpl.msOrder' => 'ms_order',
    'tpl.msGetOrder' => 'ms_get_order',
    'tpl.msOptions' => 'ms_options',
    'tpl.msProductOptions' => 'ms_product_options',
    'tpl.msGallery' => 'ms_gallery',

    'tpl.msEmail' => 'ms_email',
    'tpl.msEmail.new.user' => 'ms_email_new_user',
    'tpl.msEmail.new.manager' => 'ms_email_new_manager',
    'tpl.msEmail.paid.user' => 'ms_email_paid_user',
    'tpl.msEmail.paid.manager' => 'ms_email_paid_manager',
    'tpl.msEmail.sent.user' => 'ms_email_sent_user',
    'tpl.msEmail.cancelled.user' => 'ms_email_cancelled_user',
);

// Save chunks for setup options
$BUILD_CHUNKS = array();

foreach ($tmp as $k => $v) {
    /** @var modChunk $chunk */
    $chunk = $modx->newObject('modChunk');
    $chunk->fromArray(array(
        'id' => 0,
        'name' => $k,
        'description' => '',
        'snippet' => file_get_contents($sources['source_core'] . '/elements/chunks/chunk.' . $v . '.tpl'),
        'static' => BUILD_CHUNK_STATIC,
        'source' => 1,
        'static_file' => 'core/components/' . PKG_NAME_LOWER . '/elements/chunks/chunk.' . $v . '.tpl',
    ), '', true, true);
    $chunks[] = $chunk;

    $BUILD_CHUNKS[$k] = file_get_contents($sources['source_core'] . '/elements/chunks/chunk.' . $v . '.tpl');
}
ksort($BUILD_CHUNKS);

return $chunks;