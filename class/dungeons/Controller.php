<?php //>

namespace dungeons;

use dungeons\db\Connection;
use dungeons\utility\ValueObject;
use dungeons\view\{Native,Twig};

abstract class Controller extends ValueObject {

    public function execute() {
        $this->init();

        $form = $this->trim($this->wrap());
        $result = $this->validate($form);

        if ($result) {
            $view = $this->validationView();
        } else {
            $form = $this->preprocess($form);
            $connection = Connection::getInstance();

            try {
                if ($connection) {
                    $connection->begin();
                }

                $result = $this->process($form);
            } catch (AppException $exception) {
                $result = ['error' => $exception->getMessage()];
            } finally {
                if (!$result) {
                    $result = [];
                }

                if (empty($result['success'])) {
                    if ($connection) {
                        $connection->rollback();
                    }
                } else {
                    if ($connection) {
                        $connection->commit();
                    }

                    $result = $this->postprocess($form, $result);
                }
            }

            if (empty($result['view'])) {
                if (empty($result['success'])) {
                    $view = $this->errorView() ?: 'error.php';
                } else {
                    $view = $this->view();
                }
            } else {
                $view = $result['view'];
            }
        }

        $this->resolve($view ?: 'raw.php')->render($this, $form, $result);
    }

    protected function init() {
    }

    protected function postprocess($form, $result) {
        return $result;
    }

    protected function preprocess($form) {
        return $form;
    }

    protected function process($form) {
        return ['success' => true];
    }

    protected function resolve($view) {
        switch (pathinfo($view, PATHINFO_EXTENSION)) {
            case 'twig':
                return new Twig($view);
        }

        return new Native($view);
    }

    protected function validate($form) {
        return null;
    }

    abstract protected function wrap();

    private function trim($value) {
        if (is_string($value)) {
            $value = trim($value);

            return strlen($value) ? $value : null;
        }

        if (is_array($value)) {
            return array_map([$this, 'trim'], $value);
        }

        return $value;
    }

}
