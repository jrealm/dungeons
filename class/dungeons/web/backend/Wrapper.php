<?php //>

namespace dungeons\web\backend;

use dungeons\Attachment;
use dungeons\db\column\File;

trait Wrapper {

    protected function wrap() {
        $form = parent::wrap();

        foreach ($this->columns() ?? $this->table()->getColumns() as $name => $column) {
            if ($column instanceof File) {
                $form = Attachment::wrap($form, $name);
            }
        }

        return $form;
    }

}
