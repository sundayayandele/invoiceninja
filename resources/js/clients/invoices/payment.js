/**
 * Invoice Ninja (https://invoiceninja.com)
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2020. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

class Payment {
    constructor(displayTerms, displaySignature) {
        this.shouldDisplayTerms = displayTerms;
        this.shouldDisplaySignature = displaySignature;
        this.termsAccepted = false;
    }

    handleMethodSelect(element) {

        if (this.shouldDisplaySignature && !this.shouldDisplayTerms) {
            this.displayTerms();

            document.getElementById('accept-terms-button').addEventListener('click', () => {
                this.termsAccepted = true;
                this.submitForm();
            });
        }

        if (!this.shouldDisplaySignature && this.shouldDisplayTerms) {
            this.displaySignature();

            document.getElementById('signature-next-step').addEventListener('click', () => {
                this.submitForm();
            });
        }

        if (this.shouldDisplaySignature && this.shouldDisplayTerms) {
            this.displaySignature();

            document.getElementById('signature-next-step').addEventListener('click', () => {
                this.displayTerms();

                document.getElementById('accept-terms-button').addEventListener('click', () => {
                    this.termsAccepted = true;
                    this.submitForm();
                });
            });
        }

        if (!this.shouldDisplaySignature && !this.shouldDisplayTerms) {
            this.submitForm();
        }
    }

    submitForm() {
        document.getElementById('payment-form').submit();
    }

    displayTerms() {
        let displayTermsModal = document.getElementById('displayTermsModal');
        displayTermsModal.removeAttribute('style');
    }

    displaySignature() {
        let displaySignatureModal = document.getElementById('displaySignatureModal');
        displaySignatureModal.removeAttribute('style');

        const signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
            backgroundColor: 'rgb(240,240,240)',
            penColor: 'rgb(0, 0, 0)'
        });
    }

    handle() {
        document.querySelectorAll('.dropdown-gateway-button').forEach((element) => {
            element.addEventListener('click', () => this.handleMethodSelect(element));
        });
    }
}

const signature = document.querySelector(
    'meta[name="require-invoice-signature"]'
).content;

const terms = document.querySelector(
    'meta[name="show-invoice-terms"]'
).content;

new Payment(Boolean(+signature), Boolean(+terms)).handle();

