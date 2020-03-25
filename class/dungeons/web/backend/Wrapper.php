<?php //>

namespace dungeons\web\backend;

use dungeons\FileInfo;
use dungeons\db\column\File;

trait Wrapper {

    protected function wrap() {
        $form = parent::wrap();

        foreach ($this->columns() ?? $this->table()->getColumns() as $name => $column) {
            if ($column instanceof File && defined('APP_FILES')) {
                $value = @$form[$name];

                if (is_string($value) && preg_match('/^data:/', $value)) {
                    $folder = create_folder(APP_FILES . date('Ymd/'));

                    if ($folder) {
                        $file = tempnam($folder, '');
                        $value = substr($value, strpos($value, ','));

                        if (file_put_contents($file, base64_decode($value)) !== false) {
                            $form[$name] = FileInfo::from($file, @$form["{$name}#filename"], substr($file, strlen(APP_FILES)));
                        }
                    }
                }
            }
        }

        return $form;
    }

}
