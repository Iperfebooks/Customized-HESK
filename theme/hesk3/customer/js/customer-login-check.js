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

    get auth_user() {
        return {
            id: 123,
            name: 'Fulano de Tal',
            email: 'teste@teste.com',
        } || null;
    },
}

globalThis.getHeskURL = (uri) => {
    let url = new URL(location.origin);
    uri = uri && typeof uri === 'string' && uri.trim() ? uri.trim() : '';
    url.pathname = uri;
    return url;
}

document.addEventListener('DOMContentLoaded', async (event) => {
    let isLoggedIn = globalThis.Customer_API.CUSTOMER_DATA && await globalThis.Customer_API.validateToken();

    console.log('isLoggedIn', isLoggedIn);

    if (!isLoggedIn) {
        globalThis.LoadingScreen?.show && globalThis.LoadingScreen?.show(0);
        console.log('Logoff', isLoggedIn);

        if (!globalThis.currentUrl.uriIn(['/customer-login.php', 'customer-login.php',])) {
            location.href = getHeskURL('customer-login.php');
        }

        return;
    }

    // console.log('uri', globalThis.currentUrl.uri);
    // console.log('uriIn()', globalThis.currentUrl.uriIn(['/customer-login.php', 'customer-login.php',]));
    // console.log('DOMContentLoaded', globalThis.CustomerAuth.auth_token);
    location.href = getHeskURL('/ticket.php');
});
