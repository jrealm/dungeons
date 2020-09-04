<?php //>

return [

    'fields' => [[
        'name' => 'title',
        'type' => 'text',
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
        'default' => 1,
        'options' => 'header-size',
        'name' => 'size',
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
    ], [
        'options' => 'column-count',
        'name' => 'column',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'options' => 'spacing',
        'name' => 'innerPaddingY',
        'tab' => 'style',
        'type' => 'radio',
    ]],

    'sub-module' => 'intro',

];
