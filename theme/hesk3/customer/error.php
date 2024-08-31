<?php
global $hesk_settings, $hesklang;
/**
 * @var string $error
 * @var boolean $showDebugWarning
 * @var string $breadcrumbLink
 */

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $hesk_settings['hesk_title']; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?= hesk_url() . '/'; ?>img/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?= hesk_url() . '/'; ?>img/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?= hesk_url() . '/'; ?>img/favicon/favicon-16x16.png" />
    <link rel="manifest" href="<?= hesk_url() . '/'; ?>img/favicon/site.webmanifest" />
    <link rel="mask-icon" href="<?= hesk_url() . '/'; ?>img/favicon/safari-pinned-tab.svg" color="#5bbad5" />
    <link rel="shortcut icon" href="<?= hesk_url('img/favicon/favicon.ico'); ?>" />
    <meta name="msapplication-TileColor" content="#2d89ef" />
    <meta name="msapplication-config" content="<?= hesk_url() . '/'; ?>img/favicon/browserconfig.xml" />
    <meta name="theme-color" content="#ffffff" />
    <meta name="format-detection" content="telephone=no" />
    <link rel="stylesheet" media="all" href="<?= hesk_template_url() ?>/customer/css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>" />
    <?php require_once TEMPLATE_PATH . '../../inc/custom_header.inc.php'; ?>
</head>

<body class="cust-help">
<?php hesk_require('header.php'); ?>
<div class="wrapper">
    <main class="main">
        <header class="header">
            <div class="contr">
                <div class="header__inner">
                    <a href="<?php echo $hesk_settings['hesk_url']; ?>" class="header__logo">
                        <?php echo $hesk_settings['hesk_title']; ?>
                    </a>
                </div>
            </div>
        </header>
        <div class="breadcrumbs">
            <div class="contr">
                <div class="breadcrumbs__inner">
                    <a href="<?php echo $hesk_settings['site_url']; ?>">
                        <span><?php echo $hesk_settings['site_title']; ?></span>
                    </a>
                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                    <a href="<?php echo $breadcrumbLink; ?>">
                        <span><?php echo $hesk_settings['hesk_title']; ?></span>
                    </a>
                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                    <div class="last"><?php echo $hesklang['error']; ?></div>
                </div>
            </div>
        </div>
        <div class="main__content">
            <div class="contr">
                <div class="main__content notice-flash">
                    <div class="notification red">
                        <b><?php echo $hesklang['error']; ?>:</b> <?php echo $error; ?>
                        <?php if ($showDebugWarning): ?>
                            <p class="text-danger text-bold" style="margin-top:10px">&nbsp;<br><?php echo $hesklang['warn']; ?></p>
                            <?php echo $hesklang['dmod']; ?>
                        <?php endif; ?>
                        <p class="text-center">
                            &nbsp;<br>
                            <a class="link" href="javascript:history.go(-1)"><?php echo $hesklang['back']; ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
<?php
require HESK_BASE_PATH . '/hesk/hidden-footer.php';
?>
    </main>
</div>
<?php include(TEMPLATE_PATH . '../../footer.txt'); ?>
</body>
</html>
