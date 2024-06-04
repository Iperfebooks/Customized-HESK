<style>
[data-form-uid="update-password-form"] .form-control__error.show {
    display: block;
}
[data-form-uid="update-password-form"] .btn.btn--blue-border.disabled {
    background: #6c6c6c40 !important;
}
</style>
<form
    x-data="updatePassword"
    method="post"
    x-on:submit.capture.prevent.stop="onSubmit"
>
    <div class="form">
        <div class="form-group required">
            <label class="label" for="password_confirmation">Nova senha</label>

            <input
                x-model="password"
                id="password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="form-control"
                value=""
                required
            />
            <div
                class="form-control__error"
                x-text="errors?.password"
                x-bind:class="{
                    show: errors?.password,
                }"
            ></span>
        </div>

        <div class="form-group required">
            <label class="label" for="password_confirmation">Repita a nova senha</label>

            <input
                x-model="password_confirmation"
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="form-control"
                value=""
                required
            />
            <div
                class="form-control__error"
                x-text="errors?.password_confirmation"
                x-bind:class="{
                    show: errors?.password_confirmation,
                }"
            ></span>
        </div>
    </div>

    <div>
        <ul>
            <li
                class="form-control__error"
                x-show="password && !passwordLengthIsGood"
                x-bind:class="{
                    show: password && !passwordLengthIsGood,
                }"
            >As senha precisa ter 8 ou mais caracteres</li>
            <li
                class="form-control__error"
                x-show="password && !passwordIsMatch"
                x-bind:class="{
                    show: password && !passwordIsMatch,
                }"
            >As senhas não coincidem</li>
        </ul>
    </div>

    <div>
        <button
            type="submit"
            class="btn btn--blue-border"
            x-bind:disabled="!canSubmit"
            x-bind:class="{
                disabled: !canSubmit,
            }"
        >Update password</button>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('updatePassword', () => ({
                errors: {},
                errorMessage: '',
                successMessage: '',
                password: '',
                password_confirmation: '',
                get passwordIsMatch() {
                    return this?.password && this?.password_confirmation
                        && this?.password === this?.password_confirmation;
                },
                get passwordLengthIsGood() {
                    return this?.password?.length >= 8;
                },
                get canSubmit() {
                    return this.passwordIsMatch && this.passwordLengthIsGood;
                },
                async updatePassword(formData) {
                    if (!globalThis?.Customer_API) {
                        console.log('globalThis?.Customer_API', globalThis?.Customer_API);
                        return;
                    }

                    if (
                            !formData
                            || typeof formData !== 'object'
                            || Array.isArray(formData)
                    ) {
                        console.log('globalThis?.Customer_API', globalThis?.Customer_API);
                        return;
                    }

                    if (!globalThis?.Customer_API?.updatePassword) {
                        return;
                    }

                    return await globalThis?.Customer_API?.updatePassword(formData)
                        ?.then((r) => r.json())
                        ?.catch(error => {
                            console.error(error);
                        }) || {};
                },
                get modalElement() {
                    let modalElement = document.querySelector(
                        '[data-form-uid="update-password-form"]'
                    );

                    if (!modalElement) {
                        return null;
                    }

                    return modalElement;
                },
                closeModal() {
                    if (!this.modalElement) {
                        return;
                    }

                    let customModalClose = this.modalElement?.querySelector('.custom-modal-close');

                    if (!customModalClose) {
                        return;
                    }

                    this.password = '';
                    this.password_confirmation = '';

                    customModalClose?.click();
                },
                async onSubmit(event) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    let result = await this.updatePassword({
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    });

                    let { errors, message, success } = result || {};

                    this.errors = errors || {};
                    this.errorMessage = '';
                    this.successMessage = '';

                    if (errors && Object.keys(errors).length) {
                        this.errorMessage = errors?.password[0] || message || '';
                    }

                    this.successMessage

                    if (success) {
                        this.successMessage = message;
                    }

                    if (this.successMessage) {
                        this.closeModal();
                        globalThis?.toast?.success && globalThis?.toast?.success(this.successMessage, 15000);
                    }
                },
            }));
        })
    </script>
</form>
