<?php //>

return [

    'fields' => [[
        'name' => 'image',
        'type' => 'image',
    ], [
        'name' => 'title',
        'type' => 'text',
    ], [
        'name' => 'content',
        'type' => 'html',
    ], [
        'multilingual' => true,
        'name' => 'button',
        'type' => 'text',
    ], [
        'name' => 'url',
        'type' => 'url',
    ], [
        'default' => '50',
        'options' => 'image-width',
        'name' => 'imageWidth',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'name' => 'borderColor',
        'tab' => 'style',
        'type' => 'color',
    ], [
        'default' => 0,
        'options' => 'border-size',
        'name' => 'borderSize',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'default' => false,
        'options' => 'yes-no',
        'name' => 'rounded',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'default' => false,
        'options' => 'yes-no',
        'name' => 'shadow',
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
    ], [
        'name' => 'buttonColor',
        'tab' => 'style',
        'type' => 'color',
    ], [
        'name' => 'buttonBgColor',
        'tab' => 'style',
        'type' => 'color',
    ]],

];
