<?php //>

return new Twig\TwigFunction('build', function ($path, $query, $append = null, $remove = null) {
    if ($append) {
        foreach ($append as $name => $value) {
            if (is_null($value)) {
                unset($query[$name]);
            } else {
                $query[$name] = $value;
            }
        }
    }

    if ($remove) {
        foreach ($remove as $name) {
            unset($query[$name]);
        }
    }

    if ($query) {
        return $path . '?' . http_build_query($query);
    } else {
        return $path;
    }
});
