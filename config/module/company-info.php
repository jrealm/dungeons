<?php //>

return [

    'fields' => [[
        'name' => 'title',
        'required' => true,
        'tab' => 'content',
        'type' => 'text',
    ], [
        'name' => 'content',
        'required' => true,
        'tab' => 'content',
        'type' => 'textarea',
    ],[
        'name' => 'mail',
        'required' => true,
        'tab' => 'content',
        'type' => 'email',
    ],[
        'name' => 'phone',
        'required' => true,
        'tab' => 'content',
        'type' => 'text',
    ],[
        'name' => 'map',
        'required' => true,
        'tab' => 'content',
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
        'tab' => 'color',
        'type' => 'color',
    ], [
        'name' => 'backgroundColor',
        'tab' => 'color',
        'type' => 'color',
    ]],

    'sub-module' => null,

];
