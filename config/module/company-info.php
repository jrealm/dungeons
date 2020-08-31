<?php //>

return [

    'fields' => [[
        'name' => 'title',
        'required' => true,
        'type' => 'text',
    ], [
        'name' => 'content',
        'required' => true,
        'type' => 'textarea',
    ],[
        'name' => 'mail',
        'required' => true,
        'type' => 'email',
    ],[
        'name' => 'phone',
        'required' => true,
        'type' => 'text',
    ],[
        'name' => 'map',
        'required' => true,
        'type' => 'textarea',
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
        'name' => 'color',
        'tab' => 'style',
        'type' => 'color',
    ], [
        'name' => 'backgroundColor',
        'tab' => 'style',
        'type' => 'color',
    ]],

    'sub-module' => null,

];
