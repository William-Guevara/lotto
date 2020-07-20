<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionDenyClient extends Mailable
{
    use Queueable, SerializesModels;

	public $transaction;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transactionApplicant)
    {
        $this->transaction = $transactionApplicant;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
			->from('notificaciones@trazway.com')
            ->subject('Trazway - Solicitud rechazada!')
			->view('mail.TransactionDenyClient')
			->with(['info' => $this->transaction]);
    }
}
