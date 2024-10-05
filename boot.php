<?php

if (!defined('HESK_BASE_PATH')) {
    define('HESK_BASE_PATH', __DIR__);
}

require_once __DIR__ . '/hesk_settings.inc.php';
require_once __DIR__ . '/default_hesk_settings.inc.php';
require_once __DIR__ . '/inc/functions/function-loader.php';

$hesk_settings ??= $hesk_settings;

$variablesEnv = load_dot_env_file(
    filePath: __DIR__ . '/.env',
    safeLoad: true,
    varToLower: true,
    preserveVarName: true,
);

$hesk_settings = array_merge(
    $hesk_settings,
    $variablesEnv,
);

$debugOn = $hesk_settings['debug_mode'] ?? false;

ini_set('display_errors', $debugOn ? 1 : 0);
ini_set('display_startup_errors', $debugOn ? 1 : 0);
error_reporting($debugOn ? E_ALL : 0);
