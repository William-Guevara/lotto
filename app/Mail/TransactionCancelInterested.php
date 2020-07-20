<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionCancelInterested extends Mailable
{
    use Queueable, SerializesModels;

	public $transactionApplicant;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transactionApplicant)
    {
        $this->transactionApplicant = $transactionApplicant;
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
            ->subject('Trazway - Solicitud cancelada!')
			->view('mail.transactionCancelInterested')
			->with(['info' => $this->transactionApplicant]);
    }
}
