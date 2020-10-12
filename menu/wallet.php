<?php //>

return [

    'wallet-management' => ['icon' => 'fas fa-wallet', 'ranking' => 700, 'parent' => null],

        'wallet' => ['icon' => 'fas fa-wallet', 'ranking' => 100, 'parent' => 'wallet-management', 'group' => true, 'tag' => 'query'],

            'wallet/log' => ['parent' => 'wallet', 'pattern' => 'wallet/{{ id }}/log', 'group' => true, 'tag' => 'query'],

                'wallet/log/' => ['parent' => 'wallet/log', 'tag' => 'query'],

                'wallet/log/insert' => ['parent' => 'wallet/log', 'tag' => 'insert'],

                'wallet/log/new' => ['parent' => 'wallet/log', 'tag' => 'insert'],

];
