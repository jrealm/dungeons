<?php //>

return [

    'fields' => [[
        'default' => true,
        'options' => 'yes-no',
        'name' => 'fliud',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'options' => 'spacing',
        'name' => 'paddingX',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'options' => 'spacing',
        'name' => 'paddingY',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'name' => 'backgroundColor',
        'tab' => 'style',
        'type' => 'color',
    ], [
        'default' => 5,
        'name' => 'interval',
        'tab' => 'style',
        'type' => 'integer',
    ]],

    'sub-module' => 'image',

];
