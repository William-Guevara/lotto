<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductRequest extends Mailable
{
    use Queueable, SerializesModels;

	public $productTransfer;
	
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($productTransfer)
    {
		$this->productTransfer = $productTransfer;
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
			->view('mail.productRequest')
			->with(['info' => $this->productTransfer]);
    }
}
