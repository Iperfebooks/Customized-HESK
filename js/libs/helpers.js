globalThis.Helpers = globalThis.Helpers || {
    str_trim(string, left = ' ', right = ' ') {
        string = typeof string === 'string' ? string : null;
        left = typeof left === 'string' ? left : null;
        right = typeof right === 'string' ? right : null;

        left = left ? `^([${left}]){1,}` : null;
        right = right ? `([${right}]){1,}$` : null;
        //   regex = /^([ /]){1,}|([ /]){1,}$/ig;

        let regex = [left, right].filter(item => item);

        if (!regex.length) {
            return string;
        }

        regex = new RegExp(regex.join('|'), 'ig');
        return string.replaceAll(regex, ''); // trim customizado
    },
};

globalThis.Helpers['str_ltrim'] = (string, left = ' ') => globalThis.Helpers['str_trim'](string, left, null);
globalThis.Helpers['str_rtrim'] = (string, right = ' ') => globalThis.Helpers['str_trim'](string, null, right);
globalThis.Helpers['str_atrim'] = (string, trimValue = ' ') => globalThis.Helpers['str_trim'](string, trimValue, trimValue);
globalThis.Helpers['str_trim_slashes'] = (string) => {
    if (!string || typeof string !== 'string') {
        return '';
    }

    return string.trim().replaceAll(/^\/|\/$/ig, '')
}
