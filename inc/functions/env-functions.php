<?php

if (!function_exists('load_dot_env_file')) {
    /**
     * function load_dot_env_file
     *
     * @param string $filePath
     * @param ?bool $safeLoad
     * @param bool $varToLower
     * @param bool $preserveVarName
     *
     * @return array
     */
    function load_dot_env_file(
        string $filePath,
        ?bool $safeLoad = null,
        bool $varToLower = false,
        bool $preserveVarName = true,
    ): array {
        $variables = [];

        if (!is_file($filePath) && $safeLoad) {
            return $variables;
        }

        if (!is_file($filePath)) {
            throw new \Exception("The file '{$filePath}' not exists", 1);
        }

        // Read the file line by line
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);


        $validateVarName = function (mixed $name): ?string {
            if (!$name || !is_string($name)) {
                return null;
            }

            $regex = '/^[a-zA-Z_][a-zA-Z0-9_]*$/';

            $name = trim($name);
            return preg_match($regex, $name) === 1 ? $name : null;
        };

        $removeStringInvalidQuotes = function (?string $value): ?string {
            if (substr($value, 0, 1) === '"' && substr($value, -1) === '"') {
                return substr($value, 1, -1);
            }

            if (substr($value, 0, 1) === "'" && substr($value, -1) === "'") {
                return substr($value, 1, -1);
            }

            return $value;
        };

        foreach ($lines as $line) {
            // Ignore the lines started with '#'
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Remove # that are not in quotes
            $line = preg_replace('/\s*#.*$/', '', $line);

            // Checks if the line is not empty after removing comments
            if (empty(trim($line))) {
                continue;
            }

            // Split the line in key/value
            list($key, $value) = explode('=', $line, 2);

            $varName = $validateVarName($key);
            $value = $removeStringInvalidQuotes(trim($value));

            if (!$varName) {
                continue;
            }

            if ($preserveVarName) {
                $_ENV[$varName] = $value;
                $variables[$varName] = $value;
            }

            if ($varToLower) {
                $_ENV[strtolower($varName)] = $value;
                $variables[strtolower($varName)] = $value;
            }

            if (function_exists('putenv')) {
                putenv("{$varName}={$value}");
            }
        }

        $_SERVER = $_SERVER + $_ENV;

        return $variables ?? [];
    }
}

if (!function_exists('array_dot_get')) {
    /**
     * array_dot_get function
     *
     * @param array $array
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    function array_dot_get(array $array, string $key, mixed $default = null): mixed
    {
        foreach (explode('.', $key) as $key) {
            if (!array_key_exists($key, $array)) {
                return $default;
            }

            $array = $array[$key] ?? null;
        }

        return $array;
    }
}

if (!function_exists('env_get')) {
    /**
     * function env_get
     *
     * @param string $key
     * @param mixed $default = null
     *
     * @return mixed
     */
    function env_get(?string $key = null, mixed $default = null): mixed
    {
        return array_dot_get(
            $_ENV,
            $key,
            array_dot_get($_SERVER, $key, $default)
        );
    }
}
