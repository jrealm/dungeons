<?php //>

return [

    'fields' => [[
        'name' => 'video',
        'required' => true,
        'tab' => 'content',
        'type' => 'text',
    ], [
        'default' => true,
        'options' => 'yes-no',
        'name' => 'autoplay',
        'tab' => 'content',
        'type' => 'radio',
    ], [
        'default' => 1,
        'options' => 'visible',
        'name' => 'controls',
        'tab' => 'content',
        'type' => 'radio',
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
        'default' => '16by9',
        'options' => 'embed-ratio',
        'name' => 'ratio',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'name' => 'backgroundColor',
        'tab' => 'color',
        'type' => 'color',
    ]],

    'sub-module' => null,

];
