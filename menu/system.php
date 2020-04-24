<?php //>

return [

    'system' => ['icon' => 'fas fa-desktop', 'ranking' => 100, 'parent' => null],

        'configuration' => ['icon' => 'fas fa-cogs', 'ranking' => 100, 'parent' => 'system'],

            'config/base' => ['icon' => 'fas fa-cog', 'ranking' => 100, 'parent' => 'configuration', 'group' => true, 'tag' => 'query'],

                'config/base/' => ['parent' => 'config/base', 'tag' => 'query'],

                'config/base/update' => ['parent' => 'config/base', 'tag' => 'update'],

        'multilingual' => ['icon' => 'fas fa-globe', 'ranking' => 200, 'parent' => 'system'],

            'message/base' => ['icon' => 'fas fa-language', 'ranking' => 100, 'parent' => 'multilingual', 'group' => true, 'tag' => 'query'],

                'message/base/' => ['parent' => 'message/base', 'tag' => 'query'],

                'message/base/update' => ['parent' => 'message/base', 'tag' => 'update'],

            'message/menu' => ['icon' => 'fas fa-bars', 'ranking' => 200, 'parent' => 'multilingual', 'group' => true, 'tag' => 'query'],

                'message/menu/' => ['parent' => 'message/menu', 'tag' => 'query'],

                'message/menu/update' => ['parent' => 'message/menu', 'tag' => 'update'],

            'message/options' => ['icon' => 'fas fa-check', 'ranking' => 300, 'parent' => 'multilingual', 'group' => true, 'tag' => 'query'],

                'message/options/' => ['parent' => 'message/options', 'tag' => 'query'],

                'message/options/update' => ['parent' => 'message/options', 'tag' => 'update'],

            'message/table' => ['icon' => 'fas fa-table', 'ranking' => 400, 'parent' => 'multilingual', 'group' => true, 'tag' => 'query'],

                'message/table/' => ['parent' => 'message/table', 'tag' => 'query'],

                'message/table/update' => ['parent' => 'message/table', 'tag' => 'update'],

];
