<?php
/**
 * Invoice Ninja (https://invoiceninja.com)
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2019. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

namespace App\Jobs\Invoice;

use App\Jobs\Invoice\InvoiceNotification;
use App\Jobs\Payment\PaymentNotification;
use App\Models\Invoice;
use App\Repositories\InvoiceRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StoreInvoice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $invoice;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, array $data)
    {

        $this->invoice = $invoice;

        $this->data = $data;

    }

    /**
     * Execute the job.
     *
     *  We expect the Invoice object along with
     *  the request in array form
     *
     *  Embedded in the request may be additionals
     *  attributes which require additional work to be 
     *  done in this job, these include - but are not limited to:
     *
     *  1. email_invoice - Email the Invoice
     *  2. mark_paid - Mark the invoice as paid (Generates a payment against the invoice)
     *  3. ......
     * 
     * @return NULL|Invoice
     */
    public function handle(InvoiceRepository $invoice_repo) : ?Invoice
    {

        $payment = false;

        /* Test if we should auto-bill the invoice */
        if((bool)$this->invoice->settings->auto_bill)
        {

           $this->invoice = $invoice_repo->markSent($this->invoice);

           //fire autobill - todo - the PAYMENT class will update the INVOICE status.
           // $payment = 
           
        }

        if(isset($this->data['email_invoice']) && (bool)$this->data['email_invoice'])
        {

            $this->invoice = $invoice_repo->markSent($this->invoice);

            //fire invoice job (the job performs the filtering logic of the email recipients... if any.)
            InvoiceNotification::dispatch($invoice);

        }

        if(isset($this->data['mark_paid']) && (bool)$this->data['mark_paid'])
        {

            $this->invoice = $invoice_repo->markSent($this->invoice);

            // generate a manual payment against the invoice
            // the PAYMENT class will update the INVOICE status.
            //$payment =             

        }

        /* Payment Notifications */
        if($payment)
        {
            //fire payment notifications here
            PaymentNotification::dispatch($payment);
            
        }

        if(isset($data['download_invoice']) && (bool)$this->data['download_invoice'])
        {
            //fire invoice download and return PDF response from here
        }

        return $this->invoice;

    }
}