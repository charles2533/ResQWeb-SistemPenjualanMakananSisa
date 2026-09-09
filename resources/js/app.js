import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const DEFAULT_LOADING_TEXT = 'Memproses...';

const setButtonLoadingState = (button, isLoading) => {
    if (!button) {
        return;
    }

    if (isLoading) {
        if (!button.dataset.originalHtml) {
            button.dataset.originalHtml = button.innerHTML;
        }

        const loadingText = button.dataset.loadingText || DEFAULT_LOADING_TEXT;
        button.disabled = true;
        button.classList.add('opacity-70', 'cursor-not-allowed');
        button.innerHTML = `
            <span class="inline-flex items-center justify-center gap-2">
                <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <span>${loadingText}</span>
            </span>
        `;
        return;
    }

    button.disabled = false;
    button.classList.remove('opacity-70', 'cursor-not-allowed');

    if (button.dataset.originalHtml) {
        button.innerHTML = button.dataset.originalHtml;
    }
};

const lockForm = (form, activeButton = null) => {
    form.dataset.submitting = 'true';

    const buttons = form.querySelectorAll('button, input[type="submit"]');
    buttons.forEach((button) => {
        button.disabled = true;
        button.classList.add('opacity-70', 'cursor-not-allowed');
    });

    if (activeButton) {
        setButtonLoadingState(activeButton, true);
    }
};

const showGlobalLoading = (message) => {
    if (!window.Swal) {
        return;
    }

    window.Swal.fire({
        title: 'Mohon tunggu',
        text: message || 'Permintaan sedang diproses.',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false,
        didOpen: () => {
            window.Swal.showLoading();
        },
    });
};

const showValidationAlert = (message) => {
    if (!message) {
        return;
    }

    if (!window.Swal) {
        window.alert(message);
        return;
    }

    window.Swal.fire({
        icon: 'warning',
        title: 'Cek input dulu',
        text: message,
        confirmButtonText: 'Oke',
        customClass: {
            popup: 'rounded-3xl',
            confirmButton: 'px-6 py-2.5 rounded-xl font-bold shadow-md',
        },
    });
};

const submitProtectedForm = (form, submitter = null) => {
    if (!form || form.dataset.submitting === 'true') {
        return;
    }

    lockForm(form, submitter);
    showGlobalLoading(form.dataset.loadingMessage);
    form.submit();
};

const buildConfirmationOptions = (form) => ({
    title: form.dataset.confirmTitle || 'Yakin ingin melanjutkan?',
    text: form.dataset.confirmText || 'Data akan diproses setelah Anda konfirmasi.',
    icon: form.dataset.confirmIcon || 'question',
    showCancelButton: true,
    confirmButtonText: form.dataset.confirmButton || 'Ya, lanjutkan',
    cancelButtonText: form.dataset.cancelButton || 'Batal',
    reverseButtons: true,
    allowOutsideClick: false,
    customClass: {
        popup: 'rounded-3xl',
        confirmButton: 'px-6 py-2.5 rounded-xl font-bold shadow-md',
        cancelButton: 'px-6 py-2.5 rounded-xl font-bold',
    },
});

document.addEventListener('submit', async (event) => {
    const form = event.target;

    if (!(form instanceof HTMLFormElement)) {
        return;
    }

    if (form.dataset.submitting === 'true') {
        event.preventDefault();
        return;
    }

    if (!form.matches('[data-confirm-submit]')) {
        return;
    }

    event.preventDefault();

    const submitter = event.submitter || form.querySelector('button[type="submit"], input[type="submit"]');

    if (!window.Swal) {
        const approved = window.confirm(form.dataset.confirmText || 'Yakin ingin melanjutkan?');
        if (approved) {
            submitProtectedForm(form, submitter);
        }
        return;
    }

    const result = await window.Swal.fire(buildConfirmationOptions(form));

    if (result.isConfirmed) {
        submitProtectedForm(form, submitter);
    }
});

document.addEventListener(
    'invalid',
    (event) => {
        const field = event.target;

        if (!(field instanceof HTMLInputElement || field instanceof HTMLSelectElement || field instanceof HTMLTextAreaElement)) {
            return;
        }

        event.preventDefault();
        showValidationAlert(field.validationMessage);
    },
    true,
);
