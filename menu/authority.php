<?php //>

return [

    'authority' => ['icon' => 'fas fa-users-cog', 'ranking' => 100, 'parent' => null],

        'user' => ['icon' => 'fas fa-user', 'ranking' => 100, 'parent' => 'authority', 'group' => true, 'tag' => 'query'],

            'user/' => ['parent' => 'user', 'tag' => 'query'],

            'user/delete' => ['parent' => 'user', 'tag' => 'delete'],

            'user/insert' => ['parent' => 'user', 'tag' => 'insert'],

            'user/new' => ['parent' => 'user', 'tag' => 'insert'],

            'user/update' => ['parent' => 'user', 'tag' => 'update'],

            'user/substitute-member' => ['parent' => 'user', 'tag' => 'system'],

        'user-log' => ['icon' => 'far fa-list-alt', 'ranking' => 200, 'parent' => 'authority', 'group' => true, 'tag' => 'query'],

        'group' => ['icon' => 'fas fa-users', 'ranking' => 300, 'parent' => 'authority', 'group' => true, 'tag' => 'query'],

            'group/' => ['parent' => 'group', 'tag' => 'query'],

            'group/delete' => ['parent' => 'group', 'tag' => 'delete'],

            'group/insert' => ['parent' => 'group', 'tag' => 'insert'],

            'group/new' => ['parent' => 'group', 'tag' => 'insert'],

            'group/update' => ['parent' => 'group', 'tag' => 'update'],

];
