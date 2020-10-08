<?php //>

return [

    'country' => ['icon' => 'far fa-flag', 'ranking' => 2000, 'parent' => 'system', 'group' => true, 'tag' => 'query'],

    'country/' => ['parent' => 'country', 'tag' => 'query'],

    'country/insert' => ['parent' => 'country', 'tag' => 'insert'],

    'country/new' => ['parent' => 'country', 'tag' => 'insert'],

    'country/update' => ['parent' => 'country', 'tag' => 'update'],

];
