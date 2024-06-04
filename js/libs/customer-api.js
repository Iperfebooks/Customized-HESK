globalThis.Customer_API = {
    get BASE_API() {
        return globalThis.CUSTOMER_API_BASE_URL;
    },
    get API_TOKEN() {
        try {
            let access_token = localStorage.getItem('customer_access_token') || null;

            if (!access_token || typeof access_token !== 'string') {
                return null;
            }

            access_token = JSON.parse(access_token || '{}') || {};

            return access_token?.token || null;
        } catch (error) {
            return null;
        }
    },
    get CUSTOMER_DATA() {
        try {
            let customer_data = localStorage.getItem('customer_data') || null;

            if (!customer_data || typeof customer_data !== 'string') {
                return null;
            }

            customer_data = JSON.parse(customer_data || '{}') || {};

            return customer_data || null;
        } catch (error) {
            return null;
        }
    },
    async logout() {
        if (!this.API_TOKEN) {
            console.log('this.API_TOKEN', this.API_TOKEN);
            this.invalidateToken('Token inválido');
            return;
        }

        fetch(this.getUrl('/customers/auth/logout'), {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${this.API_TOKEN}`,
            }
        }).then(response => {
            this.invalidateToken();
        })
    },
    async updatePassword(formData) {
        if (!this.API_TOKEN) {
            console.log('this.API_TOKEN', this.API_TOKEN);
            this.invalidateToken('Token inválido');
            return;
        }

        if (
            !formData
            || typeof formData !== 'object'
            || Array.isArray(formData)
        ) {
            console.log('Invalid form data');
            return null;
        }

        return await fetch(this.getUrl('/customers/auth/update-password'), {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${this.API_TOKEN}`,
            },
            body: JSON.stringify(formData),
        });
    },
    getUrl(uri = '') {
        let str_trim_slashes = globalThis?.Helpers?.str_trim_slashes || ((string) => string.trim().replaceAll(/^\/|\/$/ig, ''));
        let url = new URL(this.BASE_API);
        uri = uri && typeof uri === 'string' && uri.trim() ? uri.trim() : '';

        return [
            url.href,
            (uri ? `${uri}` : ''),
        ]
        .map(item => str_trim_slashes(item))
        .filter(item => item)
        .join('/');
    },
    async validateToken() {
        if (!this.API_TOKEN) {
            console.log('this.API_TOKEN', this.API_TOKEN);
            this.invalidateToken('Token inválido');
            return false;
        }

        try {
            let response = await fetch(this.getUrl('/customers/auth/me'), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.API_TOKEN}`,
                }
            });

            if (!response?.ok && response?.status === 401) {
                this.invalidateToken('Não autenticado');

                return false;
            }

            let data = response ? (await response?.json() || {}) : {};

            if (!data || data?.message && data?.message === 'Unauthenticated') {
                this.invalidateToken('Não autenticado');
                return false;
            }

            return true;
        } catch (error) {
            // this.invalidateToken('Erro desconhecido');
            console.error(error);
            return false;
        }
    },
    invalidateToken(message = null) {
        localStorage.removeItem('customer_access_token');
        localStorage.removeItem('customer_data');
        console.log('this.getHeskURL', this.getHeskURL());
        location.href = this.getHeskURL('customer-login.php');

        if (message) {
            console.log('invalidateToken message', message);
        }
    },
    getHeskURL(uri) {
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
    },
};
