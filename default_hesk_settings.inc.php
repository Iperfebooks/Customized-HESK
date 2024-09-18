<?php

/**
 * Customized-HESK:
 * https://github.com/tiagofrancafernandes/Customized-HESK
 *
 * HESK Admin (Laravel APP)
 * https://github.com/tiagofrancafernandes/WIP-Help-Desk-System-Laravel
 */

if (!defined('HESK_BASE_PATH')) {
    define('HESK_BASE_PATH', __DIR__ );
}

$hesk_settings = isset($hesk_settings) && is_array($hesk_settings) ? $hesk_settings : [];

$hesk_settings['site_url'] ??= 'http://site.localhost/';
$hesk_settings['hesk_url'] ??= 'http://hesk.localhost/';

//$hesk_settings['customer_api_base_url'] = trim($hesk_settings['hesk_url'] ?? '', '\/') . 'hesk-admin/api'; // Laravel APP API path
$hesk_settings['customer_api_base_url'] ??= rtrim(strval($hesk_settings['hesk_url'] ?? ''), '\/') . '/hesk-admin/api'; // Aplicacao Laravel
$hesk_settings['login_required_to_ticket'] ??= 1;
