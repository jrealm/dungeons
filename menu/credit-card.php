<?php //>

return [

    'credit-card-management' => ['icon' => 'far fa-credit-card', 'ranking' => 800, 'parent' => null],

        'mastercard' => ['icon' => 'fab fa-cc-mastercard', 'ranking' => 200, 'parent' => 'credit-card-management', 'group' => true, 'tag' => 'query'],

        'mastercard/' => ['parent' => 'mastercard', 'tag' => 'query'],

];
