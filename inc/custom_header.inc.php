<script>
globalThis.CUSTOMER_API_BASE_URL = "<?= hesk_settings_get('customer_api_base_url') ?>";
</script>
<?php require_once __DIR__ . '/../head.txt'; ?>
<link rel="stylesheet" media="all" href="<?php echo HESK_PATH; ?>css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>">
<link rel="stylesheet" media="all" href="<?php echo HESK_PATH; ?>css/style.css?<?= date('his') ?>">

<!-- Loader BEGIN -->
<style>
/* HTML: <div class="loader"></div> */
.loader-container {
    background: #123d35;
    width: 100%;
    height: 100vh;
    position: fixed;
    display: revert;
    z-index: 1500;
}

.loader-container-sub {
    color: white;
    text-align: center;
    position: relative;
    width: 14rem;
    margin-left: auto;
    margin-right: auto;
    margin-top: 50vh;
}

.loader {
    width: 50px;
    padding: 8px;
    aspect-ratio: 1;
    border-radius: 50%;
    background: #25b09b;
    --_m:
        conic-gradient(#0000 10%, #000),
        linear-gradient(#000 0 0) content-box;
    -webkit-mask: var(--_m);
    mask: var(--_m);
    -webkit-mask-composite: source-out;
    mask-composite: subtract;
    animation: l3 1s infinite linear;
}

@keyframes l3 {
    to {
        transform: rotate(1turn)
    }
}
</style>
<div class="loader-container">
    <div class="loader-container-sub">
        <div class="loader"></div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', (event) => {
    setTimeout(() => {
        document.querySelector('.loader-container').style.display = 'none';
    }, 500)
});
</script>
<!-- Loader END -->
