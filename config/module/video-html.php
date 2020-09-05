<?php //>

return [

    'fields' => [[
        'default' => 'youtube',
        'options' => 'video-platform',
        'name' => 'platform',
        'type' => 'radio',
    ], [
        'name' => 'video',
        'required' => true,
        'type' => 'text',
    ], [
        'default' => true,
        'options' => 'yes-no',
        'name' => 'autoplay',
        'type' => 'radio',
    ], [
        'default' => 1,
        'options' => 'visible',
        'name' => 'controls',
        'type' => 'radio',
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
        'default' => '16by9',
        'options' => 'embed-ratio',
        'name' => 'ratio',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'options' => 'spacing',
        'name' => 'vPadding',
        'tab' => 'style',
        'type' => 'radio',
    ], [
        'name' => 'vBgColor',
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
