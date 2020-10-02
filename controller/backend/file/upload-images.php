<?php //>

use dungeons\Attachment;

return new class() extends dungeons\web\UserController {

    protected function process($form) {
        $paths = [];
        $images = @$form['images'];

        if ($images) {
            foreach ($images as $image) {
                $file = @$image['file'];

                if ($file instanceof Attachment) {
                    $file->save();

                    $paths[] = 'files/' . strval($file);
                }
            }
        }

        return ['success' => true, 'type' => 'insert-images', 'target' => @$form['target'], 'paths' => $paths];
    }

    protected function wrap() {
        $form = parent::wrap();
        $images = @$form['images'];

        if ($images) {
            $form['images'] = [];

            foreach ($images as $image) {
                $form['images'][] = Attachment::wrap($image, 'file');
            }
        }

        return $form;
    }

};
