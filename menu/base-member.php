<?php //>

return [

    'member-management' => ['icon' => 'fas fa-user-friends', 'ranking' => 600, 'parent' => null],

        'member' => ['icon' => 'fas fa-user', 'ranking' => 100, 'parent' => 'member-management', 'group' => true, 'tag' => 'query'],

            'member/' => ['parent' => 'member', 'tag' => 'query'],

            'member/update' => ['parent' => 'member', 'tag' => 'update'],

            'member/substitute' => ['parent' => 'member', 'tag' => 'system'],

        'member-log' => ['icon' => 'far fa-list-alt', 'ranking' => 200, 'parent' => 'member-management', 'group' => true, 'tag' => 'query'],

];
