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
    let str_trim_slashes = globalThis?.Helpers?.str_trim_slashes || ((string) => string.trim().replaceAll(/^\/|\/$/ig, ''));
    let url = new URL(globalThis.HESK_BASE_URL || location.origin);
    uri = uri && typeof uri === 'string' && uri.trim() ? uri.trim() : '';

    return [
        url.href,
        (uri ? `${uri}` : ''),
    ]
    .map(item => str_trim_slashes(item))
    .filter(item => item)
    .join('/');
});

globalThis.LOADED_CUSTOMER_DATA = {
    customerData: null,
    refreshCustomerData() {
        this.customerData = globalThis?.CustomerAuth?.getCustomerData() || null;
    },
    get(key, defaultValue = null) {
        if (!this.customerData) {
            this.refreshCustomerData();
        }

        if (!key || typeof key !== 'string' || !key.trim() || !this.customerData) {
            return defaultValue;
        }

        if (typeof this.customerData !== 'object' || Array.isArray(this.customerData)) {
            return defaultValue;
        }

        return this.customerData[key] || this[key] || defaultValue;
    },
    getCustomerData() {
        if (this.customerData === null) {
            this.customerData = this.customerData || globalThis?.CustomerAuth?.getCustomerData();

            return this.customerData;
        }

        return this.customerData || globalThis?.CustomerAuth?.getCustomerData();
    },
    get customerEmail() {
        return this.customerData?.email || '';
    },
    fillAllInputs() {
        document.querySelectorAll('[data-customer-info]')?.forEach(element => {
            let property = element?.dataset?.customerInfo;
            let value = globalThis.LOADED_CUSTOMER_DATA?.get(property);

            if (!element.value === undefined) {
                return;
            }

            element.value = value;
        });
    },
};

document.addEventListener('DOMContentLoaded', async (event) => {
    let CUSTOMER_DATA = globalThis.Customer_API.CUSTOMER_DATA;
    let isLoggedIn = Boolean(CUSTOMER_DATA) && await globalThis.Customer_API.validateToken();

    if (!isLoggedIn) {
        globalThis.LoadingScreen?.show && globalThis.LoadingScreen?.show(0);

        if (!(globalThis.currentUrl?.uri || '').endsWith('customer-login.php')) {
            console.log('globalThis.getHeskURL', globalThis.getHeskURL(), globalThis.HESK_BASE_URL);
            location.href = globalThis.getHeskURL('customer-login.php');
        }

        return;
    }

    // if (!(globalThis.currentUrl?.uri || '').endsWith('ticket.php')) {
    //     location.href = globalThis.getHeskURL('ticket.php');
    // }
});

document.addEventListener('DOMContentLoaded', (event) => {
    globalThis?.LOADED_CUSTOMER_DATA?.refreshCustomerData();
    globalThis?.LOADED_CUSTOMER_DATA?.fillAllInputs();
});
console.log('END theme/hesk3/customer/js/customer-login-check.js');
