<script>
globalThis.HESK_TEMPLATE_URL = "<?= hesk_template_url() ?>";
globalThis.HESK_BASE_URL = "<?= hesk_url() ?>";
globalThis.CUSTOMER_API_BASE_URL = "<?= hesk_settings_get('customer_api_base_url') ?>";
</script>

<!-- BEGIN head.txt -->
<?php require HESK_PATH . 'head.txt'; ?>
<!-- END head.txt -->

<script src="<?= hesk_url('/js/libs/toast.js') ?>"></script>
<script src="<?= hesk_url('/js/libs/customer-api.js') ?>"></script>
<script src="//unpkg.com/alpinejs" defer></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script defer type="text/javascript" src="//cdn.jsdelivr.net/npm/toastify-js"></script>

<link rel="stylesheet" media="all" href="<?= hesk_url() ?>/css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>">
<link rel="stylesheet" media="all" href="<?= hesk_url() ?>/css/style.css?<?= date('his') ?>">
