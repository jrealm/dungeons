<?php //>

namespace dungeons\web;

use dungeons\Controller as AbstractController;

class Controller extends AbstractController {

    public function available() {
        return ($this->method() === 'GET' && $this->name() === $this->path());
    }

    protected function wrap() {
        switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            return $this->wrapGet();

        case 'POST':
            if (preg_match('/application\/json/i', @$_SERVER['CONTENT_TYPE'])) {
                return array_merge($this->wrapGet(), $this->wrapJson());
            } else {
                return array_merge($this->wrapGet(), $this->wrapPost());
            }

        default:
            return [];
        }
    }

    protected function wrapGet() {
        $form = [];

        foreach ($_GET as $name => $value) {
            $form[$name] = $value;
        }

        return $form;
    }

    protected function wrapJson() {
        $form = json_decode(file_get_contents('php://input'), true);

        return is_array($form) ? $form : [];
    }

    protected function wrapPost() {
        $form = [];

        foreach ($_POST as $name => $value) {
            $form[$name] = $value;
        }

        foreach ($_FILES as $name => $value) {
            $form[$name] = [];

            if ($value['error'] === UPLOAD_ERR_OK) {
                $form[$name][] = [
                    'name' => $value['name'],
                    'path' => $value['tmp_name'],
                ];
            } else if (is_array($value['error'])) {
                foreach ($value['error'] as $index => $error) {
                    if ($error === UPLOAD_ERR_OK) {
                        $form[$name][] = [
                            'name' => $value['name'][$index],
                            'path' => $value['tmp_name'][$index],
                        ];
                    }
                }
            }
        }

        return $form;
    }

}
