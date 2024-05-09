globalThis.toast = {
    toastIt(message, style = {}, duration = 3000) {
        if (!message || typeof message !== 'string' || !message?.trim()) {
            return;
        }

        style = style && typeof style === 'object' && !Array.isArray(style) ? style : {};

        Toastify({
            text: message,
            duration: duration || 3000,
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style,
            onClick: function() {} // Callback after click
        }).showToast();
    },
    error(message, duration = 3000) {
        return this.toastIt(message, {
            background: "#e54545",
        }, duration);
    },
    success(message, duration = 3000) {
        return this.toastIt(message, {
            background: "#00b001",
        }, duration);
    },
    info(message, duration = 3000) {
        return this.toastIt(message, {
            background: "#137891",
        }, duration);
    },
}
