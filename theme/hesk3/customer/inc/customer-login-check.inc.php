<!-- BEGIN theme/hesk3/customer/inc/customer-login-check.inc.php -->
<?php hesk_require('inc/custom_header.inc.php'); ?>
<meta name="customer_auth_token" content="<?= customer_auth_token()?>">
<script src="<?= hesk_template_url('customer/js/customer-login-check.js') ?>"></script>
<!-- END theme/hesk3/customer/inc/customer-login-check.inc.php -->

<?php
