<?php //>

return [

    'fields' => [[
        'name' => 'image',
        'required' => true,
        'type' => 'image',
    ], [
        'name' => 'content',
        'type' => 'html',
    ], [
        'default' => 'start',
        'options' => 'justify-content',
        'name' => 'justifyContent',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'default' => 'start',
        'options' => 'align-items',
        'name' => 'alignItems',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'name' => 'color',
        'tab' => 'color',
        'type' => 'color',
    ]],

];
