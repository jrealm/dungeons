<?php //>

return new Twig\TwigFunction('query', function ($model, $conditions = []) {
    return model($model)->enableFilter()->query($conditions);
});
