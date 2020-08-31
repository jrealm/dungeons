<?php //>

use dungeons\Config;
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
            $module = Config::load("module/{$block['module']}");

            foreach ($module['fields'] as $field) {
                if (@$field['multilingual']) {
                    $extra[$field['name']] = @$extra[$field['name'] . '__' . LANGUAGE];
                }
            }

            $block = array_merge($block, $extra);
        }

        $block['items'] = [];
        $block['label'] = Message::load("module/{$block['module']}");

        $blocks[$block['id']] = $block;
    }

    foreach (model('BlockItem')->query(['block_id' => array_keys($blocks)]) as $item) {
        $block = &$blocks[$item['block_id']];
        $extra = json_decode($item['extra'], true);

        if ($extra) {
            $module = Config::load("module/{$block['module']}");
            $sub = Config::load("sub-module/{$module['sub-module']}");

            foreach ($sub['fields'] as $field) {
                if (@$field['multilingual']) {
                    $extra[$field['name']] = @$extra[$field['name'] . '__' . LANGUAGE];
                }
            }

            $item = array_merge($item, $extra);
        }

        $block['items'][] = $item;
    }

    $page['blocks'] = $blocks;

    return $page;
});
