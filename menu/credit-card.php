<?php //>

return [

    'credit-card-management' => ['icon' => 'far fa-credit-card', 'ranking' => 800, 'parent' => null],

        'mastercard' => ['icon' => 'fab fa-cc-mastercard', 'ranking' => 200, 'parent' => 'credit-card-management', 'group' => true, 'tag' => 'query'],

        'mastercard/' => ['parent' => 'mastercard', 'tag' => 'query'],

        'member-passport-auth' => ['icon' => 'fas fa-passport', 'ranking' => 400, 'parent' => 'credit-card-management', 'group' => true, 'tag' => 'query'],

            'member-passport-auth/' => ['parent' => 'member-passport-auth', 'tag' => 'query'],

            'member-passport-auth/update' => ['parent' => 'member-passport-auth', 'tag' => 'update'],

];
