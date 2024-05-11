<?php
/**
 *
 * This file is part of HESK - PHP Help Desk Software.
 *
 * (c) Copyright Klemen Stirn. All rights reserved.
 * https://www.hesk.com
 *
 * For the full copyright and license agreement information visit
 * https://www.hesk.com/eula.php
 *
 */
define('IN_SCRIPT',1);
define('HESK_PATH','./');

// Get all the required files and functions
require(HESK_PATH . 'hesk_settings.inc.php');
define('TEMPLATE_PATH', HESK_PATH . "theme/{$hesk_settings['site_theme']}/");
require_once HESK_PATH . 'inc/common.inc.php';

// Are we in maintenance mode?
hesk_check_maintenance();

// Are we in "Knowledgebase only" mode?
hesk_check_kb_only();

if (is_file(HESK_PATH . 'inc/customer_ticket_common.inc.php')) {
    require_once HESK_PATH . 'inc/customer_ticket_common.inc.php';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $hesk_settings['hesk_title']; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo HESK_PATH; ?>img/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo HESK_PATH; ?>img/favicon/favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo HESK_PATH; ?>img/favicon/favicon-16x16.png" />
    <link rel="manifest" href="<?php echo HESK_PATH; ?>img/favicon/site.webmanifest" />
    <link rel="mask-icon" href="<?php echo HESK_PATH; ?>img/favicon/safari-pinned-tab.svg" color="#5bbad5" />
    <link rel="shortcut icon" href="<?php echo HESK_PATH; ?>img/favicon/favicon.ico" />
    <meta name="msapplication-TileColor" content="#2d89ef" />
    <meta name="msapplication-config" content="<?php echo HESK_PATH; ?>img/favicon/browserconfig.xml" />
    <meta name="theme-color" content="#ffffff" />
    <meta name="format-detection" content="telephone=no" />
    <?php require_once HESK_PATH . 'inc/custom_header.inc.php'; ?>
    <link rel="stylesheet" media="all" href="<?php echo TEMPLATE_PATH; ?>customer/css/app<?php echo $hesk_settings['debug_mode'] ? '' : '.min'; ?>.css?<?php echo $hesk_settings['hesk_version']; ?>" />
    <?= customer_login_check() ?>
    <!-- customer-login.php -->
</head>
<body>
<div class="main__content">
    <div class="contr">
        <div style="margin-bottom: 20px;"> </div>
        <h3 class="article__heading article__heading--form">
            <span class="ml-1">Login</span>
        </h3>
        <form
            name="customer-login-form"
            id="formNeedValidation"
            class="form form-submit-ticket ticket-create"
            novalidate=""
            action="customer-login-request.php" method="post"
        >
            <section class="form-groups centered">
                <div class="form-group required">
                    <label class="label">E-mail</label>
                    <input type="email" class="form-control" name="email" placeholder="E-mail" required>
                    <div class="form-control__error">Este campo é requerido.</div>
                </div>

                <div class="form-group required">
                    <label class="label">Senha</label>
                    <input class="form-control" type="password" name="password" placeholder="Senha" required>
                    <div class="form-control__error">Este campo é requerido.</div>
                </div>
            </section>

            <div class="form-footer">
                <button type="submit" class="btn btn-full" ripple="ripple">Login<div class="ripple--container"></div></button>
                <a href="ticket.php?forgot=1#modal-contents" data-modal="#forgot-modal" class="link">Esqueceu sua senha?</a>
            </div>
        </form>
        <!-- BEGIN Lista de chamados -->
    </div>
</div>
<script>
    document.querySelector('form[name="customer-login-form"]')?.addEventListener('submit', event => {
        event.preventDefault();
        event.stopImmediatePropagation();

        let inputs = [];
        event.target?.querySelectorAll('[name]')?.forEach(input => {
            inputs.push(input);
        });

        let invalidInputs = inputs.filter(input => !input?.validity?.valid) || [];

        invalidInputs?.forEach(invalidInput => {
            let message = 'Campo ' + (invalidInput?.placeholder || invalidInput?.name) + ' inválido!';

            message && toast.error && toast.error(message);
        });

        if (invalidInputs?.length) {
            return;
        }

        let formData = {};

        inputs.forEach(input => {
            let name = input.name;
            if (!name || typeof name !== 'string' || !name.trim()) {
                return;
            }

            name = name.trim();

            formData[name] = input.value;
        });

        let getHeskURL = (uri) => {
            let url = new URL(location.origin);
            uri = uri && typeof uri === 'string' && uri.trim() ? uri.trim() : '';
            url.pathname = uri;
            return url;
        }

        fetch(`${globalThis.CUSTOMER_API_BASE_URL}/customers/auth/login`, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            })
            ?.then(response => response.json && response.json())
            ?.then(data => {
                let error = data && (!data?.success || data.error) ? data.error : null;
                let errors = data && (!data?.success || data.errors) ? data.errors : null;

                if (errors && (typeof errors === 'object' && !Array.isArray(errors))) {
                    for ([inputName, errorMessage] of Object.entries(errors)) {
                        console.log('event.target', event.target);
                        event.target?.querySelectorAll(`[name="${inputName}"]`)?.forEach(input => {
                            console.log('input', input);

                            if (input) {
                                input.classList.add('form-input-error');

                                event.target?.querySelectorAll(
                                    `.form-group .form-control.form-input-error[name="${inputName}"] + .form-control__error`
                                )?.forEach(errorMessageElement => {
                                    errorMessageElement.innerText = errorMessage;
                                    errorMessageElement.style.display = 'block';
                                });
                            }
                        });
                        error && toast.error && toast.error(errorMessage);
                    }
                }

                if (data && data?.success && data?.access_token && data?.access_token?.token) {
                    console.log('login reponse data', data);
                    let access_token = data?.access_token || null;

                    if (!access_token) {
                        localStorage.removeItem('customer_access_token');
                        return;
                    }

                    localStorage.setItem('customer_access_token', JSON.stringify(access_token));
                    localStorage.setItem('customer_data', data?.customer ? JSON.stringify(data?.customer) : '');

                    location.href = getHeskURL('/');

                    return;
                }

                console.log('data', data);
            })
            ?.catch(error => {
                console.log('error', error);
                // message && toast.error && toast.error(message);
            });
    });
</script>
</body>
</html>
