<?php //>

return [

    'currency' => ['icon' => 'nav-icon fas fa-coins', 'ranking' => 1000, 'parent' => 'system', 'group' => true, 'tag' => 'query'],

    'currency/' => ['parent' => 'currency', 'tag' => 'query'],

    'currency/update' => ['parent' => 'currency', 'tag' => 'update'],

    'currency/rate' => ['parent' => 'currency', 'pattern' => 'currency/{{ id }}/rate', 'group' => true, 'tag' => 'query'],

    'currency/rate/' => ['parent' => 'currency/rate', 'tag' => 'query'],

    'currency/rate/insert' => ['parent' => 'currency/rate', 'tag' => 'insert'],

    'currency/rate/new' => ['parent' => 'currency/rate', 'tag' => 'insert'],

    'currency/rate/update' => ['parent' => 'currency/rate', 'tag' => 'update'],

];
