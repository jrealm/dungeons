<?php //>

return [

    'fields' => [[
        'name' => 'content',
        'required' => true,
        'type' => 'html',
    ], [
        'options' => 'yes-no',
        'name' => 'fliud',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'options' => 'padding',
        'name' => 'paddingX',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'options' => 'padding',
        'name' => 'paddingY',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'name' => 'backgroundColor',
        'tab' => 'style',
        'type' => 'color',
    ]],

    'sub-module' => null,

];
