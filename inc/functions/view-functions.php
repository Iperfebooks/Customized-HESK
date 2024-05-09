<?php

if (!defined('HESK_REALPATH_PATH')) {
    define('HESK_REALPATH_PATH', realpath(__DIR__ . '/../..'));
}

if (!defined('VIEWS_DIR')) {
    define('VIEWS_DIR', HESK_REALPATH_PATH . '/views');
}

if (!function_exists('views_dir')) {
    /**
     * function views_dir
     *
     * @return string
     */
    function views_dir(): string
    {
        if (defined('VIEWS_DIR')) {
            return trim(rtrim(VIEWS_DIR, '/\\'));
        }

        return trim(rtrim(HESK_REALPATH_PATH . '/views', '/\\'));
    }
}

if (!function_exists('view_path')) {
    /**
     * function view_path
     *
     * @param string $view
     * @return string
     */
    function view_path(string $view): string
    {
        $view = rtrim($view, '\.view\.php');

        return implode(
            '/',
            array_filter([
                trim(rtrim(views_dir(), '/\\')),
                trim(rtrim($view, '/\\')) . '.view.php',
            ]),
        );
    }
}

if (!function_exists('view_content')) {
    /**
     * function view_content
     *
     * @param string $view
     * @param array $data
     * @param bool $return
     *
     * @return ?string
     */
    function view_content(
        string $view,
        array $data = [],
        bool $return = true,
    ): ?string {
        extract($data);
        $path = view_path($view);
        $content = function () use ($path) {
            return file_get_contents($path);
        };

        $content();

        // $content = rtrim($content, '1');

        if ($return) {
            // return $content;
        }

        // echo $content;

        return null;
    }
}

if (!function_exists('view')) {
    /**
     * function view
     *
     * @param string $view
     * @param array $data
     * @param bool $return
     *
     * @return ?string
     */
    function view(
        string $view,
        array $data = [],
        bool $return = true,
    ): ?string {
        return view_content(
            $view,
            $data,
            $return,
        );
    }
}

if (!function_exists('view_render')) {
    /**
     * function view_render
     *
     * @param string $view
     * @param array $data
     *
     * @return void
     */
    function view_render(
        string $view,
        array $data = [],
    ): void {
        echo view_content($view, $data, true);
    }
}
