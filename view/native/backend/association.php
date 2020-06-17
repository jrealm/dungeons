<?php //>

$bundles = [];
$relations = [];

foreach ($controller->table()->getRelations() as $relation) {
    if ($relation['type'] === 'association' && !$relation['column']->invisible() && !$relation['column']->lazy()) {
        if (empty($relation['enable'])) {
            $foreign = table($relation['foreign']);
            $target = $foreign->{$relation['target']};
        } else {
            $foreign = $relation['foreign'];
            $target = $relation['target'];
        }

        $bundle = [];
        $model = $foreign->model();
        $name = $target->name();

        foreach ($model->query($relation['filter']) as $data) {
            $bundle[$data[$name]] = $model->toString($data);
        }

        $bundles[$relation['column']->name()] = $bundle;
        $relations[$relation['column']->name()] = $relation;
    }
}
