<?php
/**
 * Custom file
 */

/* Check if this is a valid include */
if (!defined('IN_SCRIPT')) {
    die('Invalid attempt');
}

if (!function_exists('hesk_require')) {
    /**
     * function hesk_require
     *
     * @param string $path
     * @param bool $once
     *
     * @return void
     */
    function hesk_require(string $path, bool $once = false): void
    {
        $heskBasePath = defined('HESK_BASE_PATH') ? constant('HESK_BASE_PATH') : __DIR__ . '/..';

        $path = implode('/', array_filter([
            realpath($heskBasePath),
            $path
        ]));

        if ($once) {
            require_once $path;
            return;
        }

        require $path;
    }
}

if (!function_exists('hesk_require_once')) {
    /**
     * function hesk_require_once
     *
     * @param string $path
     * @return void
     */
    function hesk_require_once(string $path): void
    {
        hesk_require($path, true);
    }
}

if (function_exists('hesk_session_start')) {
    hesk_session_start();
}

if (!function_exists('hesk_settings_get')) {
    /**
     * function hesk_settings_get
     *
     * @param ?string $key
     * @param mixed $default
     * @return mixed
     */
    function hesk_settings_get(?string $key = null, mixed $default = null): mixed
    {
        global $hesk_settings;

        if (is_null($key)) {
            return $hesk_settings ?? [];
        }

        return ($hesk_settings ?? [])[$key] ?? $default;
    }
}

if (!function_exists('hesk_url')) {
    /**
     * function hesk_url
     *
     * @param ?string $uri
     * @param array $query
     * @return string
     * */
    function hesk_url(?string $uri = null, array $query = []): string
    {
        $heskUrl = hesk_settings_get('hesk_url');

        $query = $query ? '?' . http_build_query($query) : '';

        return implode('/', array_filter([
            rtrim($heskUrl, '/\\'),
            trim(strval($uri), '/\\'),
        ])) . $query;
    }
}

if (!function_exists('hesk_template_url')) {
    /**
     * function hesk_template_url
     *
     * @param ?string $uri
     * @param array $query
     * @return string
     * */
    function hesk_template_url(?string $uri = null, array $query = []): string
    {
        $heskTemplateUrl = hesk_url(
            trim(TEMPLATE_PATH, '.\.\/'),
        );

        $query = $query ? '?' . http_build_query($query) : '';

        return implode('/', array_filter([
            rtrim($heskTemplateUrl, '/\\'),
            trim(strval($uri), '/\\'),
        ])) . $query;
    }
}

if (!function_exists('hesk_session_get')) {
    /**
     * function hesk_session_get
     *
     * @param ?string $key
     * @param mixed $default
     * @return mixed
     */
    function hesk_session_get(?string $key = null, mixed $default = null): mixed
    {
        if (is_null($key)) {
            return $_SESSION ?? [];
        }

        return ($_SESSION ?? [])[$key] ?? $default;
    }
}

if (!function_exists('hesk_header_get')) {
    /**
     * function hesk_header_get
     *
     * @param ?string $key
     * @param mixed $default
     * @return mixed
     */
    function hesk_header_get(?string $key = null, mixed $default = null): mixed
    {
        $headers = array_filter(
            $_SERVER ?? [],
            fn($_key) => str_starts_with(
                strtoupper(strval($_key)),
                'HTTP_'
            ),
            ARRAY_FILTER_USE_KEY
        );

        if (is_null($key)) {
            return $headers ?? [];
        }

        $key = strtoupper(str_replace(['-', ' '], '_', $key));

        $headers = $headers ?? [];
        return $headers[$key] ?? $headers['HTTP_' . $key] ?? $default;
    }
}

if (!function_exists('customer_auth_token')) {
    /**
     * function customer_auth_token
     * @return ?string
     */
    function customer_auth_token(): ?string
    {
        $token = hesk_header_get('auth-token');
        return $token && is_string($token) && trim($token) && strlen($token) >= 15 ? trim($token) : null;
    }
}

if (!function_exists('customer_login_check')) {
    /**
     * function customer_login_check
     *
     * @return void
     */
    function customer_login_check(): void
    {
        if (!hesk_settings_get('login_required_to_ticket')) {
            return;
        }

        require TEMPLATE_PATH . 'customer/inc/customer-login-check.inc.php';
    }
}
