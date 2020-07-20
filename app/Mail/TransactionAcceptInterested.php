<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionAcceptInterested extends Mailable
{
    use Queueable, SerializesModels;

	public $transactionApplicant;
    public $infoFacility;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transactionApplicant, $infoFacility)
    {
        $this->transactionApplicant = $transactionApplicant;
        $this->infoFacility = $infoFacility;
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
            ->subject('Trazway - Solicitud aceptada!')
			->view('mail.transactionAcceptInterested')
			->with(['info' => $this->transactionApplicant, 'facility' => $this->infoFacility]);
    }
}
