<?php //>

namespace dungeons;

class FileInfo {

    public static function from($file, $name, $path) {
        if (strtolower(pathinfo($name, PATHINFO_EXTENSION)) === 'svg') {
            $mimeType = 'image/svg+xml';
        } else {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file);
            finfo_close($finfo);
        }

        $info = [
            'file' => $file,
            'name' => $name,
            'path' => $path,
            'size' => filesize($file),
            'mimeType' => $mimeType,
        ];

        switch (strstr($mimeType, '/', true)) {
            case 'image':
                $size = @getimagesize($file);
                if ($size) {
                    $info['width'] = $size[0];
                    $info['height'] = $size[1];
                }
                break;
        }

        return $info;
    }

}
