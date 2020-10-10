<?php //>

return [

    'system' => ['icon' => 'fas fa-desktop', 'ranking' => 200, 'parent' => null],

        'configuration' => ['icon' => 'fas fa-cogs', 'ranking' => 100, 'parent' => 'system'],

            'config/base' => ['icon' => 'fas fa-cog', 'ranking' => 100, 'parent' => 'configuration', 'group' => true, 'tag' => 'query'],

                'config/base/' => ['parent' => 'config/base', 'tag' => 'query'],

                'config/base/update' => ['parent' => 'config/base', 'tag' => 'update'],

        'multilingual' => ['icon' => 'fas fa-globe', 'ranking' => 200, 'parent' => 'system'],

            'message/base' => ['icon' => 'fas fa-language', 'ranking' => 100, 'parent' => 'multilingual', 'group' => true, 'tag' => 'query'],

                'message/base/' => ['parent' => 'message/base', 'tag' => 'query'],

                'message/base/update' => ['parent' => 'message/base', 'tag' => 'update'],

            'message/menu' => ['icon' => 'fas fa-bars', 'ranking' => 200, 'parent' => 'multilingual', 'group' => true, 'tag' => 'system'],

                'message/menu/' => ['parent' => 'message/menu', 'tag' => 'system'],

                'message/menu/update' => ['parent' => 'message/menu', 'tag' => 'system'],

            'message/options' => ['icon' => 'fas fa-check', 'ranking' => 300, 'parent' => 'multilingual', 'group' => true, 'tag' => 'system'],

                'message/options/' => ['parent' => 'message/options', 'tag' => 'system'],

                'message/options/update' => ['parent' => 'message/options', 'tag' => 'system'],

            'message/table' => ['icon' => 'fas fa-table', 'ranking' => 400, 'parent' => 'multilingual', 'group' => true, 'tag' => 'system'],

                'message/table/' => ['parent' => 'message/table', 'tag' => 'system'],

                'message/table/update' => ['parent' => 'message/table', 'tag' => 'system'],

            'message/template' => ['icon' => 'far fa-comment-dots', 'ranking' => 500, 'parent' => 'multilingual', 'group' => true, 'tag' => 'query'],

                'message/template/' => ['parent' => 'message/template', 'tag' => 'query'],

                'message/template/update' => ['parent' => 'message/template', 'tag' => 'update'],

            'text' => ['parent' => 'multilingual', 'group' => true, 'tag' => 'update'],

                'text/update' => ['parent' => 'text', 'tag' => 'update'],

        'sms-log' => ['icon' => 'fas fa-sms', 'ranking' => 300, 'parent' => 'system', 'group' => true, 'tag' => 'query'],

];
