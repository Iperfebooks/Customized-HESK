console.log('BEGIN theme/hesk3/customer/js/customer-login-check.js');
globalThis.currentUrl = {
    get URL() {
        return (new URL(window.location.href));
    },
    getURL() {
        return this.URL;
    },
    get uri() {
        return this?.getURL()?.pathname || null;
    },
    uriIn(options) {
        if (!options || !Array.isArray(options)) {
            return false;
        }

        return (options || [])?.includes(this.uri);
    },
}

globalThis.CustomerAuth = {
    get auth_token() {
        return localStorage.getItem('customer-auth-token') || null
    },

    getCustomerData() {
        return globalThis?.Customer_API?.CUSTOMER_DATA || {};
    },

    get auth_user() {
        return this.getCustomerData() || {};
    },
}

globalThis.getHeskURL = globalThis.getHeskURL || ((uri) => {
    let url = new URL(location.origin);
    uri = uri && typeof uri === 'string' && uri.trim() ? uri.trim() : '';
    url.pathname = uri;
    return url;
})

document.addEventListener('DOMContentLoaded', async (event) => {
    let isLoggedIn = globalThis.Customer_API.CUSTOMER_DATA && await globalThis.Customer_API.validateToken();

    console.log('isLoggedIn', isLoggedIn);

    if (!isLoggedIn) {
        globalThis.LoadingScreen?.show && globalThis.LoadingScreen?.show(0);

        if (!globalThis.currentUrl.uriIn(['/customer-login.php', 'customer-login.php',])) {
            location.href = getHeskURL('customer-login.php');
        }

        return;
    }

    if (!globalThis.currentUrl.uriIn(['/ticket.php', 'ticket.php',])) {
        location.href = getHeskURL('ticket.php');
    }
});
console.log('END theme/hesk3/customer/js/customer-login-check.js');
