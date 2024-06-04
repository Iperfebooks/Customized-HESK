@php
$title ??= '';
$triggerLabel ??= $title ?: 'Modal';
$body ??= '';
$footer ??= '';
$uid ??= 'form_' . uniqid();

$wraperTag ??= 'div';
$wraperTag = in_array($wraperTag, ['li', 'div']) ? $wraperTag : 'div';

$triggerTag ??= 'button';
$triggerTag = in_array($triggerTag, ['li', 'button', 'div', 'span', 'a']) ? $triggerTag : 'button';

$triggerClass ??= [];
$triggerClass = is_array($triggerClass) || is_string($triggerClass) ? $triggerClass : [];
$triggerClass = is_string($triggerClass) ? explode(' ', $triggerClass) : $triggerClass;
$triggerClass = array_filter($triggerClass);

foreach ($triggerClass as $key => $value) {
    unset($triggerClass[$key]);
    $key = is_numeric($key) ? $value : $key;
    $key = is_string($key) && trim($key) ? trim($key) : null;
    $value = is_string($value) && trim($value) ? trim($value) : null;

    if (is_null($key) || is_null($value)) {
        continue;
    }

    $triggerClass[$key] = $value;
}

$triggerClass = implode(' ', $triggerClass);
@endphp

<{{ $wraperTag }}
    x-data="{
        show: false,
    }"
    data-form-uid="{{ $uid }}"
>
    <!-- Trigger Button -->
    <{{ $triggerTag }}
        @if($triggerTag === 'button') type="button" @endif
        x-on:click.stop="show = true"
        class="{{ $triggerClass ?? '' }}"
    >{{ $triggerLabel }}</{{ $triggerTag }}>
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
</{{ $wraperTag }}>
