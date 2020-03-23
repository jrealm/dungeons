<?php //>

return [

    'system' => ['icon' => 'fas fa-desktop', 'ranking' => 100, 'parent' => null],

        'configuration' => ['icon' => 'fas fa-cogs', 'ranking' => 100, 'parent' => 'system'],

            'config/base' => ['icon' => 'fas fa-cog', 'ranking' => 100, 'parent' => 'configuration'],

                'config/base/' => ['parent' => 'config/base'],

                'config/base/update' => ['parent' => 'config/base'],

            'config/column' => ['icon' => 'far fa-file-alt', 'ranking' => 200, 'parent' => 'configuration'],

                'config/column/' => ['parent' => 'config/column'],

                'config/column/update' => ['parent' => 'config/column'],

        'multilingual' => ['icon' => 'fas fa-globe', 'ranking' => 200, 'parent' => 'system'],

            'message/base' => ['icon' => 'fas fa-language', 'ranking' => 100, 'parent' => 'multilingual'],

                'message/base/' => ['parent' => 'message/base'],

                'message/base/update' => ['parent' => 'message/base'],

            'message/menu' => ['icon' => 'fas fa-bars', 'ranking' => 200, 'parent' => 'multilingual'],

                'message/menu/' => ['parent' => 'message/menu'],

                'message/menu/update' => ['parent' => 'message/menu'],

            'message/options' => ['icon' => 'fas fa-check', 'ranking' => 300, 'parent' => 'multilingual'],

                'message/options/' => ['parent' => 'message/options'],

                'message/options/update' => ['parent' => 'message/options'],

            'message/table' => ['icon' => 'fas fa-table', 'ranking' => 400, 'parent' => 'multilingual'],

                'message/table/' => ['parent' => 'message/table'],

                'message/table/update' => ['parent' => 'message/table'],

];
