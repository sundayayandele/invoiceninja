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

namespace App\Http\ValidationRules;

use App\Models\Invoice;
use App\Utils\Traits\MakesHash;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class ValidPayableInvoicesRule
 * @package App\Http\ValidationRules
 */
class ValidPayableInvoicesRule implements Rule
{
    use MakesHash;

    /**
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    
    private $error_msg;

    public function passes($attribute, $value)
    {
        /*If no invoices has been sent, then we apply the payment to the client account*/
        $invoices = [];

        if (is_array($value)) {
            $invoices = Invoice::whereIn('id', array_column($value, 'id'))->company()->get();
        }

        foreach ($invoices as $invoice) {
            if (! $invoice->isPayable()) {
                $this->error_msg = "One or more of these invoices have been paid";
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    public function message()
    {
        return $this->error_msg;
    }
}