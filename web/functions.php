<?php

declare(strict_types=1);

namespace {
    if (!function_exists('env')) {
        function env($name, $default)
        {
            if (isset($_ENV[$name])) {
                return $_ENV[$name];
            }

            return $default;
        }
    }
}
