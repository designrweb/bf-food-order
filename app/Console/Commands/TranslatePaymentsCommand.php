<?php

namespace App\Console\Commands;

use App\Payment;
use Illuminate\Console\Command;

class TranslatePaymentsCommand extends Command
{
    protected $signature = 'payments:translate';

    protected $description = 'Translate payment comment to German';

    /**
     * Single time action
     */
    public function handle()
    {
        foreach (Payment::all() as $payment) {
            $comment          = str_replace(['Canceled', 'Order', 'Quantity', 'Subsidization'], ['Abgebrochen', 'Bestellen', 'Menge', 'Subventionierung'], $payment->comment);
            $payment->comment = $comment;
            $payment->save();
        }
    }
}
