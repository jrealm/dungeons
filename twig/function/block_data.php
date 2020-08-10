<?php //>

use dungeons\Message;

return new Twig\TwigFunction('block_data', function ($arg) {
    if (is_array($arg)) {
        $page = $arg;
    } else {
        $page = model('Page')->find(['path' => $arg]);

        if (!$page) {
            $page = ['id' => $arg];
        }
    }

    $blocks = [];

    foreach (model('Block')->query(['page_id' => $page['id']]) as $block) {
        $extra = json_decode($block['extra'], true);

        if ($extra) {
            $block = array_merge($block, $extra);
        }

        $block['items'] = [];
        $block['label'] = Message::load("module/{$block['module']}");

        $blocks[$block['id']] = $block;
    }

    foreach (model('BlockItem')->query(['block_id' => array_keys($blocks)]) as $item) {
        $extra = json_decode($item['extra'], true);

        if ($extra) {
            $item = array_merge($item, $extra);
        }

        $blocks[$item['block_id']]['items'][] = $item;
    }

    $page['blocks'] = $blocks;

    return $page;
});
