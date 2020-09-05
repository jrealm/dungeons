<?php //>

return [

    'fields' => [[
        'name' => 'image',
        'required' => true,
        'type' => 'image',
    ], [
        'name' => 'content',
        'required' => true,
        'type' => 'html',
    ],[
        'default' => true,
        'options' => 'yes-no',
        'name' => 'fliud',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'options' => 'spacing',
        'name' => 'iPadding',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'name' => 'iBgColor',
        'tab' => 'color',
        'type' => 'color',
    ], [
        'options' => 'spacing',
        'name' => 'aPadding',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'name' => 'aBgColor',
        'tab' => 'color',
        'type' => 'color',
    ], [
        'default' => 1,
        'options' => 'content-position',
        'name' => 'position',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'default' => 1,
        'options' => 'content-weight',
        'name' => 'weight',
        'tab' => 'style',
        'type' => 'radio',
    ]],

    'sub-module' => null,

];
