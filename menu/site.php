<?php //>

return [

    'site' => ['icon' => 'fas fa-sitemap', 'ranking' => 500, 'parent' => null],

        'page' => ['icon' => 'far fa-newspaper', 'ranking' => 100, 'parent' => 'site', 'group' => true, 'tag' => 'query'],

            'page/' => ['parent' => 'page', 'tag' => 'query'],

            'page/delete' => ['parent' => 'page', 'tag' => 'delete'],

            'page/insert' => ['parent' => 'page', 'tag' => 'insert'],

            'page/new' => ['parent' => 'page', 'tag' => 'insert'],

            'page/update' => ['parent' => 'page', 'tag' => 'update'],

            'page/block' => ['parent' => 'page', 'pattern' => 'page/{{ id }}/block', 'group' => true, 'tag' => 'query'],

                'page/block/' => ['parent' => 'page/block', 'tag' => 'query'],

                'page/block/delete' => ['parent' => 'page/block', 'tag' => 'delete'],

                'page/block/insert' => ['parent' => 'page/block', 'tag' => 'insert'],

                'page/block/new' => ['parent' => 'page/block', 'tag' => 'insert'],

                'page/block/update' => ['parent' => 'page/block', 'tag' => 'update'],

                'page/block/item' => ['parent' => 'page/block', 'pattern' => 'page/block/{{ id }}/item', 'group' => true, 'tag' => 'query'],

                    'page/block/item/' => ['parent' => 'page/block/item', 'tag' => 'query'],

                    'page/block/item/delete' => ['parent' => 'page/block/item', 'tag' => 'delete'],

                    'page/block/item/insert' => ['parent' => 'page/block/item', 'tag' => 'insert'],

                    'page/block/item/new' => ['parent' => 'page/block/item', 'tag' => 'insert'],

                    'page/block/item/update' => ['parent' => 'page/block/item', 'tag' => 'update'],
];
