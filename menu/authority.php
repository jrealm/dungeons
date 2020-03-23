<?php //>

return [

    'authority' => ['icon' => 'fas fa-users-cog', 'ranking' => 100, 'parent' => null],

        'user' => ['icon' => 'fas fa-user', 'ranking' => 100, 'parent' => 'authority'],

            'user/' => ['parent' => 'user'],

            'user/delete' => ['parent' => 'user'],

            'user/insert' => ['parent' => 'user'],

            'user/new' => ['parent' => 'user'],

            'user/update' => ['parent' => 'user'],

        'group' => ['icon' => 'fas fa-users', 'ranking' => 200, 'parent' => 'authority'],

            'group/' => ['parent' => 'group'],

            'group/delete' => ['parent' => 'group'],

            'group/insert' => ['parent' => 'group'],

            'group/new' => ['parent' => 'group'],

            'group/update' => ['parent' => 'group'],

];
