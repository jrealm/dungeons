<?php //>

return new Twig\TwigFilter('video', function ($video, $platform, $autoplay, $controls) {
    $autoplay = ($autoplay === 'true') ? 1 : 0;

    switch ($platform) {
    case 'youtube':
        $url = "https://www.youtube.com/embed/{$video}?rel=0&mute={$autoplay}";
        break;
    case 'vimeo':
        $url = "https://player.vimeo.com/video/{$video}?muted={$autoplay}";
        break;
    default:
        return null;
    }

    return "{$url}&autoplay={$autoplay}&controls={$controls}";
});
