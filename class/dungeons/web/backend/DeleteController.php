<?php //>

namespace dungeons\web\backend;

use dungeons\web\BackendController;

class DeleteController extends BackendController {

    public function __construct($tableName = null) {
        parent::__construct();

        if ($tableName) {
            $this->table(table($tableName));
        }

        $this->confirm('backend/confirm-delete.twig');
        $this->view('backend/delete-success.php');
    }

    public function available() {
        if ($this->method() === 'POST') {
            $pattern = preg_quote($this->name(), '/');

            return preg_match("/^{$pattern}(\/[\/\w-]+)?$/", $this->path());
        }

        return false;
    }

    protected function process($form) {
        $args = $this->args();

        if (!$args) {
            $args = @$form['args'];

            if (!$args || !is_array($args)) {
                return ['error' => 'error.DataNotFound'];
            }
        }

        if (empty($form['confirm'])) {
            return [
                'args' => $args,
                'view' => $this->confirm(),
            ];
        }

        $list = [];

        foreach ($args as $id) {
            $data = $this->delete($this->table(), $id);

            if (is_null($data)) {
                break;
            }

            if ($data === false) {
                return ['error' => 'error.DeleteFailed'];
            }

            $list[] = $data;
        }

        if (!$list) {
            return ['error' => 'error.DataNotFound'];
        }

        return ['success' => true, 'list' => $list];
    }

    private function delete($table, $data) {
        $data = $table->model()->delete($data);

        if ($data) {
            foreach ($table->getRelations() as $relation) {
                if ($relation['type'] === 'composition') {
                    if (empty($relation['enable'])) {
                        $foreign = table($relation['foreign']);
                        $target = $foreign->{$relation['target']}->mapping();
                    } else {
                        $foreign = $relation['foreign'];
                        $target = $relation['target']->mapping();
                    }

                    $column = $relation['column']->mapping();

                    foreach ($foreign->model()->query(["{$target}" => $data[$column]]) as $child) {
                        $child = $this->delete($foreign, $child);

                        if (!$child) {
                            return $child;
                        }
                    }
                }
            }
        }

        return $data;
    }

}
