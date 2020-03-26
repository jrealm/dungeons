<?php //>

return new class() {

    public function validate($value, $options) {
        return dungeons\Attachment::validate($value, $options->mimeType());
    }

};
