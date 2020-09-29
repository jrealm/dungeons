<?php //>

$editable = true;

return new Twig\TwigFunction('label', function ($token, $default = null) use ($editable) {
    $text = dungeons\Message::get($token, $default);

    if ($editable) {
        $text = "<span data-edit=\"{$token}\">{$text}</span>";
    }

    return new Twig\Markup($text, 'UTF-8');
});
