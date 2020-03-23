<?php //>

$breadcrumb = [];
$visible = null;

while ($node) {
    if (!$visible) {
        $node['path'] = $path;
        $result['menu'] = $path;
        $visible = @$node['ranking'];
    }

    $breadcrumb[] = $node;

    $path = $node['parent'];
    $node = $path ? $menus[$path] : null;
}

$result['breadcrumb'] = array_reverse($breadcrumb);
