<script>
globalThis.HESK_TEMPLATE_URL = "<?= hesk_template_url() ?>";
globalThis.HESK_BASE_URL = "<?= hesk_url() ?>";
globalThis.CUSTOMER_API_BASE_URL = "<?= hesk_settings_get('customer_api_base_url') ?>";
</script>

<script src="<?= hesk_url('/js/libs/helpers.js') ?>"></script>
<script src="<?= hesk_url('/js/libs/toast.js') ?>"></script>
<script src="<?= hesk_url('/js/libs/customer-api.js') ?>"></script>
<script src="//unpkg.com/alpinejs" defer></script>

<!-- BEGIN head.txt -->
<?php hesk_require('head.txt'); ?>
<!-- END head.txt -->

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script defer type="text/javascript" src="//cdn.jsdelivr.net/npm/toastify-js"></script>

<link
    rel="stylesheet"
    media="all"
    href="<?= hesk_url() ?>/css/app<?= hesk_settings_get('debug_mode') ? '' : '.min'; ?>.css?<?= hesk_settings_get('hesk_version'); ?>"
>

<link rel="stylesheet" media="all" href="<?= hesk_url('/css/styles.css') ?>?<?= date('his') ?>">
