<?php
global $hesk_settings, $hesklang;
/**
 * @var array $articles
 */

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}

require_once(TEMPLATE_PATH . 'customer/util/kb-search.php');
require_once(TEMPLATE_PATH . 'customer/util/rating.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $hesk_settings['tmp_title']; ?></title>
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
    <!-- search-results.php -->
    <!--[if IE]>
    <link rel="stylesheet" media="all" href="<?= hesk_template_url() ?>/customer/css/ie9.css" />
    <![endif]-->
    <style>
        <?php outputSearchStyling(); ?>
    </style>
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
                        <img src="./img/favicon/simbolo.svg" alt="" width="25px" height="25px" style="vertical-align: -3px;">
                    </a>
                    <?php if ($hesk_settings['can_sel_lang']): ?>
                        <div class="header__lang">
                            <form method="get" action="" style="margin:0;padding:0;border:0;white-space:nowrap;">
                                <div class="dropdown-select center out-close">
                                    <select name="language" onchange="this.form.submit()">
                                        <?php hesk_listLanguages(); ?>
                                    </select>
                                </div>
                                <?php foreach (hesk_getCurrentGetParameters() as $key => $value): ?>
                                    <input type="hidden" name="<?php echo hesk_htmlentities($key); ?>"
                                           value="<?php echo hesk_htmlentities($value); ?>">
                                <?php endforeach; ?>
                            </form>
                        </div>
                    <?php endif; ?>
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
                    <a href="<?php echo $hesk_settings['hesk_url']; ?>">
                        <span><?php echo $hesk_settings['hesk_title']; ?></span>
                    </a>
                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                    <a href="knowledgebase.php">
                        <span><?php echo $hesklang['kb_text']; ?></span>
                    </a>
                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                    <div class="last"><?php echo $hesklang['sr']; ?></div>
                </div>
            </div>
        </div>
        <div class="main__content">
            <div class="contr">
                <div class="help-search">
                    <?php displayKbSearch(); ?>
                </div>
                <article class="article">
                    <div class="block__head">
                        <div class="icon-in-circle">
                            <svg class="icon icon-knowledge">
                                <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-knowledge"></use>
                            </svg>
                        </div>
                        <h3 class="h-3 ml-1 text-center"><?php echo $hesklang['sr']; ?> (<?php echo count($articles); ?>)</h3>
                    </div>
                    <?php foreach ($articles as $article): ?>
                        <a href="knowledgebase.php?article=<?php echo $article['id']; ?>" class="preview">
                            <div class="icon-in-circle">
                                <svg class="icon icon-knowledge">
                                    <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-knowledge"></use>
                                </svg>
                            </div>
                            <div class="preview__text">
                                <h5 class="preview__title"><?php echo $article['subject']; ?></h5>
                                <p class="navlink__descr"><?php echo $article['content_preview']; ?></p>
                            </div>
                            <?php if ($hesk_settings['kb_views'] || $hesk_settings['kb_rating']): ?>
                                <div class="rate">
                                    <?php if ($hesk_settings['kb_views']): ?>
                                        <div style="margin-right: 10px; display: -ms-flexbox; display: flex;">
                                            <svg class="icon icon-eye-close">
                                                <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-eye-close"></use>
                                            </svg>
                                            <span class="lightgrey"><?php echo $article['views_formatted']; ?></span>
                                        </div>
                                    <?php
                                    endif;
                                    if ($hesk_settings['kb_rating']): ?>
                                        <?php echo hesk3_get_customer_rating($article['rating']); ?>
                                        <?php if ($hesk_settings['kb_views']) echo '<span class="lightgrey">('.$article['votes_formatted'].')</span>'; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </a>
                        <!--[if IE]>
                            <p>&nbsp;</p>
                        <![endif]-->
                    <?php endforeach; ?>
                </article>
            </div>
        </div>
<?php
require HESK_BASE_PATH . '/hidden-footer.php';
?>
    </main>
</div>
<?php include(TEMPLATE_PATH . '../../footer.txt'); ?>
<script src="<?= hesk_template_url() ?>/customer/js/jquery-3.5.1.min.js"></script>
<script src="<?= hesk_template_url() ?>/customer/js/hesk_functions.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
<?php outputSearchJavascript(); ?>
<script src="<?= hesk_template_url() ?>/customer/js/svg4everybody.min.js"></script>
<script src="<?= hesk_template_url() ?>/customer/js/selectize.min.js"></script>
<script src="<?= hesk_template_url() ?>/customer/js/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.js?<?php echo $hesk_settings['hesk_version']; ?>"></script>
</body>
</html>
