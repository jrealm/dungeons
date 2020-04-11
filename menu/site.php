<?php //>

return [

    'site' => ['icon' => 'fas fa-sitemap', 'ranking' => 500, 'parent' => null],

        'page' => ['icon' => 'far fa-newspaper', 'ranking' => 100, 'parent' => 'site'],

            'page/' => ['parent' => 'page'],

            'page/delete' => ['parent' => 'page'],

            'page/insert' => ['parent' => 'page'],

            'page/new' => ['parent' => 'page'],

            'page/update' => ['parent' => 'page'],

            'page/blocks' => ['parent' => 'page', 'pattern' => 'page/{{ id }}/blocks'],

                'page/blocks/' => ['parent' => 'page/blocks'],

                'page/blocks/delete' => ['parent' => 'page/blocks'],

                'page/blocks/insert' => ['parent' => 'page/blocks'],

                'page/blocks/new' => ['parent' => 'page/blocks'],

                'page/blocks/update' => ['parent' => 'page/blocks'],

];
