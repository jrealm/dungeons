<?php //>

$block = table('Block');
$options = [];

foreach ($block->model()->query([$block->module->notEqual('reference')]) as $item) {
    $options[$item['id']] = $item['name'];
}

return [

    'fields' => [[
        'name' => 'target',
        'options' => $options,
        'required' => true,
        'type' => 'select',
    ]],

    'sub-module' => null,

];
