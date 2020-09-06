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
        'type' => 'text',
    ], [
        'default' => 50,
        'options' => 'image-width',
        'name' => 'imageWidth',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'name' => 'borderColor',
        'tab' => 'color',
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
        'tab' => 'color',
        'type' => 'color',
    ], [
        'name' => 'backgroundColor',
        'tab' => 'color',
        'type' => 'color',
    ], [
        'name' => 'buttonColor',
        'tab' => 'color',
        'type' => 'color',
    ], [
        'name' => 'buttonBgColor',
        'tab' => 'color',
        'type' => 'color',
    ]],

];
