<?php //>

return [

    'site' => ['icon' => 'fas fa-sitemap', 'ranking' => 500, 'parent' => null],

        'page' => ['icon' => 'far fa-newspaper', 'ranking' => 100, 'parent' => 'site'],

            'page/' => ['parent' => 'page'],

            'page/delete' => ['parent' => 'page'],

            'page/insert' => ['parent' => 'page'],

            'page/new' => ['parent' => 'page'],

            'page/update' => ['parent' => 'page'],

            'page/block' => ['parent' => 'page', 'pattern' => 'page/{{ id }}/block'],

                'page/block/' => ['parent' => 'page/block'],

                'page/block/delete' => ['parent' => 'page/block'],

                'page/block/insert' => ['parent' => 'page/block'],

                'page/block/new' => ['parent' => 'page/block'],

                'page/block/update' => ['parent' => 'page/block'],

                'page/block/item' => ['parent' => 'page/block', 'pattern' => 'page/block/{{ id }}/item'],

                    'page/block/item/' => ['parent' => 'page/block/item'],

                    'page/block/item/delete' => ['parent' => 'page/block/item'],

                    'page/block/item/insert' => ['parent' => 'page/block/item'],

                    'page/block/item/new' => ['parent' => 'page/block/item'],

                    'page/block/item/update' => ['parent' => 'page/block/item'],
];
