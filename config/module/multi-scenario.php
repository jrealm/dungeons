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
        'options' => 'spacing',
        'name' => 'innerSpacingY',
        'tab' => 'style',
        'type' => 'radio',
    ]],

    'sub-module' => 'scenario',

];
