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

document.addEventListener('DOMContentLoaded', (event) => {
    console.log('uri', globalThis.currentUrl.uri);
    console.log('uriIn()', globalThis.currentUrl.uriIn(['/customer-login.php', 'customer-login.php',]));
    console.log('DOMContentLoaded', globalThis.CustomerAuth.auth_token);
});
