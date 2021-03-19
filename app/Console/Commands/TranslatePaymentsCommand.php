<?php

namespace App\Console\Commands;

use App\Payment;
use Illuminate\Console\Command;

class TranslatePaymentsCommand extends Command
{
    protected $signature = 'payments:translate';

    protected $description = 'Translate payment comment to German';

    public function handle()
    {
        foreach (Payment::all() as $payment) {
            $comment          = str_replace('Canceled', 'Abgebrochen', $payment->comment);
            $payment->comment = $comment;
//            $payment->save();
        }
    }
}
