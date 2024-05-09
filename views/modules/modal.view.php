<?php
$title ??= '';
$triggerLabel ??= 'Modal';
$body ??= '';
$footer ??= '';
?>
<div
    x-data="{
        show: false,
    }"
>
    <!-- Trigger Button -->
    <button type="button" x-on:click.stop="show = true"><?= $triggerLabel ?></button>
    <!-- Modal Structure -->
    <div
        class="custom-modal"
        x-bind:class="{
            show: show,
        }"
    >
        <div
            class="custom-modal-content"
            x-on:click.outside="show = false"
            @keyup.escape.window="show = false"
        >
            <span class="custom-modal-close" x-on:click="show = false">&times;</span>
            <h2 class="custom-modal-title"><?= $title ?? null ?></h2>
            <div class="custom-modal-body"><?= $body ?? null ?></div>
            <div class="custom-modal-footer"><?= $footer ?? null ?></div>
        </div>
    </div>
</div>
