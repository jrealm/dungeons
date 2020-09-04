<?php //>

return [

    'fields' => [[
        'default' => 5,
        'name' => 'interval',
        'type' => 'integer',
    ], [
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
        'tab' => 'color',
        'type' => 'color',
    ]],

    'sub-module' => 'image',

];
