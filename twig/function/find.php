<?php //>

return new Twig\TwigFunction('find', function ($model, $conditions) {
    return model($model)->find($conditions);
});
