<?php //>

return [

    'fields' => [[
        'name' => 'image',
        'required' => true,
        'type' => 'image',
    ], [
        'options' => 'yes-no',
        'name' => 'fliud',
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
    ]],

    'sub-module' => null,

];
