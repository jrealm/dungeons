<?php //>

return function ($text) {
    return preg_match('/[\x{4e00}-\x{9fa5}]/u', $text);
};
