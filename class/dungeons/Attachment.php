<?php //>

namespace dungeons;

class Attachment {

    public static function validate($file, $mime_type) {
        if ($mime_type === null) {
            return true;
        }

        if ($file instanceof self) {
            if (preg_match("/^{$mime_type}$/", $file->info['mime_type'])) {
                return true;
            } else {
                unlink($file->info['file']);
            }
        } else {
            $info = model('File')->find(['path' => $file]);

            if ($info && preg_match("/^{$mime_type}$/", $info['mime_type'])) {
                return true;
            }
        }

        return false;
    }

    public static function wrap($form, ...$names) {
        foreach ($names as $name) {
            $file = self::toFile(@$form[$name]);

            if ($file) {
                $form[$name] = new self(@$form["{$name}#filename"], $file);
            }
        }

        return $form;
    }

    private static function getFolder() {
        if (defined('FILES_HOME')) {
            return create_folder(FILES_HOME . date('Ymd/'));
        }

        if (defined('APP_HOME')) {
            return create_folder(APP_HOME . 'www/files/' . date('Ymd/'));
        }

        return null;
    }

    private static function toFile($data) {
        if (is_string($data) && preg_match('/^data:/', $data)) {
            $folder = self::getFolder();

            if ($folder) {
                $file = tempnam($folder, '');
                $content = base64_decode(substr($data, strpos($data, ',')));

                if (file_put_contents($file, $content) !== false) {
                    chmod($file, 0644);
                    return $file;
                }
            }
        }

        return null;
    }

    private $info;

    private function __construct($name, $file) {
        if (strtolower(pathinfo($name, PATHINFO_EXTENSION)) === 'svg') {
            $mime_type = 'image/svg+xml';
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_type = finfo_file($finfo, $file);
            finfo_close($finfo);
        }

        $info = [
            'file' => $file,
            'type' => 2,
            'name' => $name,
            'path' => substr($file, strlen(dirname($file, 2)) + 1),
            'size' => filesize($file),
            'hash' => md5_file($file),
            'mime_type' => $mime_type,
            'privilege' => 9,
        ];

        switch (strstr($mime_type, '/', true)) {
        case 'image':
            $size = @getimagesize($file);
            if ($size) {
                $info['width'] = $size[0];
                $info['height'] = $size[1];
            }
            break;
        }

        $this->info = $info;
    }

    public function __toString() {
        return $this->info['path'];
    }

    public function info() {
        return $this->info;
    }

    public function save($parent_id = -1) {
        $duplicated = model('File')->query([
            'parent_id' => $parent_id,
            'size' => $this->info['size'],
            'hash' => $this->info['hash'],
        ]);

        if ($duplicated) {
            unlink($this->info['file']);

            $this->info = $duplicated[0];
        } else {
            $this->info['parent_id'] = $parent_id;

            $this->info = model('File')->insert($this->info);
        }
    }

}
