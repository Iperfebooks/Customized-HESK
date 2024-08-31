<?php
global $hesk_settings, $hesklang;
/**
 * @var array $currentCategory
 * @var array $subcategories
 * @var string $subcategoriesWidth
 * @var string $parentLink
 * @var array $articlesInCategory
 * @var array $serviceMessages
 * @var boolean $noSearchResults
 * @var array $topArticles
 * @var array $latestArticles
 * @var array $latestArticles
 */

// This guard is used to ensure that users can't hit this outside of actual HESK code
if (!defined('IN_SCRIPT')) {
    die();
}

require_once(TEMPLATE_PATH . 'customer/util/alerts.php');
require_once(TEMPLATE_PATH . 'customer/util/kb-search.php');
require_once(TEMPLATE_PATH . 'customer/util/rating.php');

$service_message_type_to_class = array(
    '0' => 'none',
    '1' => 'success',
    '2' => '', // Info has no CSS class
    '3' => 'warning',
    '4' => 'danger'
);
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
    <!--[if IE]>
    <link rel="stylesheet" media="all" href="<?= hesk_template_url() ?>/customer/css/ie9.css" />
    <![endif]-->
    <!--suppress CssOverwrittenProperties -->
    <style>
        .topics__block {
            width: <?php echo $subcategoriesWidth; ?>;
        }

        .content .block__head {
            margin-bottom: <?php echo $currentCategory['id'] != 1 ? '0' : '16px' ?>;
        }

        .back-link {
            display; -ms-flexbox;
            display: flex;
            margin-bottom: 16px;
            text-align: center;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

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
                    <?php foreach ($hesk_settings['public_kb_categories'][$currentCategory['id']]['parents'] as $parent_id): ?>
                    <a href="knowledgebase.php<?php if ($parent_id > 1) echo "?category={$parent_id}"; ?>">
                        <span><?php echo $hesk_settings['public_kb_categories'][$parent_id]['name']; ?></span>
                    </a>
                    <svg class="icon icon-chevron-right">
                        <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-chevron-right"></use>
                    </svg>
                    <?php endforeach; ?>
                    <div class="last"><?php echo $currentCategory['name']; ?></div>
                </div>
            </div>
        </div>
        <div class="main__content">
            <div class="contr">
                <div class="help-search">
                    <?php if ($currentCategory['id'] == 1 && $hesk_settings['kb_enable'] == 2): ?>
                        <h2 class="search__title"><?php echo $hesklang['how_can_we_help']; ?></h2>
                    <?php endif; ?>
                    <?php displayKbSearch(); ?>
                </div>
                <?php if ($noSearchResults): ?>
                    <div class="main__content notice-flash" style="padding: 0px;">
                        <div class="notification orange">
                            <p><b><?php echo $hesklang['no_results_found']; ?></b></p>
                            <?php echo $hesklang['nosr']; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php hesk3_show_messages($service_messages); ?>
                <div class="content">
                    <?php if ($currentCategory['id'] == 1): ?>
                        <div class="block__head">
                            <div class="icon-in-circle">
                                <svg class="icon icon-knowledge">
                                    <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-knowledge"></use>
                                </svg>
                            </div>
                            <h3 class="h-3 ml-1"><?php echo $currentCategory['name']; ?></h3>
                        </div>
                    <?php else: ?>
                        <div class="block__head" style="padding-bottom: 32px; text-align: left ! important; display: block;">
                            <h3 class="h-3 kb--folder">
                                <svg class="icon icon-knowledge">
                                    <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-knowledge"></use>
                                </svg>
                                <a href="knowledgebase.php">
                                    <span><?php echo $hesk_settings['public_kb_categories'][1]['name']; ?></span>
                                </a>
                                <svg class="icon icon-chevron-right">
                                    <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-chevron-right"></use>
                                </svg>
                                <?php foreach ($hesk_settings['public_kb_categories'][$currentCategory['id']]['parents'] as $parent_id): ?>
                                    <?php if ($parent_id == 1) {continue;} ?>
                                    <svg class="icon icon-folder">
                                        <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-folder"></use>
                                    </svg>
                                    <a href="knowledgebase.php?category=<?php echo $parent_id; ?>">
                                        <span><?php echo $hesk_settings['public_kb_categories'][$parent_id]['name']; ?></span>
                                    </a>
                                    <svg class="icon icon-chevron-right">
                                        <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-chevron-right"></use>
                                    </svg>
                                <?php endforeach; ?>
                                <svg class="icon icon-folder">
                                    <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-folder"></use>
                                </svg>
                                <?php echo $currentCategory['name']; ?>
                            </h3>
                        </div>
                    <?php endif; ?>
                    <?php
                    if (count($subcategories) > 0):
                    ?>
                    <div class="topics">
                        <?php foreach ($subcategories as $subcategory): ?>
                        <div class="topics__block">
                            <h5 class="topics__title">
                                <svg class="icon icon-folder">
                                    <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-folder"></use>
                                </svg>
                                <span>
                                    <a class="title-link" href="knowledgebase.php?category=<?php echo $subcategory['subcategory']['id']; ?>">
                                        <?php echo $subcategory['subcategory']['name']; ?>
                                    </a>
                                </span>
                            </h5>
                            <ul class="topics__list">
                                <?php foreach ($subcategory['articles'] as $article): ?>
                                <li>
                                    <a href="knowledgebase.php?article=<?php echo $article['id']; ?>">
                                        <?php echo $article['subject']; ?>
                                    </a>
                                </li>
                                <?php
                                endforeach;
                                if ($subcategory['displayShowMoreLink']):
                                ?>
                                <li class="text-bold">
                                    <a href="knowledgebase.php?category=<?php echo $subcategory['subcategory']['id']; ?>">
                                        <?php echo $hesklang['m']; ?> &raquo;
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if (count($articlesInCategory) > 0): ?>
                <article class="article" <?php if (count($subcategories) == 0) echo 'style="margin-top: -20px"'; ?>>
                    <div class="block__head">
                        <h3 class="h-3 text-center"><?php echo $hesklang['ac']; ?></h3>
                    </div>
                    <?php foreach ($articlesInCategory as $article): ?>
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
                <?php
                endif;

                // No sub-categories and no articles in this category
                if ( ! count($articlesInCategory) && ! count($subcategories)):
                ?>
                <div class="main__content notice-flash">
                    <div class="notification blue text-center">
                        <?php echo $hesklang['noac']; ?><br><br>
                        <a class="link" href="javascript:history.go(-1)"><?php echo $hesklang['back']; ?></a>
                    </div>
                </div>
                <?php
                endif;

                if (count($topArticles) > 0 || count($latestArticles) > 0):
                ?>
                <article class="article">
                    <div class="tabbed__head">
                        <ul class="tabbed__head_tabs">
                            <?php
                            if (count($topArticles) > 0):
                                ?>
                                <li class="current" data-link="tab1">
                                    <span><?php echo $hesklang['popart']; ?></span>
                                </li>
                            <?php
                            endif;
                            if (count($latestArticles) > 0):
                                ?>
                                <li data-link="tab2">
                                    <span><?php echo $hesklang['latart']; ?></span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="tabbed__tabs">
                        <?php if (count($topArticles) > 0): ?>
                            <div class="tabbed__tabs_tab is-visible" data-tab="tab1">
                                <?php foreach ($topArticles as $article): ?>
                                    <a href="knowledgebase.php?article=<?php echo $article['id']; ?>" class="preview">
                                        <div class="icon-in-circle">
                                            <svg class="icon icon-knowledge">
                                                <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-knowledge"></use>
                                            </svg>
                                        </div>
                                        <div class="preview__text">
                                            <h5 class="preview__title"><?php echo $article['subject'] ?></h5>
                                            <p>
                                                <span class="lightgrey"><?php echo $hesklang['kb_cat']; ?>:</span>
                                                <span class="ml-1"><?php echo $article['category']; ?></span>
                                            </p>
                                            <p class="navlink__descr">
                                                <?php echo $article['content_preview']; ?>
                                            </p>
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
                            </div>
                        <?php
                        endif;
                        if (count($latestArticles) > 0):
                            ?>
                            <div class="tabbed__tabs_tab <?php echo count($topArticles) === 0 ? 'is-visible' : ''; ?>" data-tab="tab2">
                                <?php foreach ($latestArticles as $article): ?>
                                    <a href="knowledgebase.php?article=<?php echo $article['id']; ?>" class="preview">
                                        <div class="icon-in-circle">
                                            <svg class="icon icon-knowledge">
                                                <use xlink:href="<?= hesk_template_url() ?>/customer/img/sprite.svg#icon-knowledge"></use>
                                            </svg>
                                        </div>
                                        <div class="preview__text">
                                            <h5 class="preview__title"><?php echo $article['subject'] ?></h5>
                                            <p>
                                                <span class="lightgrey"><?php echo $hesklang['kb_cat']; ?>:</span>
                                                <span class="ml-1"><?php echo $article['category']; ?></span>
                                            </p>
                                            <p class="navlink__descr">
                                                <?php echo $article['content_preview']; ?>
                                            </p>
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
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
                <?php endif; ?>
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
