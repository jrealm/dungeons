<?php //>

namespace dungeons\web\backend;

use dungeons\Attachment;
use dungeons\db\column\File;

trait Wrapper {

    private function wrapInput($column, $form, $name, $language) {
        if ($language) {
            $name = "{$name}__{$language}";
        }

        if ($column instanceof File) {
            $form = Attachment::wrap($form, $name);
        } else if ($column->multiple()) {
            if (is_array(@$form[$name])) {
                $form[$name] = implode(',', $form[$name]);
            }
        }

        return $form;
    }

    private function wrapModel($form) {
        foreach ($this->columns() ?? $this->table()->getColumns() as $name => $column) {
            if ($column->multilingual()) {
                foreach (LANGUAGES as $language) {
                    $form = $this->wrapInput($column, $form, $name, $language);
                }
            } else {
                $form = $this->wrapInput($column, $form, $name, null);
            }
        }

        return $form;
    }

}
