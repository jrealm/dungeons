<?php //>

return new Twig\TwigFunction('find', function ($model, $conditions) {
    return model($model)->enableFilter()->find($conditions);
});
