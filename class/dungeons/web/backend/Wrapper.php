<?php //>

namespace dungeons\web\backend;

use dungeons\Attachment;
use dungeons\db\column\File;

trait Wrapper {

    private function wrapModel($form) {
        foreach ($this->columns() ?? $this->table()->getColumns() as $name => $column) {
            if ($column instanceof File) {
                $form = Attachment::wrap($form, $name);
            } else if ($column->multiple()) {
                if (is_array(@$form[$name])) {
                    $form[$name] = implode(',', $form[$name]);
                }
            }
        }

        return $form;
    }

}
